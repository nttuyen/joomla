<?php
/**
 * aPoll Voting Component
 *
 * @version     $Id: default.php 156 2011-01-30 16:33:35Z harrygg $
 * @package     Joomla
 * @copyright   Copyright (C) 2009 - 2010 aFactory. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// No Direct Access
defined( '_JEXEC' ) or die;
 
$document = JFactory::getDocument();	 
$document->addStyleDeclaration("
div#apoll_loading_".$poll->id."{background: url(media/system/images/mootree_loader.gif) 0% 50% no-repeat;
width:100%; height:20px; padding: 4px 0 0 20px;}
.apoll_refresh_btn {padding-top:5px; display:block;}
#apoll_total_votes {padding-top:0px;}
.apoll_loading_img {background: url(media/system/images/mootree_loader.gif) right top no-repeat;}
.apoll_options_text_div{padding:3px;}
.apoll_options_container {width:98%; height:10px; padding:1px; border:1px solid #ccc}
.apoll_bars {height:10px;}
.apoll_error_msg {color:red; margin:5px 0; display:block;}
");

// add mootools
JHTML::_('behavior.mootools');
$document->addScript('modules/mod_apoll/tmpl/mod_apoll.js');
JText::script('MOD_APOLL_TOTAL_VOTES');
$js = "
window.addEvent('domready', function() {

	var apoll_divs = $$('div.apoll_divs');
	apoll_divs.each(function (container){
		var apoll_vote = new apollVoteClass(container);
	});
});
";

$document->addScriptDeclaration($js);


?>

<div class="apoll_<?php echo $params->get('moduleclass_sfx'); ?>">

<?php if ($params->get('show_poll_title')) : ?>
    <h4 class="apoll_mod_title"><?php echo $poll->title; ?></h4>
<?php endif; ?>

<div id="apoll_div_<?php echo $poll->id; ?>" class="apoll_divs">

<?php if ($display_poll) { ?>

    <form action="index.php" method="post" name="apoll_form_<?php echo $poll->id; ?>" id="apoll_form_<?php echo $poll->id; ?>">

    <?php $n = count($options); for($i=0; $i<$n; $i++): ?>
        <label for="apoll_option_id<?php echo $options[$i]->id;?>" class="<?php echo $tabclass_arr[$tabcnt].$params->get('moduleclass_sfx'); ?>" style="display:block; padding:2px;">
            <input type="radio" name="apoll_option" id="apoll_option_id<?php echo $options[$i]->id;?>" value="<?php echo $options[$i]->id;?>" alt="<?php echo $options[$i]->id;?>" <?php echo $disabled; ?> />
            <?php echo $options[$i]->text; ?>
	</label>
        <?php $tabcnt = 1 - $tabcnt; endfor; ?>
			
        <?php if($params->get('show_msg')) : ?>        
        <div class="apoll_error_msg">
            <?php echo JText::_($msg); ?>
        </div>
        <?php endif; ?>

        <div style="padding:2px;" id="apoll_buttons_<?php echo $poll->id;?>" >
        <?php if($disabled == ''): ?>
            <input type="submit" id="apoll_submit_vote_<?php echo $poll->id; ?>" name="task_button" class="button" value="<?php echo JText::_('MOD_APOLL_VOTE'); ?>" <?php echo $disabled; ?> />
	<?php endif; ?>
        </div>
	<div id="apoll_loading_<?php echo $poll->id;?>" style="display:none;">
            <?php echo JText::_('MOD_APOLL_PROCESSING...'); ?>
	</div>		

	<input type="hidden" name="option" value="com_apoll" />
	<input type="hidden" name="poll_id" id="poll_id" value="<?php echo $poll->id;?>" />
        <input type="hidden" name="format"  value="json" />
        <input type="hidden" name="view"  value="poll" />
        <input type="hidden" name="show_total"  value="<?php echo $params->get('show_total'); ?>" />
	<div><?php echo JHTML::_( 'form.token' ); ?></div>
</form>

<?php 
//If user has voted 
} else { 

    foreach ($options as $option) :
        $percent = ($total_votes)? round((100*$option->votes)/$total_votes, 1) : 0;
        $width = ($percent) ? $percent : 2;
        ?>

        <div>
            <div class="apoll_options_text_div"><?php echo $option->text." - ".$percent; ?>%</div>
            <div class="apoll_options_container">
                <div class="apoll_bars" style="width: <?php echo $width; ?>%; background:<?php echo $option->color; ?>;"></div>
            </div>
        </div>
<?php endforeach; ?>

<?php if($params->get('show_total')): ?>
    <br />
    <b><?php echo JText::_('MOD_APOLL_TOTAL_VOTES'); ?></b> <span id="apoll_total_votes"><?php echo $total_votes; ?></span>
<?php endif; ?>

<?php if($params->get('show_msg')) :  ?>
    <div class="apoll_error_msg">
        <?php echo JText::_($msg); ?>
    </div>
<?php endif; ?>

    <a class="apoll_refresh_btn" id="apoll_refresh_btn_<?php echo $poll->id; ?>" href="#"><?php echo JText::_('MOD_APOLL_REFRESH_RESULTS'); ?></a>

<?php } ?>

<!-- End of #apolldiv -->
</div>


<!-- End of module .apoll_ -->
</div>