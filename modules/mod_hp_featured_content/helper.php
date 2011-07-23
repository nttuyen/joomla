<?php
/**
 * @version		$Id: helper.php 22-05-2010
 * @package		Joomla.Site
 * @subpackage	mod_ttol_categories
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class modHpFeaturedContentHelper
{
	function getListContent($cid = 0, $limit = 10, $latest = false)
	{
		//get database
		$db		= JFactory::getDbo();
		
		$query = "SELECT * FROM #__content WHERE state = 1";
		
		if(!$latest)
			$query .= "  AND featured = 1 ";
		
		if($cid)
			$query .= " AND (catid = '$cid' OR catid IN (SELECT id FROM #__categories WHERE parent_id = '$cid'))";
			
		$query .= " ORDER BY id DESC LIMIT $limit";
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
		return $rows;
	}
	
	function getCategoryId($itemId = 0)
	{
		//get database
		$db		= JFactory::getDbo();
		
		$query = "SELECT * FROM #__content WHERE state = 1 AND id = '$itemId'";		
		$db->setQuery($query);
		
		$rows = $db->loadObjectList();
		
		if($rows)
			return $rows[0]->catid;
		else
			return false;
	}
}