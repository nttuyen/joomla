<?php
defined('_JEXEC') or die();
if($bloggers) :
foreach($bloggers as $blogger) :
if( empty($blogger->avatar) || !file_exists($blogger->avatar) )
	$blogger->avatar = 'images/wedding/avatar/no_avatar.jpg';
$blogger_url = JURI::base().$blogger->username.'/';
?>

	<div class="blogger-wrap">
        <div class="album-title">
            <a href="<?php echo $blogger_url;?>" target="_blank">
                <?php echo $blogger->username; #(empty($blogger->couple_name) ? $blogger->username : $blogger->couple_name); ?>
            </a>
        </div>    
		<a href="<?php echo $blogger_url;?>" target="_blank">
			<img src="<?php echo $blogger->avatar;?>" />
		</a>
	</div>
	
<?php endforeach; ?>
<?php endif; ?>
