<?php
class weddingControllerGuestbook extends weddingController 
{
	function __construct($view = 'guestbook')
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
		$css = weddingHelper::getTemplateFolder('css', $tmpl->code);
		$images = weddingHelper::getTemplateFolder('images', $tmpl->code);
		$rows->images = $images;
		$rows->css = $css;
		$rows->menu = userHelpers::getUserMenu($profile_id);
		$this->_view->addTemplatePath(JPATH_COMPONENT.DS.'templates'.DS.$tmpl->code.DS);
		
		$rows->guestbooks = $this->_model->getGuestbooks($profile_id, 1);
		$rows->pagination = $this->_model->getPagination($profile_id, 1);
		$rows->userdata = userHelpers::getUserData($profile_id);
		
		$this->_view->setLayout('index');
		$this->_view->display($rows);
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
		$rows->guestbooks = $this->_model->getGuestbooks($juser->id, 0);
		$rows->pagination = $this->_model->getPagination($juser->id, 0);
		
		$this->_view->setLayout('guestbook.list');
		$this->_view->listitems($rows);
	}
	
	function save()
	{
		$juser = & JFactory::getUser(JRequest::getInt('user_id'));
		$url = 'index.php?option=com_wedding&view=guestbook&user='.$juser->username.'&tmpl=component';
		$result = $this->_model->save();
		if($result)
			$msg = 'Ghi lại thành công';
		else
			$msg = 'Lỗi xảy ra, vui lòng thử lại: '. $this->_model->getError();
		$this->setRedirect($url, $msg);
	}
	
	function remove()
	{
		$url = 'index.php?option=com_wedding&view=guestbook&layout=listitems&Itemid='.JRequest::getInt('Itemid');
		$result = $this->_model->remove();
		if($result)
			$msg = 'Ghi lại thành công';
		else
			$msg = 'Lỗi xảy ra, vui lòng thử lại: '. $this->_model->getError();
		$this->setRedirect($url, $msg);
	}	
	function publish()
	{
		$url = 'index.php?option=com_wedding&view=guestbook&layout=listitems&Itemid='.JRequest::getInt('Itemid');
		$result = $this->_model->publish();
		if($result)
			$msg = 'Ghi lại thành công';
		else
			$msg = 'Lỗi xảy ra, vui lòng thử lại: '. $this->_model->getError();
		$this->setRedirect($url, $msg);
	}
}
