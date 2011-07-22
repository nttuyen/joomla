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

$businessInfo = $this->businessInfo;
?>
<script src="<?php echo JURI::root() ?>components/com_users/helpers/html/js/jquery-1.6.1.js" type="text/javascript"></script>
<script src="<?php echo JURI::root() ?>components/com_users/helpers/html/js/jquery.vnlocation.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery.noConflict();
    jQuery(document).ready(function($){
        
    });
</script>

<div class="business-intro">

<h2><?php echo $businessInfo->profile->business_name ?></h2>

<form id="business-info" action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=business_promotion.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
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
                <?php echo $this->form->getLabel('from_date'); ?>
				<?php echo $this->form->getInput('from_date'); ?>
            </li>
            <li>
                <?php echo $this->form->getLabel('to_date'); ?>
				<?php echo $this->form->getInput('to_date'); ?>
            </li>
            <li>
                <?php echo $this->form->getLabel('discount_percent'); ?>
				<?php echo $this->form->getInput('discount_percent'); ?>
            </li>
            <li>
                <?php echo $this->form->getLabel('discount_absolute'); ?>
				<?php echo $this->form->getInput('discount_absolute'); ?>
            </li>
            <li>
                <?php echo $this->form->getLabel('content'); ?>
				<?php echo $this->form->getInput('content'); ?>
            </li>
        </ul>
    </div>
    <div style="clear: both;"></div>
    <div>
        <?php echo $this->form->getInput('id'); ?>
        <?php echo $this->form->getInput('business_id'); ?>
        <button type="submit" class="validate"><span><?php echo JText::_('JSUBMIT'); ?></span></button>
        <a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=business_promotions'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
        <input type="hidden" name="option" value="com_jnt_hanhphuc" />
        <input type="hidden" name="task" value="business_promotion.save" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
	</form>
</div>