<?php
/**
 * aPoll voting component
 *
 * @version     $Id: view.html.php 129 2010-10-22 16:08:28Z harrygg $
 * @package     aPoll
 * @copyright   Copyright (C) 2009 - 2010 aFactory. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');

/**
 * View to edit a poll.
 *
 * @package	Joomla.Administrator
 * @subpackage	com_apoll
 * @since	1.5
 */
class ApollViewPoll extends JView
{

	protected $state;
	protected $item;
	protected $form;
	protected $options;
        protected $total_votes;

        /**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$state		= $this->get('State');
		$item		= $this->get('Item');
		$form		= $this->get('Form');
                $options        = $this->get('Options');
                $total_votes    = $this->get('Votes');

                // Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// Bind the record to the form.
		//$form->bind($item);

		$this->assignRef('state',   $state);
		$this->assignRef('item',    $item);
		$this->assignRef('form',    $form);
                $this->assignRef('options', $options);
                $this->assignRef('total_votes', $total_votes);
		//$this->assignRef('script',  $script);

		$this->addToolbar();

                // Set the document
                $this->setDocument();

                parent::display($tpl);

	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
            JRequest::setVar('hidemainmenu', true);

            $user	= JFactory::getUser();
            $isNew	= ($this->item->id == 0);
            $checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
            $canDo	= ApollHelper::getActions($this->state->get('filter.category_id'), $this->item->id);


            //JToolBarHelper::title(JText::_('COM_WEBLINKS_MANAGER_WEBLINK'), 'weblinks.png');
            JToolBarHelper::title(JText::_(($isNew ? JText::_('JACTION_CREATE') : JText::_('JACTION_EDIT')). ": " . $this->item->title));

            // If not checked out, can save the item.
            if (!$checkedOut && ($canDo->get('core.edit')||($canDo->get('core.create'))))
            {
                JToolBarHelper::apply('poll.apply', 'JTOOLBAR_APPLY');
                JToolBarHelper::save('poll.save', 'JTOOLBAR_SAVE');
            }

            if (!$checkedOut && ($canDo->get('core.create'))){
                JToolBarHelper::custom('poll.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
            }

            // If an existing item, can save to a copy.
            //if (!$isNew && $canDo->get('core.create')) {
            //        JToolBarHelper::custom('poll.save2copy', 'copy.png', 'copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
            //}

            if (empty($this->item->id))  {
                    JToolBarHelper::cancel('poll.cancel', 'JTOOLBAR_CANCEL');
            }
            else {
                    JToolBarHelper::cancel('poll.cancel', 'JTOOLBAR_CLOSE');
            }

            JToolBarHelper::divider();
            JToolBarHelper::help('screen.poll.edit','JTOOLBAR_HELP');
        }

    /**
     * Method to set up the document properties
     *
     * @return void
     */
    protected function setDocument() 
    {
        $isNew        = ($this->form->getValue('id') < 1);
        $document     = &JFactory::getDocument();
        $document->setTitle(JText::_('aPoll Administraion') . ' - ' . ($isNew ? JText::_('Create') : JText::_('Edit')));

        $document->addScript('components/com_apoll/assets/mooRainbow.1.2b2.js');
        $document->addStyleSheet('components/com_apoll/assets/colorpicker.css'); 

        //$document->addScript($this->script);
        $document->addScript('components/com_apoll/views/poll/submitbutton.js');
        JText::script('com_apoll_Poll_Error_Some_Values_Are_Unacceptable');
        JText::script('com_apoll_Poll_Error_Correct_Publish_Dates');
        JText::script('com_apoll_Poll_Error_Correct_Title');

        

$javascript = "
window.addEvent('domready', function() { 
        
    //reset/undo button logic
    
    var reset_Btn = $('reset_votes_Btn');
    
    // check if the button exists so we dont generate js errors 
    
    if (reset_Btn) {    
    reset_Btn.addEvent('click', function(e) {
        
        // toggle between displaying votes and zeroes
        
        $$('.reset').each(function(v){

            switch(v.getStyle('display')) {              
                case 'none' :
                  v.setStyle('display', '');
                break;
                default :
                  v.setStyle('display', 'none');
                break;  
            }
        });
        
        // show/hide the undo button
        
        if ($('reset_votes_Btn').hasClass('undo')) {
            $('reset_votes_Btn').toggleClass('undo');
            $('reset_votes_Btn').set('value', '".JText::_('COM_APOLL_RESET_VOTES')."');
            //change the flag
            $('reset').set('value', '0'); 
        } else {
            $('reset_votes_Btn').toggleClass('undo');
            $('reset_votes_Btn').set('value', 'Undo');   
            //change the flag
            $('reset').set('value', '1');         
        } 
    }); 
    }     
});
";      

$css = "
#add_option_Btn {
    background:url(components/com_apoll/assets/apoll-add.png) 0 2px no-repeat ;
    padding:2px; padding-left:14px;
}

.apoll_option_labels {
    margin:0;
    padding:5px;
    float:none;
    width:95% !important;
    height:30px;
    display:block;
}

span.handle {
    display:block;
    width:40px;
    padding:5px;
    float:left;
    font-weight:bold;
    text-align:right;
    cursor:move;
    background:url(components/com_apoll/assets/apoll_drag.png) 3px 3px no-repeat;
}
input.delete_me {
    border:none;
    background:url(components/com_apoll/assets/apoll_delete.png) top center no-repeat;
    width:30px;
    height:30px;
    cursor:pointer;
    padding:2px 10px;
    margin-left:20px;
}

span.reset {

    padding:3px; 
    float:right;
}

input.ordering {
    width:10px;
}

input.poll_options {
    z-index:1;
}
"; 
        // add the javascript for options - reorder, color, add, remove
        JText::script('COM_APOLL_CLICK_TO_DELETE', 'Delete');
        JText::script('COM_APOLL_CANT_DELETE_LESS_THAN_2_OPTIONS', 'Cannot delete less than 2 options');
        JText::script('COM_APOLL_ARE_YOU_SURE_YOU_WANT_TO_DELETE', 'Are you sure you want to delete this options');
        $document->addScript('components/com_apoll/assets/options.js');
        
        $document->addStyleDeclaration($css);

        if (!$isNew) {
            $document->addScriptDeclaration($javascript);
        }
    } 
}
