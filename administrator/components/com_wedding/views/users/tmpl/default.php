<form method="post" action="index.php" name="adminForm" id="adminForm">
	<table class="adminlist">
		<thead>
			<tr>
				<th width="5">
					<input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
				</th>
				<th width="15">
					<?php echo JText::_('COM_WEDDING_NUMBER');?>
				</th>
				<th>
					<?php echo JText::_('COM_WEDDING_USERNAME');?>
				</th>
				<th>
					<?php echo JText::_('COM_WEDDING_EMAIL');?>
				</th>
				<th>
					<?php echo JText::_('COM_WEDDING_COUNTRY');?>
				</th>
				<th>
					<?php echo JText::_('COM_WEDDING_BLOCKED');?>
				</th>
			</tr>
		</thead>		
		<tbody>
		<?php
		if($this->items)
		{
			$i = 0;
			$juser = & JFactory::getUser();
			foreach ($this->items AS $item)
			{
				$checked = JHtml::_('grid.id', $i, $item->id);
				$editLink = 'index.php?option=com_wedding&view=users&layout=edit&cid[]='.$item->user_id;
				$published = JHtml::_('jgrid.published', !$item->block, $i, 'wedding.', $juser->id != $item->id);
		?>
			<tr class="row<?php echo $i%2;?>">
				<td><?php echo $checked; ?></td>
				<td><?php echo $i+1;?></td>
				<td>
					<a href="<?php echo $editLink;?>">
						<?php echo $item->username;?>
					</a>
				</td>
				<td><?php echo $item->email;?></td>
				<td><?php echo $item->country;?></td>
				<td><?php echo $published;?></td>
			</tr>
		<?php
				$i++;
			}
		}
		else
		{
		?>
			
			<tr class="row0">
				<td colspan="6">
					<?php echo JText::_('COM_WEDDING_NO_USER');?>
				</td>
			</tr>
		
		<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6">
					<?php echo $this->pagination->getPagesLinks();?>
				</td>
			</tr>
		</tfoot>
	</table>
	<input type="hidden" name="boxchecked" value="" />
</form>