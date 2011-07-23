<?php
defined('_JEXEC') or die();
?>
<div class="itemintro"><?php echo $this->rows->intro;?></div>
<?php
if($this->rows->stories)
{
	foreach($this->rows->stories as $story)
	{
	?>
	<div class="story-wrap">
		<div class="story-title">
			<a href="<?php echo JURI::base().$this->rows->username.'/card/'.$story->id;?>">
				<?php echo $story->title;?>
			</a>
		</div>
		<?php if(strlen($story->image) && file_exists($story->image)): ?>
		<div class="story-img">
			<img src="<?php echo JURI::base().$story->image;?>" width="540" />
		</div>
		<?php endif; ?>
		<div class="story-intro"><?php echo $story->intro;?></div>
	</div>
	<?php
	}
}
else
{
?>
	Bạn chưa có thiệp mời nào
<?php } ?>
