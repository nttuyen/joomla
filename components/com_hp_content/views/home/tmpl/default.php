<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$list = $this->row->listCategories;
?>


<?php foreach($list as $obj): ?>

<?php if($this->row->show_index == 1): ?>

	<h3 class="title">
		<a <?php if($obj->id == $id) echo 'class="ttol-categories-focus"'; ?> href='<?php echo JURI::base(); ?>index.php/news/<?php echo $obj->id; ?>-<?php echo isset($obj->alias) ? $obj->alias : mainHelper::convertUnicode($obj->title); ?>.html'>
			<?php echo $obj->title; ?>
		</a>
		
		<?php if(!empty($obj->listSubIndexCates) && !JRequest::getVar('category_id')): ?>
		<ul style="float:right;">
			<?php foreach ($obj->listSubIndexCates as $subCate): ?>
			<li><a href='<?php echo JURI::base(); ?>index.php/news/<?php echo $subCate->id; ?>-<?php echo isset($subCate->alias) ? $obj->alias : mainHelper::convertUnicode($subCate->title); ?>.html'><?php echo $subCate->title; ?></a></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		
	</h3>

	<?php $i = 0; ?>
	
	<?php foreach ($obj->listContent as $content): ?>
	
		<?php if($i == 0): ?>
		<div class="content-hp">
        <div class="main-block-content">
        <div class="shadow-block-content">
		<h4><a href='<?php echo JURI::base(); ?>index.php/<?php echo $content->id; ?>-<?php echo isset($content->alias) ? $content->alias : mainHelper::convertUnicode($content->title); ?>.html'><?php echo $content->title; ?></a></h4>
		<div style="clear:both"><?php echo $content->introtext; ?></div>
		<div style="clear:both;"><span></span></div>
		<div class="article_separator"><span></span></div>
		</div>
        </div>
		<?php else: ?>
		<a class="title" href='<?php echo JURI::base(); ?>index.php/<?php echo $content->id; ?>-<?php echo isset($content->alias) ? $content->alias : mainHelper::convertUnicode($content->title); ?>.html'><?php echo $content->title; ?></a> <br>
        
		<?php endif; ?>
		
		<?php 
		
		$i ++;
		?>
	
	<?php endforeach; ?>
</div>
<?php else: ?>

<?php $cInfo = $this->row->categoryInfo; ?>

<h3 class="title">
	<a href='<?php echo JURI::base(); ?>index.php/news/<?php echo $cInfo->id; ?>-<?php echo isset($cInfo->alias) ? $cInfo->alias : mainHelper::convertUnicode($cInfo->title); ?>.html'>
		<?php echo $cInfo->title; ?>
	</a>
</h3>
<div class="content-hp">
<div class="main-block-content">
<div class="shadow-block-content">	
	<?php foreach ($obj->listContent as $content): ?>
            <h3 class="title2"><a href='<?php echo JURI::base(); ?>index.php/<?php echo $content->id; ?>-<?php echo isset($content->alias) ? $content->alias : mainHelper::convertUnicode($content->title); ?>.html'><?php echo $content->title; ?></a></h3>
            <div style="clear:both; padding:5px;"><?php echo $content->introtext; ?></div>
            <div style="clear:both;"><span></span></div>
            <div class="article_separator"><span></span></div>
		
	<?php endforeach; ?>
</div></div></div>	
	<div>
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>

<?php endif; ?>

<?php endforeach; ?>
