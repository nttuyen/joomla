<?php
defined('_JEXEC') or die('Restricted Access');
?>
<form method="post" action="index.php" enctype="multipart/form-data">
	<fieldset class="list-fieldset">
		<legend>Thêm mới</legend>
		<table>
			<tr>
				<td width="160">
					Tiêu đề:
				</td>
				<td>
					<input type="text" size="50" class="inputbox" name="title" value="" />
				</td>
			</tr>
			<tr>
				<td>
					Giới thiệu:
				</td>
				<td>
					<?php
						$editor = & JFactory::getEditor();
						echo $editor->display('intro', '', '550', '200', '60', '15', false);
					?>
				</td>
			</tr>
			<tr>
				<td>Nội dung:</td>
				<td>
					<?php
						$editor = & JFactory::getEditor();
						echo $editor->display('content', '', '550', '400', '60', '35', false);
					?>
				</td>
			</tr>
			<tr>
				<td>Ảnh:</td>
				<td>
					<input type="file" name="image" />
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" class="inputbox" value="Ghi Lại" /></td>
			</tr>
		</table>
	</fieldset>
	<input type="hidden" name="option" value="com_wedding" />
	<input type="hidden" name="view" value="plant" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="Itemid" value="<?php echo JRequest::getInt('Itemid');?>" />
</form>

<fieldset class="list-fieldset">
	<legend>Các chuyện cũ</legend>
	<table>
	<thead>
		<tr>
			<th width="5">#</th>
			<th align="center">Tên chuyện</th>
			<th align="center">Xóa</th>
		</tr>
	</thead>
	<?php
	if($this->rows->stories)
	{
		$i = 0;
		foreach ($this->rows->stories as $story)
		{
			$elink = 'index.php?option=com_wedding&view=plant&layout=edit&id='.$story->id.'&Itemid='.JRequest::getInt('Itemid');
			$dlink = 'index.php?option=com_wedding&view=plant&layout=remove&id='.$story->id.'&Itemid='.JRequest::getInt('Itemid');
	?>
		<tr>
			<td><?php echo $i+1;?></td>
			<td>
				<a href="<?php echo $elink;?>">
					<?php echo $story->title;?>
				</a>
			</td>
			<td>
				<a href="<?php echo $dlink;?>">
					Xóa
				</a>
			</td>
		</tr>
	<?php
			$i++;
		}
	}
	else
	{
	?>
		<tr>
			<td colspan="3">Chưa có chuyện nào</td>				
		</tr>
	<?php }	?>
		<tr>
			<td colspan="3">
				<?php echo $this->rows->pagination->getPagesLinks();?>
			</td>
		</tr>
	</table>
</fieldset>