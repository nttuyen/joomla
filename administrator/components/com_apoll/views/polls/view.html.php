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

class ApollViewPolls extends JView
{
    protected $state;
    protected $items;
    protected $pagination;

    /**
     * Display the view
     */    
    public function display($tpl = null)
    {
        $state        = $this->get('State');
        $items        = $this->get('Items');
        $pagination   = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }

        $this->assignRef('state',        $state);
        $this->assignRef('items',        $items);
        $this->assignRef('pagination',   $pagination);

        $this->_setToolbar();
        parent::display($tpl);
    }

    /**
     * Setup the Toolbar
     */
    protected function _setToolbar()
    {
        require_once JPATH_COMPONENT.DS.'helpers'.DS.'apoll.php';

        $state    = $this->get('State');
        $canDo    = ApollHelper::getActions($state->get('filter.category_id'));

        JToolBarHelper::title(JText::_('COM_APOLL_POLLS_MANAGER'), 'generic.png');
        if ($canDo->get('core.create')) {
            JToolBarHelper::addNew('Poll.add','JTOOLBAR_NEW');
        }
        if ($canDo->get('core.edit')) {
            JToolBarHelper::editList('Poll.edit','JTOOLBAR_EDIT');
        }
        JToolBarHelper::divider();
        
		if ($canDo->get('core.edit.state')) {
            JToolBarHelper::custom('polls.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
            JToolBarHelper::custom('polls.unpublish', 'unpublish.png', 'unpublish_f2.png','JTOOLBAR_UNPUBLISH', true);
            JToolBarHelper::divider();
            JToolBarHelper::divider();
            if ($state->get('filter.published') != -1) {
                JToolBarHelper::archiveList('polls.archive','JTOOLBAR_ARCHIVE');
            }
        }
        if ($state->get('filter.published') == -2 && $canDo->get('core.delete')) {
            JToolBarHelper::deleteList('', 'polls.delete','JTOOLBAR_EMPTY_TRASH');
        }
        else if ($canDo->get('core.edit.state')) {
            JToolBarHelper::trash('polls.trash','JTOOLBAR_TRASH');
        }
		
        if ($canDo->get('core.admin')) {
            JToolBarHelper::divider();
            JToolBarHelper::preferences('com_apoll');
        }
        JToolBarHelper::divider();
        JToolBarHelper::help('screen.poll','JTOOLBAR_HELP');
    }
}