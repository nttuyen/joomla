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
class Jnt_HanhPhucViewCart_Confirm extends JView {

	protected $order;
	protected $payMethod;
	protected $payMethodName;
	protected $payInfo;

	function display($tpl = null) {
		$cartModel = JModel::getInstance('Cart', 'Jnt_HanhPhucModel');
		$this->order = $cartModel->getOrder();
		
		$session = JFactory::getSession();
		$this->payMethod = $session->get(SESSION_PAY_METHOD_KEY, 0);
		if(!$this->payMethod) {
			$app = JFactory::getApplication();
			$app->redirect(JRoute::_('index.php?option=com_jnt_hanhphuc&view=cart_checkout'));
			return false;
		}
		$this->payMethodName = ($this->payMethod == 1) ? 'Chuyển tiền qua bưu điện' : 'Thanh toán qua chuyển khoản';
		
		$this->payInfo = $session->get(SESSION_PAY_INFO_KEY);
		
		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument() {
		
	}
}
