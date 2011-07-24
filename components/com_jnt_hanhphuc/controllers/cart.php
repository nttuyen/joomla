<?php
/**
 * @version		$Id: contact.php 20982 2011-03-17 16:12:00Z chdemko $
 * @package		Joomla.Site
 * @subpackage	Contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * @author nttuyen
 *
 */
class Jnt_HanhPhucControllerCart extends JController {
	
	public function add() {
		$id = JRequest::getInt('id', 0);
		$qty = JRequest::getInt('qty', 0);
		
		if(!$id || !$qty) {
			$this->setRedirect(JRoute::_('index.php?option=com_jnt_hanhphuc&view=cart'), 'Bạn cần chọn dịch vụ và nhập số lượng?', 'error');
			return false;
		}
        
        if(!is_numeric($qty) || (int)$qty <= 0) {
            $this->setRedirect(JRoute::_('index.php?option=com_jnt_hanhphuc&view=cart'), 'Bạn cần chọn dịch vụ và nhập số lượng?', 'error');
			return false;
        }
        
        $cartModel = $this->getModel('Cart');
        
        $serviceInfo = $cartModel->getServiceInfo($id);
        if(!$serviceInfo) {
            $this->setRedirect(JRoute::_('index.php?option=com_jnt_hanhphuc&view=cart'), 'Dịch vụ bạn chọn không tồn tại!', 'error');
			return false;
        }
        
        require_once JPATH_COMPONENT.DS.'helpers'.DS.'shoppingcart.class.php';
        $basket = new ShoppingBasket();
        if(!$basket->addToBasket($id, $qty)) {
            $this->setRedirect(JRoute::_('index.php?option=com_jnt_hanhphuc&view=cart'), 'Add vào giỏ hàng bị lỗi, vui lòng thử lại!', 'error');
			return false;
        }
        
        $this->setRedirect(JRoute::_('index.php?option=com_jnt_hanhphuc&view=cart'), 'Đã thêm dịch vụ vào giỏ hàng của bạn!');
        return true;
	}
}