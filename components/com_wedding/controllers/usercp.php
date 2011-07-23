<?php
class weddingControllerUsercp extends weddingController 
{
	function __construct($view = 'usercp')
	{
		parent::__construct($view);
	}
	
	function display()
	{
		$juser = & JFactory::getUser();
		$apps = null;
		$user_apps = null;
		$is_default = false;
		if($juser->id > 0)
		{
			require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'user.php');
			$apps = userHelpers::getApplications($juser->id);
		}
		
		$this->_view->setLayout('usercp.default');
		$this->_view->display($juser, $apps);
	}
	
	function save()
	{
		$result = $this->_model->store();
		$itemId = JRequest::getInt('Itemid');
		$url = JURI::base().'index.php?option=com_wedding&view=usercp&Itemid='.$itemId;
		if(!$result)
			$msg = 'Lỗi: '.$this->_model->getError();
		else
			$msg = 'Ghi lại thành công';
		
		$this->setRedirect($url, $msg);
	}
}
