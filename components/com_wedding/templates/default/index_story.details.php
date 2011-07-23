<?php
defined('_JEXEC') or die();
if($this->rows->story)
{
?>
	<div class="story-wrap">
		<div class="story-title">
			<?php echo $this->rows->story->title;?>
		</div>
		<div class="story-intro">
			<?php if(strlen($this->rows->story->image) && file_exists($this->rows->story->image)) { ?>
		
				<img src="<?php echo JURI::base().$this->rows->story->image;?>" align="left" width="200" style="margin-right: 5px;" />
		
			<?php } ?>
			<?php echo $this->rows->story->intro;?>
		</div>
		<div class="story-content"><?php echo $this->rows->story->content;?></div>
	</div>
<?php
} else {
	echo 'Không tìm thấy bài viết của bạn...';
}
?>
<div class="jsback"><a href="javascript:void(0)" onclick="window.history.go(-1)">Quay lại</a></div>
