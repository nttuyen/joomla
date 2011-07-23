<?php
defined('_JEXEC') or die();

if($this->rows->survey)
{
?>
<div class="survey-question"><?php echo $this->rows->survey->question;?></div>	

<?php if($this->rows->survey->answers) { ?>
<div class="survey-answers">
	<ul>
	<?php foreach ($this->rows->survey->answers as $ans) { ?>
		<li><?php echo $ans->answer;?>: <?php echo (int)$ans->total;?></li>	
	<?php } ?>
	</ul>
</div>
<?php } ?>

<?php
}