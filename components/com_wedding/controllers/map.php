<?php
class weddingControllerMap extends weddingController 
{
	function __construct($view = 'map')
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
		
		$rows->intro = $this->_model->getIntro($profile_id);
		$rows->stories = $this->_model->getStories($profile_id);
		$rows->pagination = $this->_model->getPagination($profile_id);
		
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'user.php');
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'wedding.php');
		$tmpl = userHelpers::getCurrentTemplate($profile_id);
		$css = weddingHelper::getTemplateFolder('css', $tmpl->code);
		$images = weddingHelper::getTemplateFolder('images', $tmpl->code);
		$rows->images = $images;
		$rows->css = $css;
		$rows->menu = userHelpers::getUserMenu($profile_id);
		$this->_view->addTemplatePath(JPATH_COMPONENT.DS.'templates'.DS.$tmpl->code.DS);
		$rows->userdata = userHelpers::getUserData($profile_id);
		$rows->username = $username;
		
		$this->_view->setLayout('index');
		$this->_view->display($rows);
	}
	
	function details()
	{
		$juser = & JFactory::getUser();
		$username = JRequest::getString('user', $juser->username);
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'general.php');
		$profile_id = generalHelpers::getUserId($username);
		if(is_null($profile_id)) $profile_id = $juser->id;
		$rows = new stdClass();
		
		$rows->story = $this->_model->getDetails($profile_id);
		
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'user.php');
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'wedding.php');
		$tmpl = userHelpers::getCurrentTemplate($profile_id);
		$css = weddingHelper::getTemplateFolder('css', $tmpl->code);
		$images = weddingHelper::getTemplateFolder('images', $tmpl->code);
		$rows->images = $images;
		$rows->css = $css;
		$rows->menu = userHelpers::getUserMenu($profile_id);
		$this->_view->addTemplatePath(JPATH_COMPONENT.DS.'templates'.DS.$tmpl->code.DS);
		$rows->userdata = userHelpers::getUserData($profile_id);
		
		$this->_view->setLayout('index');
		$this->_view->details($rows);
	}
	
	function listitems()
	{
		$juser = & JFactory::getUser();
		if($juser->guest)
		{
			$url = JURI::base();
			$msg = 'Bạn phải đăng nhập để thực hiện chức năng này';
			$this->setRedirect($url, $msg);
			return ;
		}
		
		$rows = new stdClass();
		$rows->intro = $this->_model->getIntro($juser->id);
		$rows->stories = $this->_model->getStories($juser->id);
		$rows->pagination = $this->_model->getPagination($juser->id);
		
		$this->_view->setLayout('map.list');
		$this->_view->listitems($rows);
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
		
		$rows = new stdClass();
		$rows->story = $this->_model->getStory();
		$this->_view->setLayout('map.edit');
		$this->_view->edit($rows);
	}
	
	function save()
	{
		$url = 'index.php?option=com_wedding&view=map&layout=listitems&Itemid='.JRequest::getInt('Itemid');
		$result = $this->_model->save();
		if($result)
			$msg = 'Ghi lại thành công';
		else
			$msg = 'Lỗi xảy ra, vui lòng thử lại: '. $this->_model->getError();
		$this->setRedirect($url, $msg);
	}
	
	function saveintro()
	{
		$url = 'index.php?option=com_wedding&view=map&layout=listitems&Itemid='.JRequest::getInt('Itemid');
		$result = $this->_model->saveintro();
		if($result)
			$msg = 'Ghi lại thành công';
		else
			$msg = 'Lỗi xảy ra, vui lòng thử lại: '. $this->_model->getError();
		$this->setRedirect($url, $msg);
	}
	
	function remove()
	{
		$juser = & JFactory::getUser();
		if($juser->guest)
		{
			$url = JURI::base();
			$msg = 'Bạn phải đăng nhập để thực hiện chức năng này';
			$this->setRedirect($url, $msg);
			return ;
		}
		
		$Itemid = JRequest::getInt('Itemid');
		$url = 'index.php?option=com_wedding&view=map&layout=listitems&Itemid='.$Itemid;
		$result = $this->_model->remove();
		if($result)
			$msg = 'Ghi lại thành công';
		else
			$msg = 'Lỗi xảy ra, vui lòng thử lại: '. $this->_model->getError();
		$this->setRedirect($url, $msg);
	}
}
