<?php
/**
 * @version		$Id: view.html.php 21018 2011-03-25 17:30:03Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML Article View class for the Content component
 *
 * @package		Joomla.Site
 * @subpackage	com_content
 * @since		1.5
 */
class Jnt_HanhPhucViewIntro extends JView
{
	protected $data;
    protected $businessInfo;
	protected $form;
	protected $state;

	function display($tpl = null) {
        // Get the view data.
		$this->data		= $this->get('Data');
        $this->businessInfo = $this->get('BusinessInfo');
		$this->form		= $this->get('Form');
		$this->state	= $this->get('State');
        
        //get param
        $businessId = JRequest::getInt('bid', 0);
        $layout = JRequest::getString('layout', 'default');
        
        $user = JFactory::getUser();
        
        //Check permission in edit
        if($layout == 'edit') {
            if($this->businessInfo->guest) {
                $app = JFactory::getApplication();
                $app->redirect('index.php?option=com_users&view=login', 'Bạn cần đăng nhập mới có thể sửa thông tin');
                return true;
            }
            if($this->businessInfo->user_type != 2 || $this->businessInfo->id != $user->id) {
                $app = JFactory::getApplication();
                $app->redirect('index.php?option=com_users&view=login', 'Bạn không có quyền sửa thông tin sửa thông tin');
                return true;
            }
        }
        
        if(empty($this->data->content) && $layout == 'default' && $businessId > 0) {
            if($businessId == $user->id && $user->user_type == 2) {
                //Redirect to edit
                $app = JFactory::getApplication();
                $app->redirect(JRoute::_('index.php?option=com_jnt_hanhphuc&view=intro&layout=edit&bid='.$businessId));
                return true;
            }
        }
        if(empty ($this->data->content) && $layout != 'edit') {
            //Redirect to home page
            $app = JFactory::getApplication();
            $app->redirect(JRoute::_(''), 'Hiện chưa có thông tin về doanh nghiệp này!', 'error');
            return true;
        }
        
//        var_dump($this->data);
//        var_dump($this->businessInfo);
//        var_dump($this->form);
//        var_dump($this->state);
		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument() {
		
	}
}
