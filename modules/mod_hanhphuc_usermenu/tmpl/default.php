<?php
/**
 * @version		$Id: default.php 20899 2011-03-07 20:56:09Z ian $
 * @package		Joomla.Site
 * @subpackage	mod_login
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
$user = JFactory::getUser();
if($user->guest || $user->user_type != 2) return;
if($user->user_type == 2):
?>
<div class="mod-hanhphuc-usermenu<?php echo $class_sfx?>">
	<!-- <h2>User menu</h2> -->
	<ul>
		<li><a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=intro&bid='.$user->id)?>">Giới thiệu doanh nghiệp</a></li>
		<li><a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=business_services')?>">Danh sách dịch vụ</a></li>
		<li><a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=business_promotions')?>">Quản lý thông tin khuyến mại</a></li>
		<li><a href="<?php echo JRoute::_('index.php?option=com_users&view=profile')?>">Thông tin doanh nghiệp</a></li>
		<li><a href="#"></a></li>
	</ul>
</div>

<?php
endif;