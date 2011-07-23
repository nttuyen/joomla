<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$info = $this->row;
?>

<h3><?php echo $info->title; ?></h3>

<div id="content-full">
	<?php echo $info->fulltext; ?>
</div>

<?php if($info->listNewerContent): ?>
<h3>Bài viết mới hơn</h3>
<ul>
	<?php foreach($info->listNewerContent as $newerContent): ?>
	<li>
		<a href='<?php echo JURI::base(); ?>index.php/<?php echo $newerContent->id; ?>-<?php echo isset($newerContent->alias) ? $newerContent->alias : mainHelper::convertUnicode($newerContent->title); ?>.html'>
			<?php echo $newerContent->title; ?>
		</a>
	</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>

<?php if($info->listOlderContent): ?>
<h3>Bài viết cũ hơn</h3>
<ul>
	<?php foreach($info->listOlderContent as $olderContent): ?>
	<li>
		<a href='<?php echo JURI::base(); ?>index.php/<?php echo $olderContent->id; ?>-<?php echo isset($olderContent->alias) ? $olderContent->alias : mainHelper::convertUnicode($olderContent->title); ?>.html'>
			<?php echo $olderContent->title; ?>
		</a>
	</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>

