<?php

defined('_JEXEC') or die( 'Restricted access' );

class JHtmlPolls
{
    /**
    * Method to create a dropdown list of polls
    * used in both front and back end
    * @param The polls
    * @param The id of the selected poll
    * 
    */
    function dropdown($polls, $poll_id) 
    {
        $view  = JRequest::getWord('view');
        
        // Make the URLs for the dropdown
        foreach ($polls as $k => $poll) {
        
            // if we are requesting a dropdown from the front-end we'll use JRoute::_()
            $polls[$k]->url = ($view == "votes") ?  'index.php?option=com_apoll&view=votes&id='.$poll->id : JRoute::_('index.php?option=com_apoll&view=poll&id='.$poll->slug);
            
            // set the value of the option that will be selected
            if(!$poll_id) {
                $selected = "";
            } else if ($poll->id==$poll_id) {
                $selected = ($view == "votes") ? $polls[$k]->url : JRoute::_($polls[$k]->url);
            }
        }
        
        // Put the text at the begining of the array
        array_unshift($polls, JHtml::_('select.option',  '', JText::_('Select_Poll_From_The_List'), 'url', 'title' ));

        // TODO add ItemId to URL
        
        // Generate the selectbox
        $dropdown = JHtml::_('select.genericlist', 
            $polls, 
            'select_poll', 
            'class="inputbox apoll_dropdown" size="1" style="width:400px; float:right; margin:0 5px;" onchange="if (this.options[selectedIndex].value != \'\') {document.location.href=this.options[selectedIndex].value}"',
             'url', 'title',
             $selected);
            
        return $dropdown;
    }    
    
    
    
}
