<?php
/**
 * @version		$Id: content.php 15976 2010-04-10 04:44:23Z hackwar $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

ini_set('display_errors', 1);

// no direct access
defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

//$controller = JController::getInstance('Content');

$view = JRequest::getVar('view', 'home');
$task = JRequest::getCmd('task', 'display');

// Require the controller
require_once(JPATH_COMPONENT.DS.'hp.controller.php');
require_once(JPATH_COMPONENT.DS.'controllers'.DS.$view.'.controller.php');

require_once(JPATH_COMPONENT.DS.'helpers'.DS.'main.helper.php');

// Create the controller
$controllerName = 'hpController'.$view;
$controller 	= new $controllerName($view);

$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
