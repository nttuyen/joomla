<?php
defined('_JEXEC') or die();
if($this->rows->survey)
{
	$disabled = '';
	if($this->rows->is_voted)
		$disabled = ' disabled="disabled"';
	$dlink = JURI::base().$this->rows->cuser->username.'/survey/'.$this->rows->survey->id.'/';
?>
<div class="survey-wrap">
	<div class="survey-question"><?php echo $this->rows->survey->question;?></div>
	<div class="survey-answers">
	<?php if($this->rows->survey->answers) { ?>
	<form method="post" action="index.php">
		<ul>
	<?php foreach ($this->rows->survey->answers as $ans) { ?>
			<li>
				<input type="radio" name="answer_id" id="answer_<?php echo $ans->id;?>" value="<?php echo $ans->id;?>"<?php echo $disabled;?> />
				<label for="answer_<?php echo $ans->id;?>"><?php echo $ans->answer;?></label>
			</li>
	<?php } ?>
		</ul>
		<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />
		<input type="hidden" name="survey_id" value="<?php echo $this->rows->survey->id;?>" />
		<input type="hidden" name="option" value="com_wedding" />
		<input type="hidden" name="view" value="survey" />
		<input type="hidden" name="layout" value="dosurvey" />
		<div class="survey_smt">
			<input type="submit" class="inputbox" value="Gửi ý kiến" />&nbsp;&nbsp;
			<input type="button" class="inputbox" value="Xem chi tiết" onclick="window.location.href='<?php echo $dlink;?>';" />
		</div>
	</form>
	<?php } ?>
	</div>
</div>
<div class="pagination"><?php echo $this->rows->survey->pagination->getPagesLinks();?></div>
<?php
}