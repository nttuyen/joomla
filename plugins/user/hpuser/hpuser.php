<?php
/**
 * @version		$Id: example.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

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
	function onContentPrepareData($context, $data) {
		//TODO #nttuyen prepair user's data for form
		return true;
	}
	
	/**
	 * @param	JForm	$form	The form to be altered.
	 * @param	array	$data	The associated data for the form.
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	function onContentPrepareForm($form, $data) {
		//TODO: #nttuyen Prepair form
		return true;
	}
	
	function onUserAfterSave($data, $isNew, $result, $error) {
		//TODO #nttuyen save user's info after save
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
