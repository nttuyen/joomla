<style>
.ttol-categories-focus {
	font-weight:bold !important;
}
</style>
<?php foreach($listCategories as $c): ?>
<ul class="menu">
	<li id="current" >
		<a <?php if($c->id == $id) echo 'class="ttol-categories-focus"'; ?> href='<?php echo JURI::base(); ?>index.php/news/<?php echo $c->id; ?>-<?php echo isset($c->alias) ? $c->alias : mainHelper::convertUnicode($c->title); ?>.html'><span style="font-size:13px;"><?php echo $c->title; ?></span></a>
		<?php if($c->subCategories): ?>
		<?php //if($id == $c->id || $c->id == $categoryInfo->parent_id || $c->id == $categoryInfo->id): ?>
		<ul>
		<?php foreach ($c->subCategories as $sub): ?>
			<li><a <?php if($sub->id == $id || $sub->id == $categoryInfo->id) echo 'class="ttol-categories-focus"'; ?> href='<?php echo JURI::base(); ?>index.php/news/<?php echo $sub->id; ?>-<?php echo $sub->alias; ?>.html'><?php echo $sub->title; ?></a></li>
		<?php endforeach; ?>
		</ul>
		<?php //endif; ?>
		<?php endif; ?>
	</li>
</ul>
<?php endforeach; ?>
