<?php
/**
 * @version		$Id: category.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * @package		Joomla.Site
 * @subpackage	com_contact
 */
class Jnt_HanhPhucModelServices extends JModelList {

	/**
	 * Constructor.
	 * @param	array	An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 * @since	1.6
	 */
	protected function getListQuery() {
		$id = JRequest::getInt('id', 0);
		$query = "SELECT s.*, c.id as cat_id, c.title as cat_title 
				  FROM  #__hp_business_service s 
				  	  	JOIN #__categories c ON s.category = c.id 
				  WHERE c.published = 1 AND s.state = 1 AND c.id = ".$id;
        return $query;
	}
	
	
	public function getCategory($id = 0) {
		if(!$id) $id = JRequest::getInt('id', 0);
		$db = JFactory::getDbo();
		$db->setQuery(
			'SELECT * FROM #__categories WHERE published = 1 AND id = '.$id
		);
		return $db->loadObject();
	}
	
	/**
	 * Method to get an array of data items.
	 *
	 * @return	mixed	An array of data items on success, false on failure.
	 * @since	1.6
	 */
	public function getItems() {
		$serviceInfos = parent::getItems();
		$businessInfos = array();
		
		$introModel = JModel::getInstance('Intro', 'Jnt_HanhPhucModel');
		foreach($serviceInfos as $serviceInfo) {
			$businessInfo = $introModel->getBusinessInfo($serviceInfo->business_id);
			$businessInfos[] = $businessInfo;
		}
		return $businessInfos;
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null) {
		parent::populateState($ordering, $direction);
	}
}
