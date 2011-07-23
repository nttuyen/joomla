<?php
/**
 * @version		$Id: helper.php 17975 2010-06-30 11:07:29Z ian $
 * @package		Joomla.Site
 * @subpackage	mod_banners
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class modFeaturedArticlesHelper
{
	function getList($featured = true)
	{
		$db =& JFactory::getDbo();
		
		$query = "	SELECT a.*, c.alias AS category_alias 
					FROM #__content a 
					JOIN #__categories c ON a.catid = c.id 
					WHERE a.state = 1";
		
		if($featured)
			$query .= " AND a.featured = 1 ";
			
		$query .= " ORDER BY a.id DESC LIMIT 7";
		
		$db->setQuery($query);
		
		$result = $db->loadObjectList();
		
		foreach ($result as & $item)
		{
			$item->slug = $item->id.':'.$item->alias;
			$item->catslug = $item->catid ? $item->catid .':'.$item->category_alias : $item->catid;
			
			//$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
            $alias = isset($item->alias) ? $item->alias : mainHelper::convertUnicode($item->title).'.html';
            $item->link = "index.php/".$item->id.'-'.$alias.'.html';
		}
		
		return $result;
	}
}
