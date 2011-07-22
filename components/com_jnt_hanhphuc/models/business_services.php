<?php
/**
 * @version		$Id: category.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * @package		Joomla.Site
 * @subpackage	com_contact
 */
class Jnt_HanhPhucModelBusiness_Services extends JModelList {

	/**
	 * Constructor.
	 * @param	array	An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 * @since	1.6
	 */
	protected function getListQuery() {
        $user = JFactory::getUser();
        $query = "SELECT s.*, c.id as cat_id, c.title as cat_title FROM #__hp_business_service s JOIN #__categories c ON s.category = c.id
                           WHERE c.published = 1 AND s.state = 1 AND s.business_id = '{$user->id}'";
        return $query;
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null) {
		parent::populateState($ordering, $direction);
	}
}
