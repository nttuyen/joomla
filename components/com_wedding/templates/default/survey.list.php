<?php
defined('_JEXEC') or die();
$Itemid = JRequest::getInt('Itemid');
?>
<form method="post" action="index.php">
	<fieldset class="list-fieldset">
		<legend>Thêm mới</legend>
		<table>
			<tr>
				<td width="120">
					Câu hỏi
				</td>
				<td><input type="text" class="inputbox" size="60" name="question" value="" /></td>
			</tr>
			<tr>
				<td>Hiển thị</td>
				<td>
					<input type="radio" name="published" value="1" checked="checked" />&nbsp;Có&nbsp;&nbsp;
					<input type="radio" name="published" value="0" />&nbsp;Không
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
	<input type="hidden" name="option" value="com_wedding" />
	<input type="hidden" name="view" value="survey" />
	<input type="hidden" name="layout" value="save" />
</form>

<fieldset class="list-fieldset">
	<legend>Thăm dò đã tạo</legend>
	<table class="list-table">
		<thead>
			<tr>
				<th>Câu hỏi</th>
				<th>Hiển thị</th>
				<th>Xóa</th>
			</tr>
		</thead>
		<tbody>
	<?php
	if($this->rows->surveys)
	{
		$i = 0;
		foreach ($this->rows->surveys as $survey)
		{
			$pstr = $survey->published ? 'Có' : 'Không';
			$plink = 'index.php?option=com_wedding&view=survey&layout=publish&id='.$survey->id.'&Itemid='.$Itemid;
			$dlink = 'index.php?option=com_wedding&view=survey&layout=remove&id='.$survey->id.'&Itemid='.$Itemid;
			$elink = 'index.php?option=com_wedding&view=survey&layout=edit&survey_id='.$survey->id.'&Itemid='.$Itemid;
	?>
			<tr class="row<?php echo $i%2;?>">
				<td>
					<a href="<?php echo $elink;?>">
						<?php echo $survey->question;?>
					</a>
				</td>
				<td>
					<a href="<?php echo $plink;?>">
						<?php echo $pstr;?>
					</a>
				</td>
				<td>
					<a href="<?php echo $dlink;?>" onclick="return confirm('Bạn có muốn xóa thăm dò này?');">
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
				<td colspan="3">Chưa có thăm dò nào</td>
			</tr>
	<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3"><?php echo $this->rows->pagination->getPagesLinks();?></td>
			</tr>
		</tfoot>
	</table>
</fieldset>