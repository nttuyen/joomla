<?php
/**
 * @version		$Id: default.php 17148 2010-05-17 10:48:25Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;

JHtml::_('behavior.mootools');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<div class="remind<?php echo $this->params->get('pageclass_sfx')?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<h1>
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php endif; ?>

	<form id="user-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=remind.remind'); ?>" method="post" class="form-validate">

		<?php foreach ($this->form->getFieldsets() as $fieldset): ?>
		<fieldset>
        <table cellpadding="2" cellspacing="0" border="0" width="100%">      
			<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field): ?>
            <tr>
				<td width="20%"><?php echo $field->label; ?></td>
				<td><?php echo $field->input; ?></td>
           </tr>     
			<?php endforeach; ?>
		</table>
		</fieldset>
		<?php endforeach; ?>

		<button type="submit"><?php echo JText::_('JSUBMIT'); ?></button>

		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>