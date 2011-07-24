<?php
/**
 * @version		$Id: contact.php 20982 2011-03-17 16:12:00Z chdemko $
 * @package		Joomla.Site
 * @subpackage	Contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class Jnt_HanhPhucControllerBusiness_Promotion extends JController {
    
    public function save($key = null, $urlVar = null) {
        // Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app	= JFactory::getApplication();
		$model	= $this->getModel('Business_Promotion', 'Jnt_HanhPhucModel');
		$user	= JFactory::getUser();
		$userId	= (int) $user->get('id');

		// Get the user data.
		$data = JRequest::getVar('jform', array(), 'post', 'array');
		
		// Force the ID to this user.
		if($data['business_id'] != $userId) {
            //Redirect to homepage
            $this->setRedirect(JRoute::_(''), 'Bạn không có quyền sửa thông tin này!', 'error');
            return true;
        }

		// Validate the posted data.
		$form = $model->getForm();
		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}

		// Validate the posted data.
		$data = $model->validate($form,$data);

		// Check for errors.
		if ($data === false) {
			// Get the validation messages.
			$errors	= $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if (JError::isError($errors[$i])) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}
            $app->setUserState('com_jnt_hanhphuc.edit.business_promotion.data', $data);
			$this->setRedirect(JRoute::_('index.php?option=com_jnt_hanhphuc&view=business_promotion&layout=edit&id='.$data['id'], false));
			return false;
		}

		// Attempt to save the data.
		$return	= $model->save($data);

		// Check for errors.
		if ($return === false) {
			// Redirect back to the edit screen.
			//$this->setMessage('', 'warning');
            $app->setUserState('com_jnt_hanhphuc.edit.business_promotion.data', $data);
			$this->setRedirect(JRoute::_('index.php?option=com_jnt_hanhphuc&view=business_promotion&layout=edit&id='.$data['id'], false));
			return false;
		}

		// Redirect the user and adjust session state based on the chosen task.
		switch ($this->getTask()) {
			default:
				// Redirect to the list screen.
				$this->setMessage('Đã lưu thông tin dịch vụ thành công!');
				$this->setRedirect(JRoute::_('index.php?option=com_jnt_hanhphuc&view=business_promotions', false));
				break;
		}

		// Flush the data from the session.
		$app->setUserState('com_jnt_hanhphuc.edit.business_promotion.data', null);
    }
}
