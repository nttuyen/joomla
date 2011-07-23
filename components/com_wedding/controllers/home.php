<?php
class weddingControllerHome extends weddingController 
{
	function __construct($view = 'home')
	{
		parent::__construct($view);
	}
	
	function display()
	{
		$juser = & JFactory::getUser();
		$username = JRequest::getString('user', $juser->username);
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'general.php');
		$profile_id = generalHelpers::getUserId($username);
		if(is_null($profile_id)) $profile_id = $juser->id;
		$rows = new stdClass();
		
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'user.php');
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'wedding.php');
		$rows->cuser = userHelpers::getUserInfo($profile_id);
		
		$tmpl = userHelpers::getCurrentTemplate($profile_id);
		$this->_view->addTemplatePath(JPATH_COMPONENT.DS.'templates'.DS.$tmpl->code.DS);
		
		$rows->css = weddingHelper::getTemplateFolder('css', $tmpl->code);
		$rows->menu = userHelpers::getUserMenu($profile_id);
		$images = weddingHelper::getTemplateFolder('images', $tmpl->code);
		$rows->images = $images;
		$rows->content = userHelpers::getContent($profile_id);
		$rows->userdata = userHelpers::getUserData($profile_id);
		
		$this->_view->setLayout('index');
		$this->_view->display($rows);
	}
	
	function edit()
	{
		$juser = & JFactory::getUser();
		if($juser->guest)
		{
			$url = JURI::base();
			$msg = 'Bạn phải đăng nhập để thực hiện chức năng này';
			$this->setRedirect($url, $msg);
			return ;
		}
		
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'user.php');
		$rows->content = userHelpers::getContent($juser->id);
		
		$this->_view->setLayout('home.edit');
		$this->_view->edit($rows);
	}
	
	function save()
	{
		$url = 'index.php?option=com_wedding&view=home&layout=edit&Itemid='.JRequest::getInt('Itemid');
		$result = $this->_model->save();
		if($result)
			$msg = 'Ghi lại thành công';
		else
			$msg = 'Lỗi xảy ra, vui lòng thử lại: '. $this->_model->getError();
		$this->setRedirect($url, $msg);
	}
}