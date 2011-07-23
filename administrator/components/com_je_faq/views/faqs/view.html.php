<?php
/**
 * @version		$Id: view.html.php 18586 2010-08-22 20:11:14Z ian $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of faqs.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_faqs
 * @since		1.6
 */
class je_faqViewFaqs extends JView
{
	protected $categories;
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialise variables.
		$this->categories	= $this->get('CategoryOrders');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/je_faq.php';

		$canDo	= je_faqHelper::getActions($this->state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('Faqs Manager'), 'banners.png');
		
		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew('faq.add','JTOOLBAR_NEW');
		}
		
		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('faq.edit','JTOOLBAR_EDIT');
		}
		
		if ($canDo->get('core.edit.state')) {
			if ($this->state->get('filter.state') != 2){
				JToolBarHelper::divider();
				JToolBarHelper::custom('faqs.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('faqs.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			}
			if ($this->state->get('filter.state') != -1 ) {
				JToolBarHelper::divider();
				if ($this->state->get('filter.state') != 2) {
					JToolBarHelper::archiveList('faqs.archive','JTOOLBAR_ARCHIVE');
				}
				else if ($this->state->get('filter.state') == 2) {
					JToolBarHelper::unarchiveList('faqs.publish', 'JTOOLBAR_UNARCHIVE');
				}
			}
		}
		
		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::custom('faqs.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
		}
		
		if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'faqs.delete','JTOOLBAR_EMPTY_TRASH');
		} else if ($canDo->get('core.edit.state')) {
			JToolBarHelper::trash('faqs.trash','JTOOLBAR_TRASH');
		}
		
	}
}
