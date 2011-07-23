<?php
defined('_JEXEC') or die();
if($this->rows->albums)
{
foreach ($this->rows->albums as $album)
{
    $dlink = JURI::base().$this->rows->cuser->username.'/album/'.$album->id.'/';
?>
    <div class="album-wrap">
        <div class="album-title">
            <a href="<?php echo $dlink;?>">
                <?php echo $album->title;?>
            </a>
        </div>    
        <div class="album-thumb"><a href="<?php echo $dlink;?>"><img src="<?php echo $album->thumbnail;?>" alt="" /></a></div>
    </div>
<?php
}
} else {
?>
    Chưa có album nào được tạo
<?php } ?>