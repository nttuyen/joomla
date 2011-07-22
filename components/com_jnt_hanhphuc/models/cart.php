<?php
/**
 * @version		$Id: category.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

/**
 * @package		Joomla.Site
 * @subpackage	com_contact
 */
class Jnt_HanhPhucModelCart extends JModel {
	public function getOrder() {
		$return = new stdClass();
		
        require_once JPATH_COMPONENT.DS.'helpers'.DS.'shoppingcart.class.php';
        $basket = new ShoppingBasket();
        $items = $basket->getBasket();
        if(empty($items)) {
            return false;
        }
        
        $totalPrice = 0;
        $price = 0;
        $orderItems = array();
        foreach($items as $id => $qty) {
            $itemInfo = $this->getServiceInfo($id);
            $itemInfo->qty = $qty;
            
            $totalPrice += $itemInfo->price;
            $price += $itemInfo->current_price;
            
            $orderItems[] = $itemInfo;
        }
        
        $return->items = $orderItems;
        $return->totalPrice = $totalPrice;
        $return->price = $price;
        
        $session = JFactory::getSession();
        //TODO #nttuyen ShippingInfo
        $shippingAddress = null;
        $shippingAddress = $session->get(SESSION_PAY_SHHIPPING_INFO_KEY, null);
        if(!$shippingAddress) {
        	//TODO #nttuyen init shipping address from user info
        	$shippingAddress = new stdClass();
        }
        $return->shippingAddress = $shippingAddress;
        
        //TODO: #nttuyen payinfo
        $payInfo = new stdClass();
        $payType = $session->get(SESSION_PAY_METHOD_KEY, 0);
        $payInfo->type = $payType;
        if($payType == 1) {
        	$payInfo->typeName = 'Chuyển tiền qua bưu điện';
        } else if ($payType == 2) {
        	$payInfo->typeName = 'Chuyển khoản qua ngân hàng';
        } else {
        	$payInfo->typeName = '';
        }
        $return->payInfo = $payInfo;
        
		return $return;
	}
    
    public function getServiceInfo($id = 0) {
        if(!$id) $id = JRequest::getInt ('id', 0);
        if(!$id) return false;
        
        $db = JFactory::getDbo();
        $query = '
                SELECT 
                    s.* 
                FROM #__hp_business_service s
                WHERE s.state = 1
                    AND s.id = '.(int)$id.'
            ';
        $db->setQuery($query);
        $return = $db->loadObject();
        
        if($return) {
	        //Load businessInfo
	        $businessModel = JModel::getInstance('Intro', 'Jnt_HanhPhucModel');
	        $businessInfo = $businessModel->getBusinessInfo($return->business_id);
	        $return->businessProfile = $businessInfo->profile;
	        $return->businessInfo = $businessInfo;
        }
        
        return $return;
    }
}