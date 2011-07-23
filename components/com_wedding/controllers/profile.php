<?php
class weddingControllerProfile extends weddingController 
{
	function __construct($view = 'profile')
	{
		parent::__construct($view);
	}
	
	function display()
	{
		$juser = & JFactory::getUser();
		$cuser = null;
		
		if($juser->id > 0)
		{		
			require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'user.php');
			$cuser = userHelpers::getUserInfo($juser->id);
		}
		
		$this->_view->setLayout('profile.default');
		$this->_view->display($juser, $cuser);
	}
	
	function savesetting()
	{
		$url = 'index.php?option=com_wedding&view=profile&Itemid='.JRequest::getInt('Itemid');
		$result = $this->_model->savesetting();
		
		if(!$result)
		{
			$msg = $this->_model->getError();			
		}
		else
		{
			$msg = 'Lưu thông tin thành công';
		}
		
		$this->setRedirect($url, $msg);
	}
	
	function savepassword()
	{
		$data['password'] = JRequest::getVar('password', '', '', '', JREQUEST_ALLOWRAW);		
	}
	
	function saveinfo()
	{
		$url = 'index.php?option=com_wedding&view=profile&Itemid='.JRequest::getInt('Itemid');
		$result = $this->_model->saveinfo();
		
		if(!$result)
		{
			$msg = $this->_model->getError();			
		}
		else
		{
			$msg = 'Lưu thông tin thành công';
		}
		
		$this->setRedirect($url, $msg);
	}
}
