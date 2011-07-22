<?php
# @version $Id: components/com_apoll/models/config.php 
# @package: Apoll Vote
# ===================================================
# @author
# Name: Hristo Genev
# Email: harrygg@gmail.com
# Url: http://www.afactory.org
# ===================================================
# @copyright Copyright (C) 2008 aFactory.org All rights reserved.
# @license see http://www.gnu.org/licenses/lgpl.html GNU/LGPL.
# You can use, redistribute this file and/or modify
# it under the terms of the GNU Lesser General Public License as published by
# the Free Software Foundation.
# License http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL, see LICENSE.php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
* @package		Joomla
* @subpackage	Polls
*/
class ApollsModelConfig extends JModel
{
	var $_data = null;

	function getData()
	{
		$db	=& JFactory::getDBO();
		$query = "SELECT " . $db->nameQuote('drop_it') . " FROM #__apoll_config";
		$db->setQuery($query);
		$this->_data = $db->loadResult();	

		return $this->_data;
	}
	
	function save() 
	{
		
		$db		=& JFactory::getDBO();
		$drop 	=  JRequest::getVar('drop', 0, 'POST', 'INT');
		
		$query = "UPDATE ".$db->nameQuote('#__apoll_config')."
				SET ".$db->nameQuote('drop_it')."=".(int)$drop;

		$db->setQuery($query);
		if (!$db->query()) {
			JError::raiseError ($db->stderr());
			return false;
		}
		return true;
	}
	
	function getApolls()
	{
		$db		=& JFactory::getDBO();
		
		$query = "SELECT COUNT(id) FROM ".$db->nameQuote('#__apoll_polls');	
		$db->setQuery($query);
		if($result = $db->loadResult()) {
			return $result;
		} else {
			return false;
		}
	}	
	function getJpolls()
	{
		$db		=& JFactory::getDBO();
		
		$query = "SELECT COUNT(id) FROM ".$db->nameQuote('#__polls');	
		$db->setQuery($query);
		if($result = $db->loadResult()) {
			return $result;
		} else {
			return false;
		}
	}	
	
	/**
	* Function to import polls from joomla poll component
	* 1. Copy #__polls table with all polls to #__apoll_polls
	* 2. Get the id of the first newly created poll
	* 3. Get all polls' ids from #__polls table and push the into an array
	* 4. Copy the options from #__poll_data to #__apoll_options
	* 5. Generate random color for each options
	* 6. Correct apoll_id of the options
	* 7. Copy votes from #__poll_date to #__apoll_votes
	* 8. Correct apoll_id field of all votes
	*/

