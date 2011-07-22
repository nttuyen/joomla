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

jimport('joomla.application.component.controller');

/**
 * Polls list controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_apoll
 * @since		1.6
 */
class ApollControllerPolls extends JController
{
	/**
	 * Constructor.
	 *
	 * @param	array An optional associative array of configuration settings.
	 * @see		JController
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		$this->registerTask('unpublish',	'publish');
		$this->registerTask('archive',		'publish');
                $this->registerTask('trash',            'publish');
		$this->registerTask('orderup',		'reorder');
		$this->registerTask('orderdown',	'reorder');
	}

	/**
	 * Display is not supported by this class.
	 */
	public function display()
	{
	}

	/**
	 * Proxy for getModel.
	 */
	public function &getModel($name = 'Poll', $prefix = 'ApollModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

	/**
	 * Method to remove a record.
	 */
	public function delete()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));

		// Initialise variables.
		$user	= JFactory::getUser();
		$ids	= JRequest::getVar('cid', array(), '', 'array');

		if (empty($ids)) {
			JError::raiseWarning(500, JText::_('JError_No_items_selected'));
		}
		else {
			// Get the model.
			$model = $this->getModel();

			// Remove the items.
			if (!$model->delete($ids)) {
				JError::raiseWarning(500, $model->getError());
			}
			else {
				$this->setMessage(JText::sprintf('JController_N_Items_deleted', count($ids)));
			}
		}

		$this->setRedirect('index.php?option=com_apoll&view=polls');
	}

	/**
	 * Method to change the state of a list of records.
	 */
	public function publish()
	{

		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));

		// Initialise variables.
		$user	= JFactory::getUser();
		$ids	= JRequest::getVar('cid', array(), '', 'array');
		$values	= array('publish' => 1, 'unpublish' => 0, 'archive' => -1, 'trash' => -2);
		$task	= $this->getTask();
		$value	= JArrayHelper::getValue($values, $task, 0, 'int');

		if (empty($ids)) {
			JError::raiseWarning(500, JText::_('JError_No_items_selected'));
		}
		else
		{
			// Get the model.
			$model	= $this->getModel();

			// Change the state of the records.
			if (!$model->publish($ids, $value)) {
				JError::raiseWarning(500, $model->getError());
			}
			else
			{
				if ($value == 1) {
					$text = 'JSuccess_N_Items_published';
				}
				else if ($value == 0) {
					$text = 'JSuccess_N_Items_unpublished';
				}
				else if ($value == -1) {
					$text = 'JSuccess_N_Items_archived';
				}
				else {
					$text = 'JSuccess_N_Items_trashed';
				}
				$this->setMessage(JText::sprintf($text, count($ids)));
			}
		}

        $this->setRedirect('index.php?option=com_apoll&view=polls');
	}

	/**
	 * Changes the order of one or more records.
	 */
	public function reorder()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));

		// Initialise variables.
		$user	= JFactory::getUser();
		$ids	= JRequest::getVar('cid', null, 'post', 'array');
		$inc	= ($this->getTask() == 'orderup') ? -1 : +1;

		$model = $this->getModel();
        foreach($ids as $id)
        {
            $model->reorder($id, $inc);
        }
		// TODO: Add error checks.

        $this->setRedirect('index.php?option=com_apoll&view=polls');
	}

    /**
     * Method to save the submitted ordering values for records.
     *
     * @return    void
     */
    public function saveorder()
    {
        // Check for request forgeries.
        JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));

        // Get the input
        $pks    = JRequest::getVar('cid',    null,    'post',    'array');
        $order    = JRequest::getVar('order',    null,    'post',    'array');

        // Sanitize the input
        JArrayHelper::toInteger($pks);
        JArrayHelper::toInteger($order);

        // Get the model
        $model = &$this->getModel();

        // Save the ordering
        $model->saveorder($pks, $order);

        $this->setMessage(JText::_('JSuccess_Ordering_saved'));
        $this->setRedirect('index.php?option=com_apoll&view=polls');
    }
}