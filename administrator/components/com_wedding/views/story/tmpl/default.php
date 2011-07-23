<?php defined('_JEXEC') or die();?>
<form method="post" action="index.php" name="adminForm" id="adminForm">
	<table class="adminlist">
		<thead>
			<tr>
				<th width="5">
					<input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
				</th>
				<th>Tên Chuyện</th>
				<th>Giới thiệu</th>
				<th>Người viết</th>
				<th>Trang Chủ</th>
			</tr>
		</thead>
		<tbody>
		<?php
		if($this->items)
		{
			$i = 0;
			foreach ($this->items as $item)
			{
				$checked = JHtml::_('grid.id', $i, $item->id);
				$published = JHtml::_('jgrid.published', $item->featured, $i);
				$dlink = 'index.php?option=com_wedding&view=story&task=details&cid[]='.$item->id;
		?>
			<tr class="<?php echo $i%2;?>">
				<td><?php echo $checked;?></td>
				<td>
					<a href="<?php echo $dlink;?>">
						<?php echo $item->title;?>
					</a>
				</td>
				<td>
					<?php echo $item->intro;?>
				</td>
				<td>
					<?php echo $item->username;?>
				</td>
				<td><?php echo $published;?></td>
			</tr>
		<?php
				$i++;
			}
		} else {
		?>
			<tr>
				<td colspan="5">Chưa có album nào</td>
			</tr>
		<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="5">
					<?php echo $this->pagination->getPagesLinks();?>
				</td>
			</tr>
		</tfoot>
	</table>
	<input type="hidden" name="option" value="com_wedding" />
	<input type="hidden" name="view" value="story" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="" />
	<?php echo JHtml::_('form.token');?>
</form>