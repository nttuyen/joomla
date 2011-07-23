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
					<?php echo JText::_('COM_WEDDING_TEMPLATES_NAME');?>
				</th>
				<th>
					<?php echo JText::_('COM_WEDDING_TEMPLATES_CODE');?>
				</th>
				<th>
					<?php echo JText::_('COM_WEDDING_TEMPLATES_DEFAULT');?>
				</th>
				<th>
					<?php echo JText::_('COM_WEDDING_TEMPLATES_PUBLISH');?>
				</th>
			</tr>
		</thead>		
		<tbody>
		<?php
		if($this->items)
		{
			$i = 0;
			$n = count($this->items);
			$juser = & JFactory::getUser();
			foreach ($this->items AS $item)
			{
				$checked = JHtml::_('grid.id', $i, $item->id);
				$editLink = 'index.php?option=com_wedding&view=templates&layout=edit&cid[]='.$item->id;
				$published = JHtml::_('jgrid.published', $item->published, $i);
				$default = JHtml::_('jgrid.isdefault', $item->is_default, $i, '', !$item->is_default);
		?>
			<tr class="row<?php echo $i%2;?>">
				<td><?php echo $checked; ?></td>
				<td><?php echo $i+1;?></td>
				<td>
					<a href="<?php echo $editLink;?>">
						<?php echo $item->title;?>
					</a>
				</td>
				<td><?php echo $item->code;?></td>				
				<td><?php echo $default;?></td>
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
					<?php echo JText::_('COM_WEDDING_NO_TEMPLATE');?>
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
	<input type="hidden" name="option" value="com_wedding" />
	<input type="hidden" name="view" value="templates" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="" />
	<?php echo JHtml::_('form.token');?>
</form>