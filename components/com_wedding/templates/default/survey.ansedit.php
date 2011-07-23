<?php
defined('_JEXEC') or die();
$Itemid = JRequest::getInt('Itemid');
?>
<form method="post" action="index.php">
	<fieldset class="list-fieldset">
		<legend>Sửa câu trả lời</legend>
		<table>
			<tr>
				<td width="120">
					Câu trả lời
				</td>
				<td><input type="text" class="inputbox" size="60" name="answer" value="<?php echo $this->rows->answer->answer;?>" /></td>
			</tr>
			<tr>
				<td>Đúng / Sai</td>
				<td>
					<input type="radio" name="is_correct" value="1"<?php if($this->rows->answer->is_correct) echo ' checked="checked"';?> />&nbsp;Đúng&nbsp;&nbsp;
					<input type="radio" name="is_correct" value="0"<?php if(!$this->rows->answer->is_correct) echo ' checked="checked"';?> />&nbsp;Sai
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
	<input type="hidden" name="id" value="<?php echo $this->rows->answer->id;?>" />
	<input type="hidden" name="survey_id" value="<?php echo $this->rows->answer->survey_id;?>" />
	<input type="hidden" name="option" value="com_wedding" />
	<input type="hidden" name="view" value="survey" />
	<input type="hidden" name="layout" value="saveanswer" />
</form>