<?php
/**
 * @version		$Id: article.php 20810 2011-02-21 20:01:22Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modelform');

/**
 * Content Component Article Model
 *
 * @package		Joomla.Site
 * @subpackage	com_content
 * @since 1.5
 */
class Jnt_HanhPhucModelIntro extends JModelForm {
    
    protected $data = null;
    
    public function getForm($data = array(), $loadData = true) {
        // Get the form.
		$form = $this->loadForm('com_jnt_hanhphuc.intro', 'intro', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
        
        if(!$form->getValue('business_id')) {
            $form->setValue('business_id', null, JFactory::getUser()->id);
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
		return $this->getData();
	}
    
    public function getData($businessId = 0) {
        if($this->data) {
           return $this->data; 
        }
        
        if(!$businessId) $businessId = JRequest::getInt('bid', 0);
        $db = JFactory::getDbo();
        $query = "SELECT * FROM #__hp_business_info WHERE business_id = '$businessId'";
        $db->setQuery($query);
        $this->data = $db->loadObject();
        
        return $this->data;
    }
    
    public function getBusinessInfo($businessId = 0) {
        if(!$businessId) $businessId = JRequest::getInt('bid', 0);
        
        //Load from tbl user
        $businessInfo = JFactory::getUser($businessId);
        
        //Load profile
        $db = JFactory::getDbo();
        $db->setQuery(
            'SELECT profile_key, profile_value FROM #__user_profiles' .
            ' WHERE user_id = '.(int) $businessId." AND profile_key LIKE 'profile.%'" .
            ' ORDER BY ordering'
        );
        $results = $db->loadRowList();

        // Merge the profile data.
        $profile = new stdClass();

        foreach ($results as $v) {
            $k = str_replace('profile.', '', $v[0]);
            //$data->profile[$k] = $v[1];
            $profile->$k = $v[1];
        }
        $businessInfo->profile = $profile;
        
        return $businessInfo;
    }
    
    public function getTable($name = 'Intro', $prefix = 'Jnt_HanhPhucTable', $options = array()) {
        parent::getTable($name, $prefix, $options);
    }
    
    /**
	 * Method to save the form data.
	 *
	 * @param	array		The form data.
	 * @return	mixed		The user id on success, false on failure.
	 * @since	1.6
	 */
	public function save($data) {
		$user = new JUser($userId);
        
        //make object
        $info = new stdClass();
        foreach($data as $key => $value) {
            $info->$key = $value;
        }
        
        $db = JFactory::getDbo();
        if($info->id == 0) {
            return $db->insertObject('#__hp_business_info', $info);
        } else {
            return $db->updateObject('#__hp_business_info', $info, 'id');
        }
    }
}
