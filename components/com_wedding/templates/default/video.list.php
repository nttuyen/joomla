<?php
defined('_JEXEC') or die();
$Itemid = JRequest::getInt('Itemid');
?>
<form method="post" action="index.php" enctype="multipart/form-data">
	<fieldset class="list-fieldset">
		<legend>Thêm mới video</legend>
		<table>
			<tr>
				<td width="160">Tên video</td>
				<td><input type="text" name="title" value="" class="inputbox" size="50" /></td>
			</tr>
			<tr>
				<td>Loại video</td>
				<td>
					<input type="radio" name="type" id="embedtype" value="1" checked="checked" onclick="changeType()" />&nbsp;Mã nhúng&nbsp;&nbsp;
					<input type="radio" name="type" id="uploadtype" value="0" onclick="changeType()" />&nbsp;Upload file
				</td>
			</tr>
			<tr>
				<td id="typetile">Mã nhúng</td>
				<td>
					<textarea id="embedtype_value" name="embed" rows="15" cols="60"></textarea>
					<input type="file" id="uploadtype_value" name="file" style="display:none" />
				</td>
			</tr>
			<tr>
				<td>
					Hiển thị
				</td>
				<td>
					<input type="radio" name="published" value="1" checked="checked" />&nbsp;Có&nbsp;&nbsp;
					<input type="radio" name="published" value="" />&nbsp;Không&nbsp;&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" value="Ghi Lại" class="inputbox" />
				</td>
			</tr>
		</table>
	</fieldset>
	<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />
	<input type="hidden" name="option" value="com_wedding" />
	<input type="hidden" name="view" value="video" />
	<input type="hidden" name="layout" value="save" />
</form>

<fieldset class="list-fieldset">
	<legend>Các video đã upload</legend>
	<table class="list-table">
		<thead>
			<tr>
				<th>Tên video</th>
				<th>Hiển thị</th>
				<th>Xóa</th>
			</tr>
		</thead>
		<tbody>
	<?php
	if($this->rows->videos)
	{
		$i = 0;
		foreach ($this->rows->videos as $video)
		{
			$pstr = $video->published ? 'Có' : 'Không';
			$plink = 'index.php?option=com_wedding&view=video&layout=publish&id='.$video->id.'&Itemid='.$Itemid;
			$dlink = 'index.php?option=com_wedding&view=video&layout=remove&id='.$video->id.'&Itemid='.$Itemid;
			$elink = 'index.php?option=com_wedding&view=video&layout=edit&id='.$video->id.'&Itemid='.$Itemid;
	?>
			<tr class="row<?php echo $i;?>">
				<td>
					<a href="<?php echo $elink;?>">
						<?php echo $video->title;?>
					</a>
				</td>
				<td>
					<a href="<?php echo $plink;?>">
						<?php echo $pstr;?>
					</a>
				</td>
				<td>
					<a href="<?php echo $dlink;?>" onclick="return confirm('Bạn có muốn xóa video này không?');">
						Xóa
					</a>
				</td>
			</tr>
	<?php
			$i = 1-$i;
		}
	}
	else
	{
	?>
			<tr>
				<td colspan="3">
					Chưa có video nào
				</td>
			</tr>
	
	<?php } ?>
		</tbody>
	</table>
</fieldset>

<script type="text/javascript">
	function changeType()
	{
		embedElement = document.getElementById('embedtype');
		
		if(embedElement.checked)
		{
			document.getElementById('typetile').innerHTML = 'Mã Nhúng';
			document.getElementById('embedtype_value').style.display = 'block';
			document.getElementById('uploadtype_value').style.display = 'none';
		}
		else
		{
			document.getElementById('typetile').innerHTML = 'Upload File';
			document.getElementById('embedtype_value').style.display = 'none';
			document.getElementById('uploadtype_value').style.display = 'block';
		}
	}
</script>