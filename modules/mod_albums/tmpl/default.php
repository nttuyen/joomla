<?php
defined('_JEXEC') or die();
if($albums) :
foreach($albums as $album) :
$album_url = JURI::base().$album->username.'/album/'.$album->id.'/';
?>

	<div class="album-wrap">
        <div class="album-title">
            <a href="<?php echo $album_url;?>" target="_blank">
                <?php echo $album->title;?>
            </a>
        </div>    
		<a href="<?php echo $album_url;?>" target="_blank">
			<img src="<?php echo $album->thumbnail;?>" />
		</a>
	</div>
	
<?php endforeach; ?>
<?php endif; ?>
