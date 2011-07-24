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
class Jnt_HanhPhucModelBusiness_Service extends JModelForm {
	protected $data = null;
	
	public function getForm($data = array(), $loadData = true) {
        // Get the form.
		$form = $this->loadForm('com_jnt_hanhphuc.service', 'service', array('control' => 'jform', 'load_data' => $loadData));
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
	
	public function getData($id = 0) {
        if($this->data) {
           return $this->data; 
        }
        
		if(!$id) $id = JRequest::getInt('id', 0);
		
        $db = JFactory::getDbo();
        $query = "SELECT * FROM #__hp_business_service WHERE id = '$id'";
        $db->setQuery($query);
        $this->data = $db->loadObject();
        $this->data->payment_type = json_decode(isset($this->data->payment_type) ? $this->data->payment_type : '[]');
        return $this->data;
    }
	
    /**
	 * Method to validate the form data.
	 *
	 * @param	object		$form		The form to validate against.
	 * @param	array		$data		The data to validate.
	 * @return	mixed		Array of filtered data if valid, false otherwise.
	 * @since	1.1
	 */
	function validate($form, $data) {
		$return = parent::validate($form, $data);
		if(!$return) return $return;
		
		//Check xem da ton tai dich vu loai nay chua
		$category = $data['category'];
		$id = $data['id'];
		if($id == 0) {
			$db = JFactory::getDbo();
			$db->setQuery(
				'SELECT * FROM #__hp_business_service WHERE category = '.(int)$category
			);
			if($db->loadObject()) {
				$this->setError('Bạn đã có dịch vụ này!');
				$return = false;
			}
		}
		
		return $return;
	}
    
	/**
	 * Method to save the form data.
	 *
	 * @param	array		The form data.
	 * @return	mixed		The user id on success, false on failure.
	 * @since	1.6
	 */
	public function save($data) {
		
		//Payment type
		$data['payment_type'] = json_encode($data['payment_type']);
		
		$imgTemp = JRequest::getVar('image-temp', array());
		$images = $imgTemp;
        
		//make object
        $info = new stdClass();
        foreach($data as $key => $value) {
            $info->$key = $value;
        }
        
        $id = $data['id'];
        $db = JFactory::getDbo();
        if($info->id == 0) {
            $db->insertObject('#__hp_business_service', $info);
			if($db->getError()) {
				return false;
			}
			$id = $db->insertid();
        }
        
        if($id) {
			//TODO: Xu ly anh???
	        include_once JPATH_ROOT.DS.'jnt'.DS.'classes'.DS.'upload.class.php';
	        $path = JPATH_ROOT.DS.'images'.DS.'users'.DS.$data['business_id'].DS.'services'.DS.$id;
	        @mkdir($path, 0777, true);
	        
	        $files = Upload::files('image', $path);
	        foreach ($files as $file) {
	        	if(is_array($file) && $file['result'] == 'OK') {
	        		$images[] = $file['file_name'];
	        	}
	        }
        }
        if(empty($images)) $images = array();
        
        $info->id = $id;
        $info->image = json_encode($images);
        $db->updateObject('#__hp_business_service', $info, 'id');
		if($db->getError()) {
			return false;
		}
		$id = $data['id'];
		return $id;
    }
}