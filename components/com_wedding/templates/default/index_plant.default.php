<?php
defined('_JEXEC') or die();
if($this->rows->stories)
{
	foreach($this->rows->stories as $story)
	{
	?>
	<div class="story-wrap">
		<div class="story-title">
			<a href="<?php echo JURI::base().$this->rows->username.'/plant/'.$story->id;?>">
				<?php echo $story->title;?>
			</a>
		</div>
		<div class="story-intro"><?php echo $story->intro;?></div>
	</div>
	<?php
	}
}
else
{
?>
	Bạn chưa ghi kế hoạch đám cưới
<?php } ?>