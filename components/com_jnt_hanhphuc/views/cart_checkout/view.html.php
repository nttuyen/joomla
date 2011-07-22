<?php
/**
 * @version		$Id: view.html.php 21018 2011-03-25 17:30:03Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML Article View class for the Content component
 *
 * @package		Joomla.Site
 * @subpackage	com_content
 * @since		1.5
 */
class Jnt_HanhPhucViewCart_Checkout extends JView {

	protected $order;

	function display($tpl = null) {
		$user = JFactory::getUser();
		if($user->guest) {
			$return = JRoute::_('index.php?option=com_jnt_hanhphuc&view=cart_checkout');
			$forward = JRoute::_('index.php?option=com_users&view=login&return='.base64_encode($return));
			$app = JFactory::getApplication();
			$app->redirect($forward, 'Bạn cần đăng nhập trước khi thanh toán giỏ hàng!', 'notice');
			return false;
		}
		
		$cartModel = JModel::getInstance('Cart', 'Jnt_HanhPhucModel');
		$this->order = $cartModel->getOrder();
		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument() {
		
	}
}
