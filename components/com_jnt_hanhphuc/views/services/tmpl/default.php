<?php
/**
 * @version		$Id: default.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<div class="services">
	<h2 class="title">Dịch vụ: <?php echo $this->category->title?></h2>
	<?php if($this->items):?>
	<div class="services-list">
		<ul>
			<?php foreach($this->items as $item):?>
			<li>
				<div class="service-business-detail">
					<h3>
						<a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=service&id='.$this->category->id.'&bid='.$item->id)?>"><?php echo $item->profile->business_name?></a>
					</h3>
					<?php
					$logo = !empty($item->profile->business_logo) ? 'users/'.$item->id.'/'.$item->profile->business_logo : 'default/logo.png'; 
					?>
					<img width="100px" height="90px" alt="<?php echo $item->profile->business_name?>-logo" src="<?php echo JURI::base()?>images/<?php echo $logo?>">
					<div>
						<p class="contact">
							<ul>
								<li>
									Địa chỉ: <?php echo $item->profile->business_address?>
									<br/>
									<?php echo $item->profile->business_village?> - <?php echo $item->profile->business_district?> - <?php echo $item->profile->business_city?>
								</li>
								<li>
									Email: <?php echo $item->email?>
								</li>
								<li>
									Điện thoại: <?php echo $item->profile->business_phone?>
								</li>
							</ul>
						</p>
					</div>
				</div>
			</li>
			<?php endforeach;?>
		</ul>
	</div>
	<?php else:?>
	<div class = "services-noservice">
		Hiện không có danh nghiệp nào cung cấp dịch vụ này!
	</div>
	<?php endif;?>
	<div class="services-pagination">
		<?php echo $this->pagination->getPagesLinks()?>
	</div>
</div>


