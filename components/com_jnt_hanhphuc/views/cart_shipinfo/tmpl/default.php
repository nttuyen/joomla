<?php
/**
 * @version		$Id: default.php 21020 2011-03-27 06:52:01Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers');

// Create shortcuts to some parameters.
?>
<div>
    <div>
    	<h2>Thông tin giỏ hàng</h2>
    </div>
    <div>
    	<?php
    	$items = $this->order->items;
    	if($items):
    	?>
    	<table>
    		<thead>
    			<tr>
	    			<th>Dịch vụ</th>
	    			<th>Doanh nghiệp cung cấp</th>
	    			<th>Số lượng</th>
	    			<th>Giá</th>
    			</tr>
    		</thead>
    		<tbody>
	    	<?php foreach($items as $item): ?>
	    		<tr>
	    			<td><?php echo $item->name?></td>
	    			<td><?php echo $item->businessProfile->business_name?></td>
	    			<td><?php echo $item->qty?></td>
	    			<td><?php echo $item->current_price?></td>
	    		</tr>
	    	<?php endforeach;?>
    		</tbody>
    	</table>
    	<?php else:?>
    		<p>Bạn chưa có sản phẩm nào trong giỏ hàng</p>
    	<?php endif;?>
    </div>
    <div>
    	<?php if($this->order->price > 0):?>
    		Tổng giá: <?php echo $this->order->price?>
    	<?php endif;?>
    </div>
    <div>
    	<span><a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc')?>">Thêm các dịch vụ khác</a></span>
    </div>
    <div>
    	<h3>Địa chỉ nhận hàng:</h3>
    	<form action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=order.shippingInfoSubmit')?>" method="post">
    		<input type="hidden" name="option" value="com_jnt_hanhphuc"/>
    		<input type="hidden" name="task" value="order.shippingInfoSubmit"/>
    		
    		<ul>
    			<li>
    				<label for="address_address">Địa chỉ:</label>
    				<input id="address_address" type="text" name="address[address]"/>
    			</li>
    			
    			<li>
    				<label for="address_city">Tỉnh/Thành Phố:</label>
    				<input id="address_city" type="text" name="address[city]"/>
    			</li>
    			
    			<li>
    				<label for="address_district">Quận/Huyện:</label>
    				<input id="address_district" type="text" name="address[district]"/>
    			</li>
    			
    			<li>
    				<label for="address_email">Email:</label>
    				<input id="address_email" type="text" name="address[email]"/>
    			</li>
    			
    			<li>
    				<label for="address_mobile">Điện thoại:</label>
    				<input id="address_mobile" type="text" name="address[mobile]"/>
    			</li>
    		</ul>
    		
    		<input type="submit" value="Tiếp tục thanh toán"/>
    	</form>
    </div>
</div>