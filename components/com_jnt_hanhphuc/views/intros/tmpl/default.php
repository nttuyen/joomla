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
<div class="business-intros">
<h2>
	Danh sách doanh nghiệp
</h2>
<?php if($this->items):?>
	<div class = "business-intros-list">
		<ul>
		<?php foreach($this->items as $item):?>
			<li>
				<div>
					<h3><?php echo $item->profile->business_name ?></h3>
					<div>
                        <?php
                        $logo = !empty($item->profile->business_logo) ? 'users/'.$item->id.'/'.$item->profile->business_logo : 'default/logo.png'; 
                        ?>
                        <img width="100px" height="90px" alt="<?php echo $item->profile->business_name?>-logo" src="<?php echo JURI::base()?>images/<?php echo $logo?>"/>
                        <p>
                            <?php echo $item->profile->business_slogan ?>
                        </p>
					</div>
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
					<div>
						<a href = "<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=intro&bid='.$item->id) ?>">Chi tiết</a>
					</div>
				</div>
			</li>
		<?php endforeach;?>
		</ul>
	</div>
	<div class = "business-services-pagination">
		<?php echo $this->pagination->getPagesLinks()?>
	</div>
<?php else:?>
<div class="business-services-noservcie">
	
</div>
<?php endif;?>
</div>