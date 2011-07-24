<?php
/**
 * @version		$Id: banner.php 21148 2011-04-14 17:30:08Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modelform');

/**
 * Business promotion model.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.6
 */
class Jnt_HanhPhucModelBusiness_Promotion extends JModelForm {
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_JNT_HANHPHUC_BUSINESS_PROMOTION';

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Promotion', $prefix = 'Jnt_HanhPhucTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_jnt_hanhphuc.promotion', 'promotion', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		if(!$form->getValue('business_id')) {
			$user = JFactory::getUser();
			$form->setValue('business_id', null, $user->id);
		}
		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_jnt_hanhphuc.edit.business_promotion.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}
		//JFactory::getApplication()->setUserState('com_jnt_hanhphuc.edit.business_promotion.data', array());

		return $data;
	}
	
	public function getItem($id = 0) {
		if(!$id) $id = JRequest::getInt('id', 0);
		
		$db = JFactory::getDbo();
		$query = 'SELECT * FROM #__hp_business_promotion WHERE id = '.$id;
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	public function save($data) {
		
		$object = new stdClass();
		foreach ($data as $key => $value) {
			$object->$key = $value;
		}
		
		$db = JFactory::getDbo();
		if($object->id == 0) {
			$db->insertObject('#__hp_business_promotion', $object);
			if(!$db->getErrorNum()) {
				return $db->insertid();
			}
			return false;
		} else {
			$db->updateObject('#__hp_business_promotion', $object, 'id');
			if(!$db->getErrorNum()) {
				return $object->id;
			}
			return false;
		}
	}
}
