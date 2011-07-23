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
	function &getList()
	{
		$db =& JFactory::getDbo();
		
		$query = "SELECT * FROM #__content WHERE state = 1 AND featured = 1";
		$db->setQuery($query);
		
		$result = $db->loadObjectList();
		
		return $result;
	}
}