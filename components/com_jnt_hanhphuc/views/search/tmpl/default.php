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
$app = JFactory::getApplication();
$type 		= $app->getUserState('business.service.search.type');
$city 		= $app->getUserState('business.service.search.city');
$district 	= $app->getUserState('business.service.search.district');
$search 	= $app->getUserState('business.service.search.search');
?>
<script src="<?php echo JURI::root() ?>components/com_users/helpers/html/js/jquery-1.6.1.js" type="text/javascript"></script>
<script src="<?php echo JURI::root() ?>components/com_users/helpers/html/js/jquery.vnlocation.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery.noConflict();
    jQuery(document).ready(function($){
        $(document).vnlocation({
            province: '#search-city',
            current_province: "<?php echo $city ?>",
            district: '#search-district',
            current_district: "<?php echo $district ?>"
        });
        $("#search-type").change(function(){
            $("#search-city").val('');
        });
        $("#search-city").change(function(){
            $("#search-type").val('0');
        });
    });
    
</script>
<div class="services">
	<div class="services-search-form">
		<form action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=search')?>" method="post">
			<label for="search-type">Loại dịch vụ:</label>
			<select id="search-type" name="type">
				<option value="0">Tất cả</option>
				<?php foreach($this->categories as $category):?>
				<option value="<?php echo $category->id?>" <?php if($category->id == $type) echo 'selected="selected"'?>><?php if($category->level > 1) echo '--'?>  <?php echo $category->title?></option>
				<?php endforeach;?>
			</select>
			<br/>
			<label for="search-city">Địa điểm: </label>
			<select id="search-city" name="city"></select>
			<select id="search-district" name="district"></select>
			<br/>
			<label for="search-search">Từ khóa:</label>
			<input id="search-search" type="text" name="search" size = "30"/>
			<br/>
			<input type="submit" value="Tìm kiếm" />
		</form>
	</div>
	<?php if($this->items):?>
	<div class="services-list">
		<ul>
			<?php foreach($this->items as $item):?>
			<li>
				<div class="service-business-detail">
					<h3>
						<a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=service&id='.$item->serviceInfo->cat_id.'&bid='.$item->id)?>"><?php echo $item->profile->business_name?></a>
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


