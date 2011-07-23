<?php
/**
 * @version        $Id: default.php 17057 2010-05-14 15:58:47Z infograf768 $
 * @package        Joomla.Site
 * @subpackage    com_users
 * @copyright    Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 * @since        1.6
 */

defined('_JEXEC') or die;

JHtml::_('behavior.mootools');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<div class="registration<?php echo $this->params->get('pageclass_sfx')?>">
<?php if ($this->params->get('show_page_heading')) : ?>
<h1>
    <?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php endif; ?>

<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate">
    <?php
    // Iterate through the form fieldsets and display each one.
    foreach ($this->form->getFieldsets() as $fieldset):
    ?>
    <fieldset>
        <?php
        // If the fieldset has a label set, display it as the legend.
        if (isset($fieldset->label)):
        ?>
        <legend><?php echo JText::_($fieldset->label); ?></legend>

    <table cellpadding="2" cellspacing="0" border="0" width="100%">
        <?php
        endif;

        // Iterate through the fields in the set and display them.
        foreach($this->form->getFieldset($fieldset->name) as $field):
            // If the field is hidden, just display the input.
            if ($field->hidden):
                echo $field->input;
            else:
            ?>
                <tr>
                    <td width="30%">
                        <?php echo $field->label; ?>
                        <?php if (!$field->required): ?>
                        <span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL'); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $field->input; ?>
                    </td>
                </tr>
            <?php
            endif;
        endforeach;
        ?>
        </table>
    </fieldset>
    <?php
    endforeach;
    ?>
   <fieldset>
        <legend>Mã xác nhận</legend>
        <table cellpadding="2" cellspacing="0" border="0" width="100%">
            <tr>
                <td width="30%">
                    <img src="<?php echo JURI::base();?>index.php?option=com_users&view=registration&task=ajaxCaptcha&tmpl=component">
                </td>
                <td>
                    <input type="text" name="keystring" class="required">
                </td>
            </tr>
        </table>
   </fieldset>

    <button type="submit" class="validate"><?php echo JText::_('JREGISTER'); ?></button>
    <?php echo JText::_('COM_USERS_OR'); ?>
    <a href="<?php echo JRoute::_(''); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>

    <input type="hidden" name="option" value="com_users" />
    <input type="hidden" name="task" value="registration.register" />
    <?php echo JHtml::_('form.token'); ?>
</form>
</div>