	function import()
	{

		$db		=& JFactory::getDBO();
		//import the polls table
		$query = "
		INSERT INTO " . $db->nameQuote('#__apoll_polls') . " 
		(title, alias, checked_out, checked_out_time, published, params, access, lag) 
		SELECT title, alias, checked_out, checked_out_time, 0, 'only_registered=0\none_vote_per_user=1\nip_check=0\nshow_component_msg=1\nallow_voting=1\nshow_what=1\nshow_hits=1\nshow_title=1\nshow_dropdown=1\nshow_voters=1\nshow_times=1\nopacity=90\nbg_color=ffffff\ncircle_color=505050\npieX=100%\npieY=400\nstart_angle=55\nradius=150\ngradient=1\nno_labels=0\nshow_zero_votes=1\nanimation_type=bounce\nbounce_dinstance=30\nbg_image=-1\nbg_image_x=left\nbg_image_y=top\nfont_size=11\nfont_color=404040\ntitle_lenght=30\nchartX=100%\noptionsFontSize=12\nbarHeight=15\nbarBorder=1px solid #000000\nbgBarColor=f5f5f5\nbgBarBorder=1px solid #cccccc\n', access, lag/60 
		FROM " . $db->nameQuote('#__polls') . " ;"; 
		
		$db->setQuery( $query );
		if(!$db->query()) return false;
		//get the first new id of the imported polls
		$new_id = $db->insertid();

		//get the native polls ids and put them in an array 
		$query = "SELECT id FROM ". $db->nameQuote('#__polls');
		$db->setQuery($query);
		$old_ids = $db->loadResultArray();

		//copy the options table
		$query = "INSERT INTO " . $db->nameQuote('#__apoll_options') . " (apoll_id, text, color) 
		SELECT pollid, text, 'cccccc'
		FROM " . $db->nameQuote('#__poll_data') . " 
		WHERE text <>'';"
		;
		
		$db->setQuery( $query );
		if(!$db->query()) return false;
		//get the id of the first option
		$new_option_id = $db->insertid();
		//get how many polls are imported
		$n = $db->getAffectedRows();
		
		//generate random color for each new option
 		$id = $new_option_id;
		for ($i=0; $i<$n; $i++) {
			$query = "UPDATE ". $db->nameQuote('#__apoll_options')." 
			SET color = '". $this->random_color() ."' 
			WHERE id = ".$id;
			$id++;
			$db->setQuery( $query );
			$db->query();
		}

		
		$query = "";
		//correct apoll_ids of options and generate random colors
		$id = $new_id;
		foreach ($old_ids as $value) {
			$query = "UPDATE " . $db->nameQuote('#__apoll_options') . " 
			SET apoll_id = ". $id ."
			WHERE apoll_id = ". $value . ";";
			$id++;
		
			$db->setQuery( $query );
			$db->query();		
		}
		
		//copy the votes table
		$query = "INSERT INTO ". $db->nameQuote('#__apoll_votes')." (date, apoll_id, option_id) 
		SELECT date, poll_id, vote_id 
		FROM " . $db->nameQuote('#__poll_date') . ";"
		;
		$db->setQuery( $query );
		if(!$db->query()) 
			return false;		

		$query = "";
		//correct apoll_ids of votes 
		$id = $new_id; //reset the id
		foreach ($old_ids as $value) {
			$query = "UPDATE " . $db->nameQuote('#__apoll_votes') . " 
			SET apoll_id = " . $id . "
			WHERE apoll_id = " . $value. ";";
			$id++;
		
			$db->setQuery( $query );
			$db->query();	
		}
		
		//correct apoll_ids of votes
		$query = "";
		//put all old ids of old options from #__poll_data table in array
		$query = "SELECT id FROM " . $db->nameQuote('#__poll_data') . " WHERE text <> ''";
		$db->setQuery($query);
		$old_option_ids = $db->loadResultArray();
		
		$id = $new_option_id;
		foreach ($old_option_ids as $value) {
			$query = "UPDATE " . $db->nameQuote('#__apoll_votes') . " 
			SET option_id = $id
			WHERE option_id = $value;";
			$id++;
		
			$db->setQuery( $query );
			$db->query();		
		}
		return true;

	}
	
	// random color generator
	function random_color(){
		mt_srand((double)microtime()*1000000);
		$c = '';
		while(strlen($c)<6){
			$c .= sprintf("%02X", mt_rand(0, 255));
		}
		return $c;
	}	
	
	
	function getJoomfishInstalled() {
		if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'config.xml'))
			return true;
		return false;
	}	
	
	function getApollFilesInstalled() {
		if (file_exists(JPATH_ADMINISTRATOR.DS."components".DS."com_joomfish".DS."contentelements".DS."apoll_polls.xml") && file_exists(JPATH_ADMINISTRATOR.DS."components".DS."com_joomfish".DS."contentelements".DS."apoll_options.xml"))
			return true;
		return false;
	}
	function getApollFilesPresent() {
		if (file_exists(JPATH_ADMINISTRATOR.DS."components".DS."com_apoll".DS."joomfish".DS."apoll_polls.xml") && file_exists(JPATH_ADMINISTRATOR.DS."components".DS."com_apoll".DS."joomfish".DS."apoll_options.xml"))
			return true;
		return false;
	}
	
	function copyJoomfishFiles() {
		//copy the files from com_apoll/joomfish to com_joomfish/contentelements and remove dir com_apoll/joomfish
		if((@rename(JPATH_ADMINISTRATOR.DS."components".DS."com_apoll".DS."joomfish".DS."apoll_polls.xml", JPATH_ADMINISTRATOR.DS."components".DS."com_joomfish".DS."contentelements".DS."apoll_polls.xml")) 
		&& 
		(@rename(JPATH_ADMINISTRATOR.DS."components".DS."com_apoll".DS."joomfish".DS."apoll_options.xml", JPATH_ADMINISTRATOR.DS."components".DS."com_joomfish".DS."contentelements".DS."apoll_options.xml")) 
		&& 
		(@rmdir (JPATH_ADMINISTRATOR.DS."components".DS."com_apoll".DS."joomfish")))	
		{
			return true;
		}
		return false;
	}
}
?>
