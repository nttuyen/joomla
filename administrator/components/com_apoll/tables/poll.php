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

/**
* @package	Joomla
* @subpackage	aPoll
*/
class ApollTablePoll extends JTable
{

	/**
	 * Constructor
	 *
	 * @param JDatabase A database connector object
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__apoll_polls', 'id', $db);
	}

	/**
	 * Binds an array to the object
	 * @param 	array	Named array
	 * @param 	string	Space separated list of fields not to bind
	 * @return	boolean
	 */
	function bind($array, $ignore = '')
	{
		if (key_exists( 'params', $array ) && is_array( $array['params'] ))
		{
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = (string)$registry;
		}
		return parent::bind($array, $ignore);
	}
	
	/**
	 * Overload the store method for the Polls table.
	 *
	 * @param	boolean		$updateNulls	Toggle whether null values should be updated.
	 * @return	boolean		True on success, false on failure.
	 * @since	1.6
	 */
	public function store($updateNulls = false)
	{
		$date	= JFactory::getDate();
		$user	= JFactory::getUser();
		if ($this->id) {
			// Existing item
			$this->modified		= $date->toMySQL();
			$this->modified_by	= $user->get('id');
			} else {
			// New poll. A poll created and created_by field can be set by the user,
			// so we don't touch either of these if they are set.
			if (!intval($this->created)) {
				$this->created = $date->toMySQL();
			}
			if (empty($this->created_by)) {
				$this->created_by = $user->get('id');
			}
		}
			$date	= JFactory::getDate();
			$user	= JFactory::getUser();
			if ($this->id) {
				// Existing item
				$this->modified		= $date->toMySQL();
				$this->modified_by	= $user->get('id');
				} else {
				// New poll. A poll created and created_by field can be set by the user,
				// so we don't touch either of these if they are set.
				if (!intval($this->created)) {
					$this->created = $date->toMySQL();
				}
				if (empty($this->created_by)) {
					$this->created_by = $user->get('id');
				}
				
			}
			
			// Verify that the alias is unique
			$table = JTable::getInstance('Poll', 'ApollTable');
			if ($table->load(array('alias'=>$this->alias,'catid'=>$this->catid)) && ($table->id != $this->id || $this->id==0)) {
				$this->setError(JText::_('COM_APOLL_ERROR_UNIQUE_ALIAS'));
				return false;
			}
		// Attempt to store the user data.
		return parent::store($updateNulls);
/*
	// Transform the params field
		if (is_array($this->params))
		{
			$registry = new JRegistry();
			$registry->loadArray($this->params);
			$this->params = (string)$registry;
		}*/
	}

	/**
	 * Overloaded check method to ensure data integrity.
	 *
	 * @return	boolean	True on success.
	 */
	public function check()
	{

		// check for valid name
		if (trim($this->title) == '') {
			$this->setError(JText::_('COM_APOLL_ERR_TABLES_TITLE'));
			return false;
		}

		if (empty($this->alias)) {
			$this->alias = $this->title;
		}
		
		$this->alias = JApplication::stringURLSafe($this->alias);
		if (trim(str_replace('-','',$this->alias)) == '') {
			$this->alias = JFactory::getDate()->format("Y-m-d-H-i-s");
		}

		// Check the publish down date is not earlier than publish up.
		if (intval($this->publish_down) > 0 && $this->publish_down < $this->publish_up) {
			// Swap the dates.
			$temp = $this->publish_up;
			$this->publish_up = $this->publish_down;
			$this->publish_down = $temp;
		}

                // check for correct publish date
                if (intval($this->publish_down) > 0 && $this->publish_down < $this->publish_up) {
                    $this->setError(JText::_('COM_APOLL_ERR_TABLES_DATES'));
                    return false;
                }
            return true;
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table.  The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param	mixed	An optional array of primary key values to update.  If not
	 *					set the instance property value is used.
	 * @param	integer The publishing state. eg. [0 = unpublished, 1 = published]
	 * @param	integer The user id of the user performing the operation.
	 * @return	boolean	True on success.
	 * @since	1.0.4
	 */
	public function publish($pks = null, $state = 1, $userId = 0)
	{
            //TODO
            //return parent::publish($pks, $state, $userId);

                // Initialise variables.
		$k = $this->_tbl_key;

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$userId = (int) $userId;
		$state  = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k) {
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else {
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
				return false;
			}
		}

		// Build the WHERE clause for the primary keys.
		$where = $k.'='.implode(' OR '.$k.'=', $pks);

		// Determine if there is checkin support for the table.
		if (!property_exists($this, 'checked_out') || !property_exists($this, 'checked_out_time')) {
			$checkin = '';
		}
		else {
			$checkin = ' AND (checked_out = 0 OR checked_out = '.(int) $userId.')';
		}

		// Update the publishing state for rows with the given primary keys.
		$this->_db->setQuery(
			'UPDATE `'.$this->_tbl.'`' .
			' SET `state` = '.(int) $state .
			' WHERE ('.$where.')' .
			$checkin
		);
		$this->_db->query();

		// Check for a database error.
		if ($this->_db->getErrorNum()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// If checkin is supported and all rows were adjusted, check them in.
		if ($checkin && (count($pks) == $this->_db->getAffectedRows()))
		{
			// Checkin the rows.
			foreach($pks as $pk)
			{
				$this->checkin($pk);
			}
		}

		// If the JTable instance value is in the list of primary keys that were set, set the instance.
		if (in_array($this->$k, $pks)) {
			$this->state = $state;
		}

		$this->setError('');
		return true;
                 
	}	



}
