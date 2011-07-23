<?php
defined('_JEXEC') or die();
$Itemid = JRequest::getInt('Itemid');
if($this->rows->videos)
{
	foreach ($this->rows->videos as $v)
	{
?>

<div class="video-item">
	<div class="video-title"><h3><?php echo $v->title;?></h3></div>
	<div class="video-content">
<?php
		if(empty($v->file))
		{
			echo stripslashes($v->embed);
		}
		else
			echo '<a href="'.JURI::base().$v->file.'">Download</a>';
	}
?>
	</div>
</div>

<?php
}
?>