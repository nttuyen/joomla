<?php
/**
 * @version		$Id: default_item.php 18829 2010-09-10 12:17:05Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

?>

<?php $i = 0; ?>

<?php foreach ($this->listItems as $item): ?>

	<?php $item->slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id; ?>

	<?php if($i == 0): // Display first news ?>
		<h3><a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid)); ?>">
			<?php echo $item->title; ?>
		</a></h3>
		
		<div class="introtext">
			<?php if($item->images): ?>
			<img src="<?php echo $item->images; ?>" align="left" style="width: 100px; margin-right: 5px;" />
			<?php endif; ?>
			
			<?php echo $item->introtext; ?>
		</div>
	<?php else: ?>

		<p><a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid)); ?>">
			<?php echo $item->title; ?>
		</a></p>

	<?php endif; ?>

<?php $i ++; ?>
<?php endforeach;?>
