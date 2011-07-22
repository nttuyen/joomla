<?php
/**
 * aPoll Voting Component
 *
 * @version     $Id$
 * @package     Joomla
 * @copyright   Copyright (C) 2009 - 2010 aFactory. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// No Direct Access
defined( '_JEXEC' ) or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

?>

<form action="<?php JRoute::_('index.php?option=com_apoll&layout=edit&id='.(int)$this->item->id); ?>" method="post" name="adminForm" id="poll-form" class="form-validate">
<div class="width-60 fltlft">
    <fieldset class="adminform">
        <legend><?php echo empty($this->item->id) ? JText::_('JACTION_CREATE') : JText::sprintf('JACTION_EDIT', $this->item->id); ?></legend>
        <ul class="adminformlist">
            <li><?php echo $this->form->getLabel('title'); ?>
            <?php echo $this->form->getInput('title'); ?></li>

            <li><?php echo $this->form->getLabel('alias'); ?>
            <?php echo $this->form->getInput('alias'); ?></li>

            <li><?php echo $this->form->getLabel('state'); ?>
            <?php echo $this->form->getInput('state'); ?></li>

            <li><?php echo $this->form->getLabel('catid'); ?>
            <?php echo $this->form->getInput('catid'); ?></li>

        </ul>

    </fieldset>
         
    <fieldset class="adminform" id="apoll_options_fieldset"> 
       	
        <legend><?php echo empty($this->item->id) ? JText::_('COM_APOLL_ADD_OPTIONS') : JText::sprintf('COM_APOLL_EDIT_OPTIONS', $this->item->id); ?></legend>
			
            
            <input id="add_option_Btn" type="button" class="button hasTip" title="
			<?php echo JText::_('COM_APOLL_CLICK_TO_ADD_MORE'); ?>" value="<?php echo JText::_('COM_APOLL_ADD_OPTION'); ?>" />
        
        <div class="clr"></div>       
        <div id="apoll_options_holder" style="margin-top:10px;">        


<?php for ($i = 0, $n = count( $this->options ); $i < $n; $i++ ) : ?>
		
	<label id="apoll_option_label_<?php echo $this->options[$i]->id; ?>" for="" class="apoll_option_labels" >

            <span class="handle hasTip" title="<?php echo JText::_('COM_APOLL_DRAG'); ?>"><?php echo $i+1; ?></span>        
                        
            <input id="poll_option_<?php echo $this->options[$i]->id; ?>"
                name="poll_option[<?php echo $this->options[$i]->id; ?>]" class="inputbox hasTip"
		type="text" value = "<?php echo $this->options[$i]->text; ?>" size="50"
                title="<?php echo JText::_('COM_APOLL_INPUT_OPTION_TEXT'); ?>"
                style="" />
             
             <span id="outer<?php echo $this->options[$i]->id; ?>" class="outer hasTip"
                style="background-color:<?php echo $this->options[$i]->color; ?>;"
                title="<?php echo JText::_('COM_APOLL_PICK_COLOR'); ?>">

                 <img id="colorpicker<?php echo $this->options[$i]->id; ?>" class="colorpicker"
                     src="components/com_apoll/assets/apoll-arrow.gif" alt="[r]" /> 
             </span>               
                
            <input type="hidden" size="7" name="colorValue[<?php echo $this->options[$i]->id; ?>]"
                id="colorValue<?php echo $this->options[$i]->id; ?>"
                value="<?php echo $this->options[$i]->color; ?>" class="" />  
                                
            <input id="delete_me_<?php echo $this->options[$i]->id; ?>" type="button" class="delete_me hasTip"
                rel   = "<?php echo $this->options[$i]->id; ?>"
                title = "<?php echo JText::_('COM_APOLL_CLICK_TO_DELETE'); ?>"
                 />
                
             <input type="hidden" name="ordering[<?php echo $this->options[$i]->id; ?>]"
                id="ordering<?php echo $this->options[$i]->id; ?>" 
                value="<?php echo $this->options[$i]->ordering; ?>" size="1" class="ordering" />
             
            <span class="option_votes reset hasTip" title=""><?php echo $this->options[$i]->votes; ?></span>
            	
            <span class="option_votes_zeros reset" style="display:none;">0</span>
	</label>
			
		<?php  endfor;
                //if we are creating new poll show 2 empty options
                       for (; $i < 2; $i++) : ?>

		<label id="apoll_option_label_<?php echo $i; ?>" for="poll_option<?php echo $i; ?>" 
                    class="hasTip apoll_option_labels" title="COM_APOLL_DRAG">

                    <span class="handle"><?php echo $i+1; ?></span>
                 
                    <input class="inputbox poll_options required" type="text" name="poll_option[]" value = "" size="50"
			id= "poll_option<?php echo $i; ?>"/>

                     <span id="outer<?php echo $i; ?>" class="outer hasTip"
                           title = "<?php echo JText::_('COM_APOLL_PICK_COLOR'); ?>">

                        <img id="colorpicker<?php echo $i; ?>" class="colorpicker"
                             src="components/com_apoll/assets/apoll-arrow.gif" alt="[r]" />
                     </span>

            <input type="hidden" size="7" name="colorValue[]" id="colorValue<?php echo $i; ?>" value = "" class = "" />
            
            <input id="delete_me_<?php echo $i; ?>" class="delete_me hasTip" type="button"
                   title="<?php echo JText::_('COM_APOLL_CLICK_TO_DELETE'); ?>" />
   
            <input type="hidden" name="ordering[]" id="ordering<?php echo $i; ?>" value="<?php echo $i + 1; ?>"
                size="1" class="ordering hasTip" />
                                
	</label>
    <?php endfor; ?>

    </div>		
</fieldset>
    
<?php if (!empty($this->item->id) && $this->total_votes) : ?>     
    <fieldset class="adminform"> 
        <legend><?php echo JText::_('Votes') ?></legend>
        
        <label for="reset_votes">
            <span style="float:left; padding:3px;"><?php echo JText::_('COM_APOLL_TOTAL_VOTES') ?>:</span>
                <span id="total_votes" class="reset" style="float:left;">
                    <?php echo $this->total_votes; ?>
                </span>                
            
                <span id="total_votes_zero" class="reset" style="display:none; float: left">0
                </span>
        </label>
        
        <input id= "reset_votes_Btn" type="button" value="<?php echo JText::_('COM_APOLL_RESET_VOTES'); ?>"
            class="button hasTip" title="<?php echo JText::_('COM_APOLL_CLICK_TO_DELETE_VOTES'); ?>"/>
        
        <label class="hasTip" style="width:90%; ">
            <span class="reset" style="float:left;display:none; color:red;">
                <?php echo JText::_('COM_APOLL_DEL_VOTES_MESSAGE'); ?>
            </span>
        </label>
            
    </fieldset>
      
<?php endif; ?>   
    
</div>
<div class="width-40 fltrt">
    <?php echo JHtml::_('sliders.start','poll-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

    <?php echo JHtml::_('sliders.panel',JText::_('JGLOBAL_FIELDSET_PUBLISHING'), 'publishing-details'); ?>

    <fieldset class="panelform">
        <ul class="adminformlist">
            <li><?php echo $this->form->getLabel('created_by'); ?>
            <?php echo $this->form->getInput('created_by'); ?></li>

            <li><?php echo $this->form->getLabel('created'); ?>
            <?php echo $this->form->getInput('created'); ?></li>

            <li><?php echo $this->form->getLabel('publish_up'); ?>
            <?php echo $this->form->getInput('publish_up'); ?></li>

            <li><?php echo $this->form->getLabel('publish_down'); ?>
            <?php echo $this->form->getInput('publish_down'); ?></li>

        </ul>
    </fieldset>

  <?php $fieldSets = $this->form->getFieldsets('params');
        foreach ($fieldSets as $name => $fieldSet) :
            echo JHtml::_('sliders.panel',JText::_($fieldSet->label), $name);
                if (isset($fieldSet->description) && trim($fieldSet->description)) :
                    echo '<p class="tip">'.$this->escape(JText::_($fieldSet->description)).'</p>';
                endif;
                ?>
            <fieldset class="panelform">
                <?php foreach ($this->form->getFieldset($name) as $field) : ?>
                    <?php echo $field->label; ?>
                    <?php echo $field->input; ?>
                <?php endforeach; ?>
            </fieldset>
            
        <?php endforeach; ?>
        <?php echo JHtml::_('sliders.end'); ?>
    </div>

    <div class="clr"></div>
   
    <input type="hidden" name="task" value="" />
    <input type="hidden" id="ids_to_delete" name="ids_to_delete" value="" />
    <input type="hidden" name="reset_votes" id="reset" value="0" />
    <?php echo JHtml::_('form.token'); ?>

</form>