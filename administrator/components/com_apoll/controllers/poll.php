<?php
/**
 * aPoll voting component
 *
 * @version     $Id: poll.php 129 2010-10-22 16:08:28Z harrygg $
 * @package     aPoll
 * @copyright   Copyright (C) 2009 - 2010 aFactory. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controllerform');

/**
 * aPoll controller class.
 *
 * @package         Joomla.Administrator
 * @subpackage      aPoll
 * @since           1.6
 */
class ApollControllerPoll extends JControllerForm
{
    /**
    * put your comment there...
    * 
    * @param mixed $config
    * @return ApollControllerPoll
    */   
    function __construct ( $config = array() )
    {
        //$config['name'] = 'apoll';
        parent::__construct($config);
        jimport('joomla.form.formvalidator');
        //JFormValidator::addRulePath(JPATH_COMPONENT . DS . 'models' . DS . 'rules');
    }

	/**
	 * Method override to check if you can add a new record.
	 *
	 * @param	array	An array of input data.
	 *
	 * @return	boolean
	 */
	protected function _allowAdd($data = array())
	{
		// Initialise variables.
		$user		= JFactory::getUser();
		$categoryId	= JArrayHelper::getValue($data, 'catid', JRequest::getInt('filter_category_id'), 'int');
		$allow		= null;

		if ($categoryId)
		{
			// If the category has been passed in the URL check it.
			$allow	= $user->authorise('core.create', 'com_apoll.category.'.$categoryId);
		}
		if ($allow === null)
		{
			// In the absense of better information, revert to the component permissions.
			return parent::_allowAdd($data);
		}
		else {
			return $allow;
		}
	}

	/**
	 * Method to check if you can add a new record.
	 *
	 * @param	array	An array of input data.
	 * @param	string	The name of the key for the primary key.
	 *
	 * @return	boolean
	 */
	protected function _allowEdit($data = array(), $key = 'id')
	{
		// Initialise variables.
		$categoryId	= (int) isset($data['catid']) ? $data['catid'] : 0;
		$user		= JFactory::getUser();
		if ($categoryId)
		{
			// The category has been set. Check the category permissions.
			return $user->authorise('core.edit', 'com_apoll.category.'.$categoryId);
		}
		else
		{
			// Since there is no asset tracking, revert to the component permissions.
			return parent::_allowEdit($data, $key);
		}
	}

    /**
     * Method to get a model object, loading it if required.
     *
     * @param    string    The model name. Optional.
     * @param    string    The class prefix. Optional.
     * @param    array    Configuration array for model. Optional.
     *
     * @return    object    The model.
     */
    public function getModel($name = 'Poll', $prefix = 'ApollModel', $config = array())
    {
        return parent::getModel($name, $prefix, $config);
    }    
    
}