<?php defined('_JEXEC') or die();?>
<div class="story-title">
	<?php echo $this->item->title;?>
</div>
<div class="story-author">
	Viết bởi: <?php echo $this->item->username;?>
</div>
<div class="story-image">
	<img src="../<?php echo $this->item->image;?>" />
</div>
<div class="story-intro">
	<?php echo $this->item->intro;?>
</div>
<div class="story-content">
	<?php echo $this->item->content;?>
</div>