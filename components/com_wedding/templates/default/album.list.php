<?php
defined('_JEXEC') or die();
$Itemid = JRequest::getInt('Itemid');
?>
<fieldset class="list-fieldset">
	<legend>Tạo mới Album</legend>
	<form method="post" action="index.php" enctype="multipart/form-data">
		<table>
			<tr>
				<td width="160">Tên Album</td>
				<td><input type="text" name="title" value="" class="inputbox" size="50" /></td>
			</tr>
			<tr>
				<td>Ảnh minh họa</td>
				<td><input type="file" name="image" /></td>
			</tr>
			<tr>
				<td>Giới thiệu</td>
				<td>
					<?php
						$editor = & JFactory::getEditor();
						echo $editor->display('intro', $this->rows->intro, '550', '200', '60', '15', false);
					?>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" class="inputbox" value="Ghi Lại" />
				</td>
			</tr>
		</table>
		<input type="hidden" name="option" value="com_wedding" />
		<input type="hidden" name="view" value="album" />
		<input type="hidden" name="task" value="save" />
		<input type="hidden" name="Itemid" value="<?php echo JRequest::getInt('Itemid');?>" />
	</form>
</fieldset>

<fieldset class="list-fieldset">
	<legend>Album đã tạo</legend>
	<table class="list-table">
		<thead>
			<tr>
				<th>Tên album</th>
				<th width="200" align="center">Thêm ảnh</th>
				<th width="50" align="center">Xóa</th>
			</tr>
		</thead>
		<tbody>
	<?php
	if($this->rows->albums)
	{
		foreach ($this->rows->albums as $album)
		{
			$elink = 'index.php?option=com_wedding&view=album&layout=edit&album_id='.$album->id.'&Itemid='.$Itemid;
			$dlink = 'index.php?option=com_wedding&view=album&layout=remove&id='.$album->id.'&Itemid='.$Itemid;
	?>
			<tr class="row<?php echo $i%2;?>">
				<td>
					<a href="<?php echo $elink;?>">
						<?php echo $album->title;?>
					</a>
				</td>				
				<td align="center">
					<a href="<?php echo $elink;?>">
						Thêm ảnh
					</a>
				</td>
				<td align="center">
					<a href="<?php echo $dlink;?>" onclick="return confirm('Bạn có muốn xóa album \'<?php echo $album->title;?>\' này không?');">
						Xóa
					</a>
				</td>
			</tr>
	<?php
		}
	}
	else
	{
	?>
			<tr>
				<td colspan="2">Chưa có album nào</td>
			</tr>
	<?php } ?>
		</tbody>		
	</table>
</fieldset>
