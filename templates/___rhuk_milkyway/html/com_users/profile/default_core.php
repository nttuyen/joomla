<?php
/**
 * @version		$Id: default_core.php 16610 2010-04-30 03:41:20Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;

jimport('joomla.user.helper');
?>

<fieldset id="users-profile-core">
	<legend>
		<?php echo JText::_('COM_USERS_PROFILE_CORE_LEGEND'); ?>
	</legend>
	<table cellpadding="2" cellspacing="0" border="0" width="100%">
        <tr>
		    <td width="20%">
			    <?php echo JText::_('COM_USERS_PROFILE_NAME_LABEL'); ?>
		    </td>
		    <td>
			    <?php echo $this->data->name; ?>
		    </td>
        </tr>
        <tr>
		    <td>
			    <?php echo JText::_('COM_USERS_PROFILE_USERNAME_LABEL'); ?>
		    </td>
		    <td>
			    <?php echo $this->data->username; ?>
		    </td>
        </tr>
        <tr>
		    <td>
			    <?php echo JText::_('COM_USERS_PROFILE_REGISTERED_DATE_LABEL'); ?>:
		    </td>
		    <td>
			    <?php echo JHTML::_('date',$this->data->registerDate); ?>
		    </td>
        </tr>
        <tr>
		<td>
			<?php echo JText::_('COM_USERS_PROFILE_LAST_VISITED_DATE_LABEL'); ?>:
		</td>

		<?php if ($this->data->lastvisitDate != '0000-00-00 00:00:00'){?>
			<td>
				<?php echo JHTML::_('date',$this->data->lastvisitDate); ?>
			</td>
		<?php }
		else {?>
			<td>
				<?php echo JText::_('COM_USERS_PROFILE_NEVER_VISITED'); ?>:
			</td>
		<?php } ?>
        </tr>
	</table>
</fieldset>
