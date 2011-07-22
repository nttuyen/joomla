<?php
/**
 * @version		$Id: edit.php 20206 2011-01-09 17:11:35Z chdemko $
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$data = $this->data;
$businessInfo = $this->businessInfo;
?>
<script src="<?php echo JURI::root() ?>components/com_users/helpers/html/js/jquery-1.6.1.js" type="text/javascript"></script>
<script src="<?php echo JURI::root() ?>components/com_users/helpers/html/js/jquery.vnlocation.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery.noConflict();
    jQuery(document).ready(function($){
        $("#service-add-more-image").click(function(){
            var parent = $(this).parent();
            parent.append("<br/>");
            parent.append("<input class = \"service-add-image\" type=\"file\" size=\"25\" value=\"\" id=\"jform_image\" name=\"jform[image][]\">");
            parent.append("<a class=\"service-remove-image\" href=\"#\">remove</a>");
            
            $("a.service-remove-image").click(function() {
                var parent = $(this).parent();
                $imgs = parent.children("input.service-add-image");
                $as = parent.children("a.service-remove-image");
                $brs = parent.children("br");
                
                index = $as.index($(this));
                $($imgs[index]).remove();
                $($brs[index]).remove();
                $(this).remove();
                
                return false;
            });
            
            return false;
        });

        $(".service-delete-image").click(function(){
            $(this).parent().remove();
            return false;
        });
    });
</script>

<div class="business-intro">

<h2><?php echo $businessInfo->profile->business_name ?></h2>

<form id="business-info" action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=business_service.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
    <div>
        <ul>
            <li>
                <?php echo $this->form->getLabel('category'); ?>
				<?php echo $this->form->getInput('category'); ?>
            </li>
            <li>
                <?php echo $this->form->getLabel('state'); ?>
				<?php echo $this->form->getInput('state'); ?>
            </li>
            <li>
                <?php echo $this->form->getLabel('name'); ?>
				<?php echo $this->form->getInput('name'); ?>
            </li>
            <li>
                <?php echo $this->form->getLabel('price'); ?>
				<?php echo $this->form->getInput('price'); ?>
            </li>
            <li>
                <?php echo $this->form->getLabel('current_price'); ?>
				<?php echo $this->form->getInput('current_price'); ?>
            </li>
            <li>
                <?php echo $this->form->getLabel('payment_type'); ?>
				<?php echo $this->form->getInput('payment_type'); ?>
            </li>
            <li>
                <?php echo $this->form->getLabel('number'); ?>
				<?php echo $this->form->getInput('number'); ?>
            </li>
            <li>
                <?php echo $this->form->getLabel('promotion'); ?>
				<?php echo $this->form->getInput('promotion'); ?>
            </li>
            <li>
            	<?php echo $this->form->getLabel('image'); ?>
            	<?php $images = json_decode(isset($this->data->image) ? $this->data->image : '[]');?>
                <?php if($images):?>
            	<ul>
            	<?php foreach ($images as $image):?>
            		<li>
            			<img width="100px" height="90px" alt="" src="<?php echo JURI::base()?>/images/users/<?php echo $this->businessInfo->id?>/services/<?php echo $this->form->getValue('id')?>/<?php echo $image?>">
            			<input type="hidden" name="image-temp[]" value="<?php echo $image?>"/>
            			<a class="service-delete-image" href="#">remove</a>
            		</li>
            	<?php endforeach;?>
            	</ul>
                <?php endif; ?>
				<?php echo $this->form->getInput('image'); ?>
                <a id="service-add-more-image" href="#">Add more image</a>
            </li>
			<li>
                <?php echo $this->form->getLabel('description'); ?>
				<?php echo $this->form->getInput('description'); ?>
            </li>
        </ul>
    </div>
    <div style="clear: both;"></div>
    <div>
        <?php echo $this->form->getInput('id'); ?>
        <?php echo $this->form->getInput('business_id'); ?>
        <button type="submit" class="validate"><span><?php echo JText::_('JSUBMIT'); ?></span></button>
        <a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=business_services'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
        <input type="hidden" name="option" value="com_jnt_hanhphuc" />
        <input type="hidden" name="task" value="business_service.save" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
	</form>
</div>