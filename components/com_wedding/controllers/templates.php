<?php
class weddingControllerTemplates extends weddingController 
{
	function __construct($view = 'templates')
	{
		parent::__construct($view);
	}
	
	function display()
	{
		$juser = & JFactory::getUser();
		
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'template.php');
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'user.php');
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'wedding.php');
		$user_template = userHelpers::getCurrentTemplate($juser->id);
		$templates = templateHelpers::getAllTemplates();
		
		$this->_view->setLayout('templates.default');
		$this->_view->display($juser, $templates, $user_template, $css);
	}
	
	function save()
	{
		$result = $this->_model->store();
		$itemId = JRequest::getInt('Itemid');
		$url = JURI::base().'index.php?option=com_wedding&view=templates&Itemid='.$itemId;
		if(!$result)
			$msg = 'Lỗi: '.$this->_model->getError();
		else
			$msg = 'Ghi lại thành công';
		
		$this->setRedirect($url, $msg);
	}
}