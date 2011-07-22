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
class Jnt_HanhPhucViewBusiness_Promotions extends JView {

    protected $state;
	protected $items;
	protected $pagination;
    protected $businessInfo;
    
	function display($tpl = null) {
        
        $user = JFactory::getUser();
        if($user->guest) {
            //Require login
            $app = JFactory::getApplication();
            $app->redirect(JRoute::_('index.php?option=com_users&view=login'), 'Bạn cần đăng nhập!');
            return true;
        } else if($user->user_type != 2) {
            //Khong phai la doanh nghiep
            $app = JFactory::getApplication();
            $app->redirect(JRoute::_('index.php?option=com_users&view=login'), 'Bạn là người dùng cá nhân, hiện bạn không thể thực hiện chức năng này!');
            return true;
        }
        
        $introModel = JModel::getInstance('Intro', 'Jnt_HanhPhucModel');
        
        // Get some data from the models
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
        $this->businessInfo = $introModel->getBusinessInfo($user->id);
		
		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument() {
		
	}
}
