<?php
defined('_JEXEC') or die();
$Itemid = JRequest::getInt('Itemid');
?>

<?php
if($this->rows->guestbooks)
{
	$i = 0;
	foreach ($this->rows->guestbooks as $gb)
	{
?>

	<div class="gb_item item<?php echo $i%2;?>">
		<div class="gb_content"><?php echo $gb->content;?></div>
		<div class="gb_from"><i>Gửi bởi: <?php echo $gb->from_name;?></i></div>
	</div>

<?php
		$i++;
	}
}
else
{
?>
	Bạn chưa có lời chúc nào
<?php } ?>

<fieldset class="list-fieldset">
	<legend>Gửi lời chúc</legend>
	<form method="post" action="<?php echo JURI::base();?>index.php">
		<table>
			<tr>
				<td>Người gửi</td>
				<td><input type="text" class="inputbox" size="50" name="from_name" value="" /></td>
			</tr>
			<tr>
				<td>Nội dung</td>
				<td>
					<?php
						$editor = & JFactory::getEditor();
						echo $editor->display('description', $this->rows->story->content, '450', '250', '60', '35', false);
					?>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" value="Ghi Lại" /></td>
			</tr>
		</table>
		<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />
		<input type="hidden" name="user_id" value="<?php echo $this->rows->cuser->user_id;?>" />
		<input type="hidden" name="option" value="com_wedding" />
		<input type="hidden" name="view" value="guestbook" />
		<input type="hidden" name="layout" value="save" />
	</form>
</fieldset>