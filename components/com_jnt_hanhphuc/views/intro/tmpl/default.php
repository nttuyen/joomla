<?php
/**
 * @version		$Id: default.php 21020 2011-03-27 06:52:01Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers');

// Create shortcuts to some parameters.
?>
<div>
    <h2><?php echo $this->businessInfo->profile->business_name ?></h2>
    <div>
        <?php echo $this->data->content ?>
    </div>
    <?php 
    $user = JFactory::getUser();
    if($user->id == $this->businessInfo->id && $user->id = $this->data->business_id):
    ?>
    <div class="business-intro-manager">
        <a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=intro&layout=edit&bid='.$this->data->business_id) ?>">Chỉnh sửa</a>
    </div>
    <?php endif; ?>
</div>