<?php
/**
 * @version		$Id: helper.php 20805 2011-02-21 19:41:07Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package		Joomla.Site
 * @subpackage	mod_menu
 * @since		1.5
 */
class modHanhPhucServiceCategoriesHelper
{
	/**
	 * Get a list of the menu items.
	 *
	 * @param	JRegistry	$params	The module options.
	 *
	 * @return	array
	 * @since	1.5
	 */
	public static function getList($params) {
		$db = JFactory::getDbo();
		$db->setQuery(
			'SELECT * FROM #__categories WHERE published = 1 AND extension = \'com_jnt_hanhphuc\' ORDER BY lft'
		);
		return $db->loadObjectList();
	}
}
