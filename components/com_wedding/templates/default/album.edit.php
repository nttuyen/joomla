<?php
defined('_JEXEC') or die();
$Itemid = JRequest::getInt('Itemid');
?>
<fieldset class="list-fieldset">
	<legend>Sửa Album</legend>
	<form method="post" action="index.php" enctype="multipart/form-data">
		<table>
			<tr>
				<td width="160">Tên Album</td>
				<td><input type="text" name="title" value="<?php echo $this->rows->album->title;?>" class="inputbox" size="50" /></td>
			</tr>
			<tr>
				<td>Ảnh minh họa</td>
				<td>
				<?php if(!empty($this->rows->album->thumbnail) && file_exists($this->rows->album->thumbnail)) { ?>
					<img src="<?php echo $this->rows->album->thumbnail;?>" /><br/>
				<?php } ?>				
					<input type="file" name="image" />
				</td>
			</tr>
			<tr>
				<td>Giới thiệu</td>
				<td>
					<?php
						$editor = & JFactory::getEditor();
						echo $editor->display('intro', $this->rows->album->intro, '550', '200', '60', '15', false);
					?>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" class="inputbox" value="Ghi Lại" />
				</td>
			</tr>
		</table>
		<input type="hidden" name="id" value="<?php echo $this->rows->album->id;?>" />
		<input type="hidden" name="old_image" value="<?php echo $this->rows->album->thumbnail;?>" />
		<input type="hidden" name="option" value="com_wedding" />
		<input type="hidden" name="view" value="album" />
		<input type="hidden" name="task" value="save" />
		<input type="hidden" name="Itemid" value="<?php echo JRequest::getInt('Itemid');?>" />
	</form>
</fieldset>

<fieldset class="list-fieldset">
	<legend>Upload ảnh vào album</legend>
	<form method="post" action="index.php" enctype="multipart/form-data">
		<table>
			<tr>
				<td>Tên ảnh</td>
				<td><input type="text" name="title" value="" /></td>
			</tr>
			<tr>
				<td>Upload Ảnh</td>
				<td><input type="file" name="image" /></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" class="inputbox" value="Ghi Lại" />
				</td>
			</tr>
		</table>
		<input type="hidden" name="album_id" value="<?php echo $this->rows->album->id;?>" />
		<input type="hidden" name="option" value="com_wedding" />
		<input type="hidden" name="view" value="album" />
		<input type="hidden" name="task" value="savephoto" />
		<input type="hidden" name="Itemid" value="<?php echo JRequest::getInt('Itemid');?>" />
	</form>
</fieldset>

<fieldset class="list-fieldset">
	<legend>Các ảnh đã upload trong album</legend>
	
<?php
if($this->rows->photos)
{
	foreach ($this->rows->photos as $photo)
	{
		$dlink = 'index.php?option=com_wedding&view=album&layout=removephoto&album_id='.$photo->album_id.'&id='.$photo->id;
	?>
	<div style="float:left;width: 120px; height: 110px; margin-right: 10px; margin-bottom: 5px;">
	<div class="photo-item" style="width: 120px; height: 90px; overflow:hidden;">
		<img src="<?php echo $photo->thumbnail;?>" /> <br />
		
	</div>
	<a href="<?php echo $dlink;?>" onclick="return confirm('Bạn có muốn xóa ảnh này không?');">Xóa</a>
	</div>

<?php
	}
	echo '<div>'.$this->rows->pagination->getPagesLinks().'</div>';
}
?>

</fieldset>

<div style="clear:both;"><span></span></div>
