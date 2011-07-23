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

class modHpCategoriesHelper
{
	function getListCategories($cid = 0, $params)
	{
		$id = JRequest::getInt('category_id');
		
		//get database
		$db		= JFactory::getDbo();
		
		$query	= $db->getQuery(true);
		
		$query->select('id, parent_id, title');
		$query->from('#__categories');
		$query->where('published = 1 AND extension = "com_content" AND parent_id = "1"');
		$query->order('lft ASC');
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
		$contentId = JRequest::getInt('id', 0);
		
		$categoryInfo = new stdClass();
		
		if($contentId)
		{
			$categoryInfo = self::getCategoryInfoFromContentDetail(); 
		}
		else
		{
			$categoryInfo->parent_id = 0;
		}
		
		foreach($rows as & $row)
		{
			
			//get parent id
			$query = "	SELECT * FROM #__categories 
						WHERE (	parent_id = '".$row->id."' 
									#OR parent_id = (SELECT parent_id FROM #__categories WHERE id='$cid' AND parent_id > 1)
									#OR parent_id = ".$categoryInfo->parent_id."
								) 
								AND published = 1 AND extension = 'com_content'
						ORDER BY lft ASC								
					";
			
			$db->setQuery($query);
			$row->subCategories = $db->loadObjectList();
		}
		
		return $rows;
	}
	
	function getCategoryInfo($cId)
	{
		$db		= JFactory::getDbo();
		
		$query = "SELECT * FROM #__categories WHERE id = '$cId'";
		$db->setQuery($query);
		
		$result = $db->loadObjectList();
		
		return $result[0];
	}
	
	function getCategoryInfoFromContentDetail()
	{
		$id = JRequest::getInt('id');
		
		if(!$id) return ;
		
		$db		= JFactory::getDbo();
		
		$query = "SELECT * FROM #__content WHERE id = '$id'";
		$db->setQuery($query);
		
		$result = $db->loadObjectList();
		
		$categoryInfo = self::getCategoryInfo($result[0]->catid);
		
		return $categoryInfo;
	}
}
