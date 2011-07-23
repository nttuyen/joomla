<?php
defined('_JEXEC') or die('Restricted Access');
?>
<div class="home-title"><?php echo $this->rows->content->title;?></div>
<?php /* if(strlen($this->rows->content->image) && file_exists($this->rows->content->image)) { ?>
<div class="story-img">
	<img src="<?php echo JURI::base().$this->rows->content->image;?>" />
</div>
<?php } */ ?>
<div class="home-intro"><?php echo $this->rows->content->intro;?></div>
<div class="home-content"><?php echo $this->rows->content->content;?></div>