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
$businessInfo = $this->businessInfo;
?>
<div class="business-services">
<h2>
	Thông tin doanh nghiệp: <?php echo $businessInfo->profile->business_name ?>
</h2>
<?php if($this->items):?>
	<div class = "business-services-list">
		<ul>
		<?php foreach($this->items as $item):?>
			<li>
				<div>
					<h3><?php echo $item->name ?></h3>
					<div>
						<?php echo $item->content?>
					</div>
					<div>
						<a href = "<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=business_promotion&layout=edit&id='.$item->id) ?>">Chỉnh sửa</a>
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
	Bạn chưa có dịch vụ nào trên website hanhphuc.vn
</div>
<?php endif;?>
<div class = "business-services-manager">
	<a href = "<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=business_promotion&layout=edit') ?>">Add news</a>
</div>
</div>