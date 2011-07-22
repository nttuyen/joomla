<?php
/**
 * aPoll voting component
 *
 * @version     $Id: apoll.php 111 2010-10-16 09:20:06Z harrygg $
 * @package     aPoll
 * @copyright   Copyright (C) 2009 - 2010 aFactory. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_apoll')) {
	return JError::raiseWarning(404, JText::_('ALERTNOTAUTH'));
}

// Include dependancies
jimport('joomla.application.component.controller');

$controller = JController::getInstance('Apoll');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();