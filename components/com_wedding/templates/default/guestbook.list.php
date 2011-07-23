<?php
defined('_JEXEC') or die();
$Itemid = JRequest::getInt('Itemid');
?>
<fieldset class="list-fieldset">
	<table class="list-table">
		<thead>
			<tr>
				<th>Người gửi</th>
				<th>Nội dung</th>
				<th>Hiển thị</th>
				<th>Xóa</th>
			</tr>
		</thead>
		<tbody>
<?php
if($this->rows->guestbooks)
{
	$i = 0;
	foreach ($this->rows->guestbooks as $gb)
	{
		$dlink = 'index.php?option=com_wedding&view=guestbook&layout=remove&id='.$gb->id.'&Itemid='.$Itemid;
		$plink = 'index.php?option=com_wedding&view=guestbook&layout=publish&id='.$gb->id.'&Itemid='.$Itemid;
		$show = $gb->published ? 'Có' : 'Không';
?>
			<tr class="row<?php echo $i%2;?>">
				<td><?php echo $gb->from_name;?></td>
				<td><?php echo $gb->content;?></td>
				<td>
					<a href="<?php echo $plink;?>"><?php echo $show;?></a>
				</td>
				<td>
					<a href="<?php echo $dlink;?>">Xóa</a>
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
				<td colspan="4">Bạn chưa có lời chúc nào</td>
			</tr>
<?php } ?>
		</tbody>
		<tfoot>
			<td colspan="4"><?php echo $this->rows->pagination->getPagesLinks();?></td>
		</tfoot>
	</table>
</fieldset>