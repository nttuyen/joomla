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

Qu&ecirc;n &#273;&#7883;a ch&#7881; Blog &#273;&aacute;m c&#432;&#7899;i

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
 <br>
 <p><b>Ch&uacute; &yacute;</b></p>
 <p>H&#7879; th&#7889;ng ch&#7881; ch&#7845;p nh&#7853;n email b&#7841;n d&ugrave;ng khi &#273;&#259;ng k&yacute; t&agrave;i kh&#7903;i t&#7841;o kho&#7843;n   Blog &#273;&aacute;m c&#432;&#7899;i, ch&uacute;ng t&ocirc;i ch&#7881; g&#7917;i <b>&#272;&#7883;a ch&#7881; Blog &#273;&aacute;m c&#432;&#7899;i</b> c&#7911;a b&#7841;n duy nh&#7845;t v&agrave;o email n&agrave;y.</p>
</div>