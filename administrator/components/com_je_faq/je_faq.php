<?php
/**
 * @version		$Id: demo.php / date: 2010-08-24$
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Access check.
/*
if (!JFactory::getUser()->authorise('core.manage', 'com_banners')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}
*/

ini_set('display_errors', 1);

// Include dependancies
jimport('joomla.application.component.controller');

// Execute the task.
$controller	= JController::getInstance('je_faq');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();