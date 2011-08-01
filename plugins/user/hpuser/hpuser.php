<?php
/**
 * @version		$Id: example.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

define('JPATH_PLUGIN_HPUSER', dirname(__FILE__));

/**
 * Example User Plugin
 *
 * @package		Joomla.Plugin
 * @subpackage	User.example
 * @since		1.5
 */
class plgUserHpuser extends JPlugin {
	/**
	 * Prepair data for Form (use in getForm in model)
	 * @param	string	$context	The context for the data
	 * @param	int		$data		The user id
	 * @param	object
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	public function onContentPrepareData($context, $data) {
		//TODO #nttuyen prepair user's data for form
		//Check we are manipulating a valid form.
		if (!in_array($context, array('com_users.profile','com_users.user', 'com_users.registration', 'com_admin.profile'))) {
			return true;
		}
		
		$userType = JRequest::getInt('type', 0);
		if (is_object($data)) {
			if(!isset($data->user_type)) {
				$data->user_type = $userType;
			}
		} else {
			if(!isset($data['user_type'])){
				$data['user_type'] = $userType;
			}
		}
		
		return true;
	}
	
	/**
	 * @param	JForm	$form	The form to be altered.
	 * @param	array	$data	The associated data for the form.
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	public function onContentPrepareForm($form, $data) {
		//TODO: #nttuyen Prepair form
		
		$userType = JRequest::getInt('type', 0);
		
		if(is_object($data) && isset($data->user_type)) {
			$userType = $data->user_type;
		}
		
		if (!($form instanceof JForm)) {
			$this->_subject->setError('JERROR_NOT_A_FORM');
			return false;
		}
		JForm::addFormPath(JPATH_PLUGIN_HPUSER.DS.'forms');
		
		$form->loadFile('hpuser', false);
		$form->setValue('user_type', '', $userType);
		
		if($userType == 1) {
			//TODO: #nttuyen business user
			$form->loadFile('business_user', false);
		} else {
			//Normal user
			$form->loadFile('normal_user', false);
		}
		
		return true;
	}
	
	public function onUserAfterSave($data, $isNew, $result, $error) {
		//TODO #nttuyen save user's info after save
		
		$info = array();
		$info['user_id'] = $data['id'];
		foreach ($data as $key => $value) {
			if(substr($key, 0, strlen('business_')) == 'business_') {
				$businessInfo[$key] = $value;
			}
		}
		
		$db = JFactory::getDbo();
		if($isNew) {
			$db->insertObject('#__hp_business_profile', $info);
		} else {
			$db->insertObject('#__hp_business_profile', $info);
		}
		
		return true;
	}
	
	/**
	 * Remove all user profile information for the given user ID
	 *
	 * Method is called after user data is deleted from the database
	 *
	 * @param	array		$user		Holds the user data
	 * @param	boolean		$success	True if user was succesfully stored in the database
	 * @param	string		$msg		Message
	 */
	function onUserAfterDelete($user, $success, $msg) {
		//TODO #nttuyen remove user's info after delete
		return true;
	}
	
	/**
	 * This method should handle any login logic and report back to the subject
	 *
	 * @param	array	$user		Holds the user data.
	 * @param	array	$options	Extra options.
	 *
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	public function onUserLogin($user, $options) {
		//TODO #nttuyen process when user login
		return true;
	}
}
