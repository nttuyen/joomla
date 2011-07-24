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


<div class="business-intro">

<h2><?php echo $businessInfo->profile->business_name ?></h2>

<form id="business-info" action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=intro.save'); ?>" method="post" class="form-validate">
    <div>
        <ul>
            <li>
                <?php echo $this->form->getLabel('content'); ?>
				<?php echo $this->form->getInput('content'); ?>
            </li>
        </ul>
    </div>
    <div>
        <?php echo $this->form->getInput('id'); ?>
        <?php echo $this->form->getInput('business_id'); ?>
        <button type="submit" class="validate"><span><?php echo JText::_('JSUBMIT'); ?></span></button>
        <a href="<?php echo JRoute::_(''); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
        <input type="hidden" name="option" value="com_jnt_hanhphuc" />
        <input type="hidden" name="task" value="intro.save" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
	</form>
</div>