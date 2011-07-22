<?php
/**
 * @version		$Id: banners.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	com_banners
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

//Define
define('SESSION_PAY_METHOD_KEY', 'jnt_hanhphuc.cart.pay_method');
define('SESSION_PAY_INFO_KEY', 'jnt_hanhphuc.cart.pay_info');
define('SESSION_PAY_SHHIPPING_INFO_KEY', 'jnt_hanhphuc.cart.pay_shipping_info');


// Execute the task.
$controller	= JController::getInstance('Jnt_HanhPhuc');
$controller->execute(JRequest::getVar('task'));
$controller->redirect();
