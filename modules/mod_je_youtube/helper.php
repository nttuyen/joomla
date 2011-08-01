<?php
/**
 * @version		$Id: helper.php 21421 2011-06-03 07:21:02Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	mod_login
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class modJeYoutubeHelper {
	public static function getList($params) {
		$number = $params->get('number', 10);
		$db = JFactory::getDbo();
		$db->setQuery('
			SELECT 
				v.* 
			FROM 
				#__je_youtube v 
			ORDER BY v.id desc
			LIMIT '.$number.'
		');
		$result = $db->loadObjectList();
		return $result;
	}
}
