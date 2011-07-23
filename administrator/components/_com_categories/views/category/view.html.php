<?php
/**
 * @version		$Id: view.html.php 19013 2010-09-29 09:20:44Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML View class for the Categories component
 *
 * @static
 * @package		Joomla.Administrator
 * @subpackage	com_categories
 */
class CategoriesViewCategory extends JView
{
	protected $form;
	protected $item;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		parent::display($tpl);
		JRequest::setVar('hidemainmenu', true);
		$this->addToolbar();
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		// Initialise variables.
		$extension	= JRequest::getCmd('extension');
		$user		= JFactory::getUser();

		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));

		// Avoid nonsense situation.
		if ($extension == 'com_categories') {
			return;
		}

 		// The extension can be in the form com_foo.section
		$parts = explode('.',$extension);
		$component = $parts[0];
		$section = (count($parts) > 1) ? $parts[1] : null;

		// Need to load the menu language file as mod_menu hasn't been loaded yet.
		$lang = JFactory::getLanguage();
			$lang->load($component.'.sys', JPATH_BASE, null, false, false)
		||	$lang->load($component.'.sys', JPATH_ADMINISTRATOR.'/components/'.$component, null, false, false)
		||	$lang->load($component.'.sys', JPATH_BASE, $lang->getDefault(), false, false)
		||	$lang->load($component.'.sys', JPATH_ADMINISTRATOR.'/components/'.$component, $lang->getDefault(), false, false);

		// Load the category helper.
		require_once JPATH_COMPONENT.'/helpers/categories.php';

		// Get the results for each action.
		$canDo = CategoriesHelper::getActions($component, $this->item->id);

		// If a component categories title string is present, let's use it.
		if ($lang->hasKey($component_title_key = $component.($section?"_$section":'').'_CATEGORY'.($isNew?'_ADD':'_EDIT').'_TITLE')) {
			$title = JText::_($component_title_key);
		}
		// Else if the component section string exits, let's use it
		elseif ($lang->hasKey($component_section_key = $component.($section?"_$section":''))) {
			$title = JText::sprintf( 'COM_CATEGORIES_CATEGORY'.($isNew?'_ADD':'_EDIT').'_TITLE', $this->escape(JText::_($component_section_key)));
		}
		// Else use the base title
		else {
			$title = JText::_('COM_CATEGORIES_CATEGORY_BASE'.($isNew?'_ADD':'_EDIT').'_TITLE');
		}

		// Load specific css component 
		JHtml::_('stylesheet',$component.'/administrator/categories.css', array(), true);
		
		// Prepare the toolbar.
		JToolBarHelper::title($title, substr($component,4).($section?"-$section":'').'-category'.($isNew?'-add':'-edit').'.png');

		// If a new item, can save the item.
		if ($isNew && $canDo->get('core.create') && !$canDo->get('core.edit')) {
			JToolBarHelper::save('category.save', 'JTOOLBAR_SAVE');
		}

		// If not checked out, can save the item.
		if (!$checkedOut && $canDo->get('core.edit')) {
			JToolBarHelper::apply('category.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('category.save', 'JTOOLBAR_SAVE');
			if ($canDo->get('core.create')){
				JToolBarHelper::custom('category.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
			}
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create')) {
			JToolBarHelper::custom('category.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
		}

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('category.cancel','JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::cancel('category.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_COMPONENTS_'.strtoupper(substr($component,4)).'_CATEGORIES_EDIT');
	}
}
