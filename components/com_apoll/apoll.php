<?php
/**
 * aPoll Voting Component
 *
 * @version     $Id$
 * @package     Joomla
 * @copyright   Copyright (C) 2009 - 2010 aFactory. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// No Direct Access
defined( '_JEXEC' ) or die;

require_once JPATH_COMPONENT.DS.'controller.php';
//require_once JPATH_COMPONENT.DS.'router.php';
$controller = JController::getInstance('Apoll');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();

?>