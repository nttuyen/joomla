<?php
/**
 * @version		$Id: profile.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;
jimport('joomla.utilities.date');

/**
 * An example custom profile plugin.
 *
 * @package		Joomla.Plugin
 * @subpackage	User.profile
 * @version		1.6
 */
class plgUserProfile extends JPlugin
{
	/**
	 * @param	string	$context	The context for the data
	 * @param	int		$data		The user id
	 * @param	object
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	function onContentPrepareData($context, $data)
	{
		// Check we are manipulating a valid form.
		if (!in_array($context, array('com_users.profile','com_users.user', 'com_users.registration', 'com_admin.profile'))) {
			return true;
		}

		if (is_object($data))
		{
			$userId = isset($data->id) ? $data->id : 0;

			// Load the profile data from the database.
			$db = JFactory::getDbo();
			$db->setQuery(
				'SELECT profile_key, profile_value FROM #__user_profiles' .
				' WHERE user_id = '.(int) $userId." AND profile_key LIKE 'profile.%'" .
				' ORDER BY ordering'
			);
			$results = $db->loadRowList();

			// Check for a database error.
			if ($db->getErrorNum())
			{
				$this->_subject->setError($db->getErrorMsg());
				return false;
			}

			// Merge the profile data.
			$data->profile = array();

			foreach ($results as $v)
			{
				$k = str_replace('profile.', '', $v[0]);
				$data->profile[$k] = $v[1];
			}
			if (!JHtml::isRegistered('users.url')) {
				JHtml::register('users.url', array(__CLASS__, 'url'));
			}
			if (!JHtml::isRegistered('users.calendar')) {
				JHtml::register('users.calendar', array(__CLASS__, 'calendar'));
			}
			if (!JHtml::isRegistered('users.tos')) {
				JHtml::register('users.tos', array(__CLASS__, 'tos'));
			}
		}

		return true;
	}

	public static function url($value)
	{
		if (empty($value))
		{
			return JHtml::_('users.value', $value);
		}
		else
		{
			$value = htmlspecialchars($value);
			if(substr ($value, 0, 4) == "http") {
				return '<a href="'.$value.'">'.$value.'</a>';
			}
			else {
				return '<a href="http://'.$value.'">'.$value.'</a>';
			}
		}
	}

	public static function calendar($value)
	{
		if (empty($value)) {
			return JHtml::_('users.value', $value);
		} else {
			return JHtml::_('date', $value);
		}
	}

	public static function tos($value)
	{
		if ($value) {
			return JText::_('JYES');
		}
		else {
			return JText::_('JNO');
		}
	}

	/**
	 * @param	JForm	$form	The form to be altered.
	 * @param	array	$data	The associated data for the form.
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	function onContentPrepareForm($form, $data)
	{
		// Load user_profile plugin language
		$lang = JFactory::getLanguage();
		$lang->load('plg_user_profile', JPATH_ADMINISTRATOR);

		if (!($form instanceof JForm))
		{
			$this->_subject->setError('JERROR_NOT_A_FORM');
			return false;
		}

		// Check we are manipulating a valid form.
		if (!in_array($form->getName(), array('com_admin.profile','com_users.user', 'com_users.registration','com_users.profile'))) {
			return true;
		}

		// Add the registration fields to the form.
		JForm::addFormPath(dirname(__FILE__).'/profiles');
		$form->loadFile('profile', false);

		// Toggle whether the address1 field is required.
		if ($this->params->get('register-require_address1', 1) > 0) {
			$form->setFieldAttribute('address1', 'required', $this->params->get('register-require_address1') == 2, 'profile');
		}
		else {
			$form->removeField('address1', 'profile');
		}

		// Toggle whether the address2 field is required.
		if ($this->params->get('register-require_address2', 1) > 0) {
			$form->setFieldAttribute('address2', 'required', $this->params->get('register-require_address2') == 2, 'profile');
		}
		else {
			$form->removeField('address2', 'profile');
		}

		// Toggle whether the city field is required.
		if ($this->params->get('register-require_city', 1) > 0) {
			$form->setFieldAttribute('city', 'required', $this->params->get('register-require_city') == 2, 'profile');
		}
		else {
			$form->removeField('city', 'profile');
		}

		// Toggle whether the region field is required.
		if ($this->params->get('register-require_region', 1) > 0) {
			$form->setFieldAttribute('region', 'required', $this->params->get('register-require_region') == 2, 'profile');
		}
		else {
			$form->removeField('region', 'profile');
		}

		// Toggle whether the country field is required.
		if ($this->params->get('register-require_country', 1) > 0) {
			$form->setFieldAttribute('country', 'required', $this->params->get('register-require_country') == 2, 'profile');
		}
		else {
			$form->removeField('country', 'profile');
		}

		// Toggle whether the postal code field is required.
		if ($this->params->get('register-require_postal_code', 1) > 0) {
			$form->setFieldAttribute('postal_code', 'required', $this->params->get('register-require_postal_code') == 2, 'profile');
		}
		else {
			$form->removeField('postal_code', 'profile');
		}

		// Toggle whether the phone field is required.
		if ($this->params->get('register-require_phone', 1) > 0) {
			$form->setFieldAttribute('phone', 'required', $this->params->get('register-require_phone') == 2, 'profile');
		}
		else {
			$form->removeField('phone', 'profile');
		}

		// Toggle whether the website field is required.
		if ($this->params->get('register-require_website', 1) > 0) {
			$form->setFieldAttribute('website', 'required', $this->params->get('register-require_website') == 2, 'profile');
		}
		else {
			$form->removeField('website', 'profile');
		}

		// Toggle whether the favoritebook field is required.
		if ($this->params->get('register-require_favoritebook', 1) > 0) {
			$form->setFieldAttribute('favoritebook', 'required', $this->params->get('register-require_favoritebook') == 2, 'profile');
		}
		else {
			$form->removeField('favoritebook', 'profile');
		}

		// Toggle whether the aboutme field is required.
		if ($this->params->get('register-require_aboutme', 1) > 0) {
			$form->setFieldAttribute('aboutme', 'required', $this->params->get('register-require_aboutme') == 2, 'profile');
		}
		else {
			$form->removeField('aboutme', 'profile');
		}

		// Toggle whether the tos field is required.
		if ($this->params->get('register-require_tos', 1) > 0) {
			$form->setFieldAttribute('tos', 'required', $this->params->get('register-require_tos') == 2, 'profile');
		}
		else {
			$form->removeField('tos', 'profile');
		}

		// Toggle whether the dob field is required.
		if ($this->params->get('register-require_dob', 1) > 0) {
			$form->setFieldAttribute('dob', 'required', $this->params->get('register-require_dob') == 2, 'profile');
		}
		else {
			$form->removeField('dob', 'profile');
		}

        
        //Bussiness info
        if ($this->params->get('register-require_business_director', 1) > 0) {
			$form->setFieldAttribute('business_director', 'required', $this->params->get('register-require_business_director') == 2, 'profile');
		}
		else {
			$form->removeField('business_director', 'profile');
		}
        
        if ($this->params->get('register-require_business_name', 1) > 0) {
			$form->setFieldAttribute('business_name', 'required', $this->params->get('register-require_business_name') == 2, 'profile');
		}
		else {
			$form->removeField('business_name', 'profile');
		}
        
        if ($this->params->get('register-require_business_address', 1) > 0) {
			$form->setFieldAttribute('business_address', 'required', $this->params->get('register-require_business_address') == 2, 'profile');
		}
		else {
			$form->removeField('business_address', 'profile');
		}
        
        if ($this->params->get('register-require_business_city', 1) > 0) {
			$form->setFieldAttribute('business_city', 'required', $this->params->get('register-require_business_city') == 2, 'profile');
		}
		else {
			$form->removeField('business_city', 'profile');
		}
        
        if ($this->params->get('register-require_business_district', 1) > 0) {
			$form->setFieldAttribute('business_district', 'required', $this->params->get('register-require_business_district') == 2, 'profile');
		}
		else {
			$form->removeField('business_district', 'profile');
		}
        
        if ($this->params->get('register-require_business_village', 1) > 0) {
			$form->setFieldAttribute('business_village', 'required', $this->params->get('register-require_business_village') == 2, 'profile');
		}
		else {
			$form->removeField('business_village', 'profile');
		}
        
        if ($this->params->get('register-require_business_phone', 1) > 0) {
			$form->setFieldAttribute('business_phone', 'required', $this->params->get('register-require_business_phone') == 2, 'profile');
		}
		else {
			$form->removeField('business_phone', 'profile');
		}
        
        if ($this->params->get('register-require_business_fax', 1) > 0) {
			$form->setFieldAttribute('business_fax', 'required', $this->params->get('register-require_business_fax') == 2, 'profile');
		}
		else {
			$form->removeField('business_fax', 'profile');
		}
        
        if ($this->params->get('register-require_business_website', 1) > 0) {
			$form->setFieldAttribute('business_website', 'required', $this->params->get('register-require_business_website') == 2, 'profile');
		}
		else {
			$form->removeField('business_website', 'profile');
		}
        
        if ($this->params->get('register-require_business_logo', 1) > 0) {
			$form->setFieldAttribute('business_logo', 'required', $this->params->get('register-require_business_logo') == 2, 'profile');
		}
		else {
			$form->removeField('business_logo', 'profile');
		}
        
        if ($this->params->get('register-require_business_sitename', 1) > 0) {
			$form->setFieldAttribute('business_sitename', 'required', $this->params->get('register-require_business_sitename') == 2, 'profile');
		}
		else {
			$form->removeField('business_sitename', 'profile');
		}
        
        if ($this->params->get('register-require_business_slogan', 1) > 0) {
			$form->setFieldAttribute('business_slogan', 'required', $this->params->get('register-require_business_slogan') == 2, 'profile');
		}
		else {
			$form->removeField('business_slogan', 'profile');
		}
        
        if ($this->params->get('register-require_business_banner', 1) > 0) {
			$form->setFieldAttribute('business_banner', 'required', $this->params->get('register-require_business_banner') == 2, 'profile');
		}
		else {
			$form->removeField('business_slogan', 'banner');
		}
        
		return true;
	}

	function onUserAfterSave($data, $isNew, $result, $error)
	{
		$userId	= JArrayHelper::getValue($data, 'id', 0, 'int');
        
		if ($userId && $result && isset($data['profile']) && (count($data['profile'])))
		{
			try
			{
				//Sanitize the date
				if (!empty($data['profile']['dob'])) {
					$date = new JDate($data['profile']['dob']);
					$data['profile']['dob'] = $date->toFormat('%Y-%m-%d');
				}
                
                //Process file
                jimport('joomla.filesystem.file');
                jimport('joomla.filesystem.folder');
                $path = JPATH_ROOT . DS . 'images' . DS . 'users'.DS.$userId;
                @mkdir($path, 0777, true);
                
                //Upload: logo
                $files = JRequest::get('files');
                $fileError = $files['jform']['error']['profile']['business_logo'];
                if($fileError == 0) {
                    $fileName = $files['jform']['name']['profile']['business_logo'];
                    
                    $uploadedFileNameParts = explode('.',$fileName);
                    $uploadedFileExtension = array_pop($uploadedFileNameParts);
                    $validFileExts = explode(',', 'jpeg,jpg,png,gif');
                    
                    $extOk = false;
                    //go through every ok extension, if the ok extension matches the file extension (case insensitive)
                    //then the file extension is ok
                    foreach($validFileExts as $key => $value) {
                        if( preg_match("/$value/i", $uploadedFileExtension ) ) {
                            $extOk = true;
                        }
                    }
                    if ($extOk){
                        $fileTemp = $files['jform']['tmp_name']['profile']['business_logo'];
                        if(JFile::upload($fileTemp, $path . DS . $fileName)) {
                            $data['profile']['business_logo'] = $fileName;
                        }
                    }
                }
                
                //Upload: banner
                $fileError = $files['jform']['error']['profile']['business_banner'];
                if($fileError == 0) {
                    $fileName = $files['jform']['name']['profile']['business_banner'];
                    
                    $uploadedFileNameParts = explode('.',$fileName);
                    $uploadedFileExtension = array_pop($uploadedFileNameParts);
                    $validFileExts = explode(',', 'jpeg,jpg,png,gif');
                    
                    $extOk = false;
                    //go through every ok extension, if the ok extension matches the file extension (case insensitive)
                    //then the file extension is ok
                    foreach($validFileExts as $key => $value) {
                        if( preg_match("/$value/i", $uploadedFileExtension ) ) {
                            $extOk = true;
                        }
                    }
                    if ($extOk){
                        $fileTemp = $files['jform']['tmp_name']['profile']['business_banner'];
                        if(JFile::upload($fileTemp, $path . DS . $fileName)) {
                            $data['profile']['business_banner'] = $fileName;
                        }
                    }
                }

                
				$db = JFactory::getDbo();
				$db->setQuery(
					'DELETE FROM #__user_profiles WHERE user_id = '.$userId .
					" AND profile_key LIKE 'profile.%'"
				);

				if (!$db->query()) {
					throw new Exception($db->getErrorMsg());
				}

				$tuples = array();
				$order	= 1;

				foreach ($data['profile'] as $k => $v)
				{
					$tuples[] = '('.$userId.', '.$db->quote('profile.'.$k).', '.$db->quote($v).', '.$order++.')';
				}

				$db->setQuery('INSERT INTO #__user_profiles VALUES '.implode(', ', $tuples));

				if (!$db->query()) {
					throw new Exception($db->getErrorMsg());
				}

			}
			catch (JException $e)
			{
				$this->_subject->setError($e->getMessage());
				return false;
			}
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
	function onUserAfterDelete($user, $success, $msg)
	{
		if (!$success) {
			return false;
		}

		$userId	= JArrayHelper::getValue($user, 'id', 0, 'int');

		if ($userId)
		{
			try
			{
				$db = JFactory::getDbo();
				$db->setQuery(
					'DELETE FROM #__user_profiles WHERE user_id = '.$userId .
					" AND profile_key LIKE 'profile.%'"
				);

				if (!$db->query()) {
					throw new Exception($db->getErrorMsg());
				}
			}
			catch (JException $e)
			{
				$this->_subject->setError($e->getMessage());
				return false;
			}
		}

		return true;
	}
}
