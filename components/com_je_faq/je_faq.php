<?php
/**
 * @version		$Id: je_faq.php 15976 2010-04-10 04:44:23Z hackwar $
 * @package		Joomla.Site
 * @subpackage	Contact
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

ini_set('display_errors', 1);

jimport('joomla.application.component.controller');

$controller = JController::getInstance('je_faq');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
