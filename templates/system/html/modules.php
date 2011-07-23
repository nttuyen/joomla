<?php
/**
 * @version		$Id: modules.php 14276 2010-01-18 14:20:28Z louis $
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/*
 * none (output raw module content)
 */
function modChrome_none($module, &$params, &$attribs)
{
	echo $module->content;
}

/*
 * Module chrome that wraps the module in a table
 */
function modChrome_table($module, &$params, &$attribs)
{ ?>
	<table cellpadding="0" cellspacing="0" class="moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
	<?php if ($module->showtitle != 0) : ?>
		<tr>
			<th valign="top">
				<?php echo $module->title; ?>
			</th>
		</tr>
	<?php endif; ?>
		<tr>
			<td>
				<?php echo $module->content; ?>
			</td>
		</tr>
		</table>
	<?php
}

/*
 * Module chrome that wraps the tabled module output in a <td> tag of another table
 */
function modChrome_horz($module, &$params, &$attribs)
{ ?>
	<table cellspacing="1" cellpadding="0" border="0" width="100%">
		<tr>
			<td valign="top">
				<?php modChrome_table($module, $params, $attribs); ?>
			</td>
		</tr>
	</table>
	<?php
}

/*
 * xhtml (divs and font headder tags)
 */
function modChrome_xhtml($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
		<?php if ($module->showtitle != 0) : ?>
			<h3><?php echo $module->title; ?></h3>
		<?php endif; ?>
			<div class="content-module<?php echo $params->get('moduleclass_sfx'); ?>"><div><?php echo $module->content; ?></div></div>
		</div>
	<?php endif;
}

/*
 * Module chrome that allows for rounded corners by wrapping in nested div tags
 */
function modChrome_rounded($module, &$params, &$attribs)
{ ?>
		<div class="module<?php echo $params->get('moduleclass_sfx'); ?>">
			<div>
				<div>
					<div>
						<?php if ($module->showtitle != 0) : ?>
							<h3><div><?php echo $module->title; ?></div></h3>
						<?php endif; ?>
					<div class="content-module<?php echo $params->get('moduleclass_sfx'); ?>"><?php echo $module->content; ?></div>
					</div>
				</div>
			</div>
		</div>
	<?php
}

/*
 * Module chrome that add preview information to the module
 */
function modChrome_outline($module, &$params, &$attribs)
{
	$doc = &JFactory::getDocument();
	$css  = ".mod-preview-info { padding: 2px 4px 2px 4px; border: 1px solid black; position: absolute; background-color: white; color: red;opacity: .80; filter: alpha(opacity=80); -moz-opactiy: .80; }";
	$css .= ".mod-preview-wrapper { background-color:#eee;  border: 1px dotted black; color:#700; opacity: .50; filter: alpha(opacity=50); -moz-opactiy: .50;}";
	$doc->addStyleDeclaration($css);

	?>
	<div class="mod-preview">
		<div class="mod-preview-info"><?php echo $module->position."[".$module->style."]"; ?></div>
		<div class="mod-preview-wrapper">
			<?php echo $module->content; ?>
		</div>
	</div>
	<?php
}
?>