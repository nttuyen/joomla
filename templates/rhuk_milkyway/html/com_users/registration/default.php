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

require_once('recaptchalib.php');

// Get a key from https://www.google.com/recaptcha/admin/create
			$publickey = "6Lenb74SAAAAALZUshMNkxVOcCxHDbzc1-ridwa5";
			$privatekey = "6Lenb74SAAAAAGhSC0k0QfzkQqqcCPP6C208L5Ve";
			
//var_dump($this->form);
?>

<script src="<?php echo JURI::root() ?>templates/rhuk_milkyway/js/jquery-1.6.1.js" type="text/javascript"></script>
<script src="<?php echo JURI::root() ?>templates/rhuk_milkyway/js/jquery.vnlocation.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery.noConflict();
    jQuery(document).ready(function($){
        $(document).vnlocation({
            province: '#jform_business_city',
            district: '#jform_business_district'
        });

        $("#jform_user_type").change(function(){
            var registerURL = "<?php echo JRoute::_('index.php?option=com_users&view=registration&type=_USERTYPE')?>";
            var seletedValue = $(this).val();
            registerURL = registerURL.replace("_USERTYPE", seletedValue);
            window.location.replace(registerURL);
        });
    });
</script>


<div class="registration<?php echo $this->params->get('pageclass_sfx')?>">
<?php if ($this->params->get('show_page_heading')) : ?>
<h1>
    <?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php endif; ?>

<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate">
	<?php
	//User type first
	foreach($this->form->getFieldsets() as $fieldset) {
		if($fieldset->name != 'hp_user_type') continue;
		$userTypeFieldset = $fieldset;
	} 
	?>
	<fieldset>
		<legend><?php echo JText::_($userTypeFieldset->label); ?></legend>
		<table cellpadding="2" cellspacing="0" border="0" width="100%">
			<?php foreach($this->form->getFieldset($userTypeFieldset->name) as $field): ?>
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
			<?php endforeach;?>
		</table>
	</fieldset>
	
	
    <?php
    // Iterate through the form fieldsets and display each one.
    foreach ($this->form->getFieldsets() as $fieldset):
    	if($fieldset->name == 'hp_user_type') continue;
    ?>
        <?php
        // If the fieldset has a label set, display it as the legend.
        if (!empty($fieldset->label)):
        ?>
        <fieldset>
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
        <?php if (!empty($fieldset->label)):?>
        </table>
    </fieldset>
    <?php endif;?>
    <?php
    endforeach;
    ?>
   <fieldset>
        <legend>Mã xác nhận</legend>
        <table cellpadding="2" cellspacing="0" border="0" width="100%">
            <tr>
                <td width="30%">
                    <?php 
						/*
						<img alt="Mã xác nhận" src="<?php echo JURI::base()?>captcha/index.php">
						*/
						echo recaptcha_get_html($publickey, $error);
					?>
                </td>
				<?php
				/*
                <td>
                    <input type="text" name="keystring" class="required">
                </td>
				*/
				?>
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
