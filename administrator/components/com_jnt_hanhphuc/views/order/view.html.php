<?php
/**
 * @version		$Id: view.html.php 20196 2011-01-09 02:40:25Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit a banner.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.5
 */
class Jnt_HanhPhucViewOrder extends JView
{
	protected $form;
	protected $item;
	protected $state;
    protected $orderItems;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');
        
        $this->orderItems = $this->get('OrderItems');

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
		JRequest::setVar('hidemainmenu', true);

		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		$canDo		= Jnt_HanhPhucHelper::getActions($this->state->get('filter.category_id'));

		JToolBarHelper::title($isNew ? 'New order' : 'CL Diamond: Order detail', 'banners.png');

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit') || $canDo->get('core.create'))) {
			JToolBarHelper::apply('order.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('order.save', 'JTOOLBAR_SAVE');
		}

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('order.cancel','JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::cancel('order.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_COMPONENTS_BANNERS_BANNERS_EDIT');
	}
}
