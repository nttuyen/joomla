<?php defined('_JEXEC') or die();?>
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
					<?php echo JText::_('COM_WEDDING_APPS_TITLE');?>
				</th>
				<th>
					<?php echo JText::_('COM_WEDDING_APPS_URL');?>
				</th>
				<th>
					<?php echo JText::_('COM_WEDDING_APPS_DEFAULT');?>
				</th>
				<th>
					<?php echo JText::_('COM_WEDDING_APPS_ORDERING');?>
					<?php echo JHtml::_('grid.order',  $this->items); ?>
				</th>
				<th>
					<?php echo JText::_('COM_WEDDING_APPS_PUBLISH');?>
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
				$editLink = 'index.php?option=com_wedding&view=apps&layout=edit&cid[]='.$item->id;
				$published = JHtml::_('jgrid.published', $item->published, $i);
				$default = JHtml::_('jgrid.isdefault', $item->is_default, $i);
		?>
			<tr class="row<?php echo $i%2;?>">
				<td><?php echo $checked; ?></td>
				<td><?php echo $i+1;?></td>
				<td>
					<a href="<?php echo $editLink;?>">
						<?php echo $item->title;?>
					</a>
				</td>
				<td><?php echo $item->url;?></td>	
				<td>
					<?php echo $default;?>
				</td>			
				<td class="order">
					<span><?php echo $this->pagination->orderUpIcon($i, $item->ordering > 1);?></span>
					<span><?php echo $this->pagination->orderDownIcon($i, $n, $item->ordering < $this->maxOrder);?></span>
					<input class="text-area-order" type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" />
				</td>
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
					<?php echo JText::_('COM_WEDDING_NO_APP');?>
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
	<input type="hidden" name="view" value="apps" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="" />
	<?php echo JHtml::_('form.token');?>
</form>