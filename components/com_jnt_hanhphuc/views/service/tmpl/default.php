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
$serviceInfo = $this->serviceInfo;
$businessInfo = $this->businessInfo;
$user = JFactory::getUser();
$paymentTypeName = array(
	1 => 'Thanh toán qua tài khoản ngân hàng',
	2 => 'Thanh toán qua địa chỉ bưu điện',
	3 => 'Thanh toán que website nganluong'
);
?>
<div class="business-intro">
    <h2><?php echo $businessInfo->profile->business_name ?></h2>
    <h3><?php echo $serviceInfo->name?></h3>
    <div>
    	<?php echo $serviceInfo->description?>
    </div>
    <div>
    	<?php $images = json_decode($serviceInfo->image);
    	if($images):?>
    		<ul>
    		<?php foreach ($images as $image):?>
    			<li>
    				<img width="100px" height="90px" alt="" src="<?php echo JURI::base()?>images/users/<?php echo $serviceInfo->business_id?>/services/<?php echo $serviceInfo->id?>/<?php echo $image?>">
    			</li>
    		<?php endforeach;?>
    		</ul>
    	<?php endif;?>
    </div>
    <div>
    	Thông tin giá và phương thức thanh toán
    	<ul>
    		<li>
    			Giá/chi phí: <?php echo $serviceInfo->price?>
    		</li>
    		<li>
    			Giá hiện tại: <?php echo $serviceInfo->current_price?>
    		</li>
    		<li>
    			Khuyến mại: <?php echo empty($serviceInfo->promotion) ? 'Không' : $serviceInfo->promotion?>
    		</li>
    		<li>
    			Hình thức thanh toán:
    			<?php $paymentTypes = json_decode($serviceInfo->payment_type);
    			if($paymentTypes):
    			?>
    			<ul>
    			<?php foreach ($paymentTypes as $type):?>
    				<li><?php echo $paymentTypeName[$type]?></li>
    			<?php endforeach;?>
    			</ul>
    			<?php else:?>
    			<div>Không có</div>
    			<?php endif;?>
    		</li>
    	</ul>
    </div>
    <div>
    	Thông tin liên hệ
    	<ul>
			<li>
				Địa chỉ: <?php echo $businessInfo->profile->business_address?>
				<br/>
				<?php echo $businessInfo->profile->business_village?> - <?php echo $businessInfo->profile->business_district?> - <?php echo $businessInfo->profile->business_city?>
			</li>
			<li>
				Email: <?php echo $businessInfo->email?>
			</li>
			<li>
				Điện thoại: <?php echo $businessInfo->profile->business_phone?>
			</li>
		</ul>
    </div>
    <div>
        <form id="add-service-to-cart" name="add-service-to-cart" action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=cart.add') ?>" method="post">
            <input type="hidden" name="option" value="com_jnt_hanhphuc"/>
            <input type="hidden" name="task" value="cart.add"/>
            <input type="hidden" name="id" value="<?php echo $serviceInfo->id ?>"/>
            
            <h4>Add to cart</h4>
            <label for="qty">Số lượng</label>
            <input type="text" name="qty" value="1" size="5"/>
            <input type="submit" value="Add"/>
        </form>
    </div>
</div>