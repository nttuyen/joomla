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
				<td><input type="text" name="title" value="<?php echo $this->rows->video->title;?>" class="inputbox" size="50" /></td>
			</tr>
			<tr>
				<td><?php echo empty($this->rows->video->file) ? 'Mã nhúng' : 'file';?></td>
				<td>
					<?php if( empty($this->rows->video->file) ) { ?>					
					<textarea id="embedtype_value" name="embed" rows="15" cols="60"><?php echo stripslashes($this->rows->video->embed);?></textarea>
					<?php } else { ?>
					<?php echo $this->rows->video->file;?><br/>
					<input type="file" id="uploadtype_value" name="file" />
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td>
					Hiển thị
				</td>
				<td>
					<input type="radio" name="published" value="1"<?php if($this->rows->video->published) echo ' checked="checked"';?> />&nbsp;Có&nbsp;&nbsp;
					<input type="radio" name="published" value=""<?php if(!$this->rows->video->published) echo ' checked="checked"';?> />&nbsp;Không&nbsp;&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" value="Ghi Lại" class="inputbox" />
				</td>
			</tr>
		</table>
	</fieldset>
	<input type="hidden" name="id" value="<?php echo $this->rows->video->id;?>" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />
	<input type="hidden" name="option" value="com_wedding" />
	<input type="hidden" name="view" value="video" />
	<input type="hidden" name="layout" value="save" />
</form>