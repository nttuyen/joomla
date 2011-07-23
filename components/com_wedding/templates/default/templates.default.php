<?php
if($this->juser->guest)
{
	echo 'Bạn phải đăng nhập để sử dụng chức năng này';
	return ;
}

$document = & JFactory::getDocument();
$document->addStyleSheet($this->css.'general.css');
$Itemid = JRequest::getInt('Itemid');
?>
<fieldset class="list-fieldset">
	<legend>Mẫu website đang dùng</legend>
	<div class="col2">
		<div class="title"><?php echo $this->user_template->title;?></div>
		<div class="thumbnail">
			<img src="<?php echo weddingHelper::getTemplateFolder('', $this->user_template->code).'template_thumbnail.png';?>" />
		</div>
	</div>
	<div style="clear:both"><span></span></div>
</fieldset>

<form name="frmTemplate" action="index.php" method="post" >

	<fieldset class="list-fieldset">
		<legend>Chọn mẫu website khác</legend>
	<?php
	$i = 0;
	foreach ($this->templates as $tpl)
	{
		if($tpl->id == $this->user_template->id)
			continue;	
	?>
			<div class="col2">
				<div class="title">
					<input onclick="doSubmit('tpl_<?php echo $tpl->id;?>')" type="radio" name="template_id" id="tpl_<?php echo $tpl->id;?>" value="<?php echo $tpl->id;?>" />
					<label for="tpl_<?php echo $tpl->id;?>"><?php echo $tpl->title;?></label>
				</div>
				<div class="thumbnail">
					<img src="<?php echo weddingHelper::getTemplateFolder('', $tpl->code).'template_thumbnail.png';?>" />
				</div>
			</div>
			
	<?php
		$i++;
		if($i%2==0)
			echo '<div style="clear:both"><span></span></div>';
	}
	?>
	<div style="clear:both"><span></span></div>
	</fieldset>
	<input type="hidden" name="option" value="com_wedding" />
	<input type="hidden" name="view" value="templates" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />
</form>

<script type="text/javascript">
	function doSubmit(tpl_id)
	{
		checkObj = document.getElementById(tpl_id);
		if(checkObj.checked)
		{
			document.frmTemplate.submit();
		}
	}
</script>