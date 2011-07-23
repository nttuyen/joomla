<?php
defined('_JEXEC') or die();
$Itemid = JRequest::getInt('Itemid');
$document = & JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_wedding/media/css/jquery.lightbox-0.5.css');
if($this->rows->photos)
{
	echo '<div id="jlightbox">';
	foreach ($this->rows->photos as $photo)
	{
?>
	<a title="<?php echo $photo->title;?>" href="<?php echo JURI::base().$photo->photos;?>">
		<img src="<?php echo $photo->thumbnail;?>" alt="" width="160px" />
	</a>

<?php
	}
	echo '</div>';
}
?>
<script type="text/javascript" src="<?php echo JURI::base().'components/com_wedding/media/js/jquery-1.4.2.min.js';?>"></script>
<script type="text/javascript" src="<?php echo JURI::base().'components/com_wedding/media/js/jquery.lightbox-0.5.min.js';?>"></script>
<script type="text/javascript">
	jQuery.noConflict();
	jQuery().ready(function(){
		jQuery('#jlightbox a').lightBox({
			imageLoading: '<?php echo JURI::base().'components/com_wedding/media/images/lightbox-ico-loading.gif';?>',
			imageBtnClose: '<?php echo JURI::base().'components/com_wedding/media/images/lightbox-btn-close.gif';?>',
			imageBtnPrev: '<?php echo JURI::base().'components/com_wedding/media/images/lightbox-btn-next.gif';?>',
			imageBtnNext: '<?php echo JURI::base().'components/com_wedding/media/images/lightbox-btn-prev.gif';?>',
			imageBlank: '<?php echo JURI::base().'components/com_wedding/media/images/lightbox-blank.gif';?>'
		});
	});
</script>