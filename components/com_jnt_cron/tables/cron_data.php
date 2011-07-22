<?php
/**
 * @version		$Id: banner.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Banner table
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.5
 */
class Jnt_CronTableCron_Data extends JTable {
/**
	 * Constructor
	 *
	 * @since	1.5
	 */
	function __construct(&$_db) {
		parent::__construct('#__cron_data', 'id', $_db);
		$this->created = JFactory::getDate()->toMySQL();
	}
}