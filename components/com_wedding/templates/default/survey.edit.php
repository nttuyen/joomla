<?php
defined('_JEXEC') or die();
$Itemid = JRequest::getInt('Itemid');
?>
<form method="post" action="index.php">
	<fieldset class="list-fieldset">
		<legend>Sửa thăm dò</legend>
		<table>
			<tr>
				<td width="120">
					Câu hỏi
				</td>
				<td><input type="text" class="inputbox" size="60" name="question" value="<?php echo $this->rows->survey->question;?>" /></td>
			</tr>
			<tr>
				<td>Hiển thị</td>
				<td>
					<input type="radio" name="published" value="1"<?php if($this->rows->survey->published) echo ' checked="checked"';?> />&nbsp;Có&nbsp;&nbsp;
					<input type="radio" name="published" value="0"<?php if(!$this->rows->survey->published) echo ' checked="checked"';?> />&nbsp;Không
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" class="inputbox" value="Ghi Lại" />
				</td>
			</tr>
		</table>
	</fieldset>
	<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />
	<input type="hidden" name="id" value="<?php echo $this->rows->survey->id;?>" />
	<input type="hidden" name="option" value="com_wedding" />
	<input type="hidden" name="view" value="survey" />
	<input type="hidden" name="layout" value="save" />
</form>

<form method="post" action="index.php">
	<fieldset class="list-fieldset">
		<legend>Thêm mới câu trả lời</legend>
		<table>
			<tr>
				<td width="120">
					Câu trả lời
				</td>
				<td><input type="text" class="inputbox" size="60" name="answer" value="" /></td>
			</tr>
			<tr>
				<td>Đúng / Sai</td>
				<td>
					<input type="radio" name="is_correct" value="1" />&nbsp;Đúng&nbsp;&nbsp;
					<input type="radio" name="is_correct" value="0" checked="checked" />&nbsp;Sai
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" class="inputbox" value="Ghi Lại" />
				</td>
			</tr>
		</table>
	</fieldset>
	<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />
	<input type="hidden" name="survey_id" value="<?php echo $this->rows->survey->id;?>" />
	<input type="hidden" name="option" value="com_wedding" />
	<input type="hidden" name="view" value="survey" />
	<input type="hidden" name="layout" value="saveanswer" />
</form>

<fieldset class="list-fieldset">
	<legend>Các câu trả lời</legend>
	<table class="list-table">
		<thead>
			<tr>
				<th>Câu trả lời</th>
				<th>Số người chọn</th>
				<th>Đúng/Sai</th>
				<th>Xóa</th>
			</tr>
		</thead>
		<tbody>
	<?php
	if($this->rows->answers)
	{
		$i = 0;
		foreach ($this->rows->answers as $answer)
		{
			$cstr = $answer->is_correct ? 'Đúng' : 'Sai';
			$clink = 'index.php?option=com_wedding&view=survey&layout=correct&survey_id='.$answer->survey_id.'&id='.$answer->id.'&Itemid='.$Itemid;
			$dlink = 'index.php?option=com_wedding&view=survey&layout=removeanswer&survey_id='.$answer->survey_id.'&id='.$answer->id.'&Itemid='.$Itemid;
			$elink = 'index.php?option=com_wedding&view=survey&layout=ansedit&id='.$answer->id.'&Itemid='.$Itemid;
	?>
			<tr class="row<?php echo $i%2;?>">
				<td>
					<a href="<?php echo $elink;?>">
						<?php echo $answer->answer;?>
					</a>
				</td>
				<td>
					<?php echo $answer->total;?>
				</td>
				<td>
					<a href="<?php echo $clink;?>">
						<?php echo $cstr;?>
					</a>
				</td>
				<td>
					<a href="<?php echo $dlink;?>" onclick="return confirm('Bạn có muốn xóa câu trả lời này?');">
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
				<td colspan="4">Chưa có câu trả lời nào</td>
			</tr>
	<?php } ?>
		</tbody>
	</table>
</fieldset>