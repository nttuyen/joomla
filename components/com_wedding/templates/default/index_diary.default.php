<?php
defined('_JEXEC') or die();
if($this->rows->stories)
{
	foreach($this->rows->stories as $story)
	{
	?>
	<div class="story-wrap">
		<div class="story-title">
			<a href="<?php echo JURI::base().$this->rows->username.'/diary/'.$story->id;?>">
				<?php echo $story->title;?>
			</a>
		</div>
		<div class="story-intro">
			<?php if(strlen($story->image) && file_exists($story->image)) { ?>
				<img src="<?php echo JURI::base().$story->image;?>" align="left" width="100" style="margin-right: 5px;" /> 
			<?php } ?>
			<?php echo $story->intro;?>
		</div>
	</div>

	<div style="clear:both;"><span></span></div>
	<?php
	}
}
else
{
?>
	Bạn chưa ghi nhật kí
<?php } ?>
