<fieldset class="adminform">
	<legend>Blah blah</legend>
	<form method="post" action="index.php" name="adminForm" id="adminForm">
		<ul class="adminformlist">
			<li>
				<label for="title">
					<?php echo JText::_('COM_WEDDING_TEMPLATES_NAME');?>
				</label>
				<input type="text" id="title" name="title" class="inputbox" size="50" value="<?php if($this->item) echo $this->item->title;?>" />
			</li>
			<li>
				<label for="url">
					<?php echo JText::_('COM_WEDDING_TEMPLATES_CODE');?>
				</label>
				<input type="text" id="code" name="code" class="inputbox" size="50" value="<?php if($this->item) echo $this->item->code;?>" />				
			</li>
			<li>
				<label>
					<?php echo JText::_('COM_WEDDING_TEMPLATES_DEFAULT');?>
				</label>
				<fieldset class="radio inputform">
					<input type="radio" name="default" id="default_1" value="1"<?php if($this->item && $this->item->default==1) echo ' checked="checked"';?> />
					<label for="default_1"><?php echo JText::_('COM_WEDDING_YES');?></label>
					<input type="radio" name="default" id="default_0" value="0"<?php if(!$this->item || $this->item->default==0) echo ' checked="checked"';?> />
					<label for="default_0"><?php echo JText::_('COM_WEDDING_NO');?></label>
				</fieldset>
			</li>
			<li>
				<label>
					<?php echo JText::_('COM_WEDDING_APPS_PUBLISH');?>
				</label>
				<fieldset class="radio inputform">
					<input type="radio" name="published" id="publish_1" value="1"<?php if(!$this->item || $this->item->published==1) echo ' checked="checked"';?> />
					<label for="publish_1"><?php echo JText::_('COM_WEDDING_YES');?></label>
					<input type="radio" name="published" id="publish_0" value="0"<?php if($this->item && $this->item->published==0) echo ' checked="checked"';?> />
					<label for="publish_0"><?php echo JText::_('COM_WEDDING_NO');?></label>
				</fieldset>
			</li>
		</ul>
		<input type="hidden" name="option" value="com_wedding" />
		<input type="hidden" name="view" value="templates" />
		<input type="hidden" name="task" value="" />
		<?php if($this->item) { ?>
		<input type="hidden" name="id" value="<?php echo $this->item->id;?>" />
		<?php } ?>
		<?php echo JHtml::_('form.token');?>
	</form>
</fieldset>