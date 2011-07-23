<?php
class weddingControllerAlbum extends weddingController 
{
	function __construct($view = 'album')
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
		$tmpl = userHelpers::getCurrentTemplate($profile_id);
		$css = weddingHelper::getTemplateFolder('css', $tmpl->code);
		$images = weddingHelper::getTemplateFolder('images', $tmpl->code);
		$rows->images = $images;
		$rows->css = $css;
		$rows->menu = userHelpers::getUserMenu($profile_id);
		$this->_view->addTemplatePath(JPATH_COMPONENT.DS.'templates'.DS.$tmpl->code.DS);
		$rows->cuser = & JFactory::getUser($profile_id);
		$rows->userdata = userHelpers::getUserData($profile_id);
		$rows->username = $username;
		
		$rows->albums = $this->_model->getAlbums($profile_id);
		
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
		$id = JRequest::getInt('id');
		$rows = new stdClass();
		
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
		
		$rows->photos = $this->_model->getPhotos($id);
		
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
		$rows->albums = $this->_model->getAlbums($juser->id);
		
		$this->_view->setLayout('album.list');
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
		$rows->album = $this->_model->getAlbum();
		$rows->photos = $this->_model->getPhotos($rows->album->id);
		$rows->pagination = $this->_model->getPagination($rows->album->id);
		$this->_view->setLayout('album.edit');
		$this->_view->edit($rows);
	}
	
	function save()
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
		$url = 'index.php?option=com_wedding&view=album&layout=listitems&Itemid='.$Itemid;
		$result = $this->_model->save();
		if($result)
			$msg = 'Ghi lại thành công';
		else
			$msg = 'Lỗi xảy ra, vui lòng thử lại: '. $this->_model->getError();
		$this->setRedirect($url, $msg);
	}
	
	function savephoto()
	{
		$juser = & JFactory::getUser();
		if($juser->guest)
		{
			$url = JURI::base();
			$msg = 'Bạn phải đăng nhập để thực hiện chức năng này';
			$this->setRedirect($url, $msg);
			return ;
		}
		
		$album_id = JRequest::getInt('album_id');
		$Itemid = JRequest::getInt('Itemid');
		$url = 'index.php?option=com_wedding&view=album&layout=edit&album_id='.$album_id.'&Itemid='.$Itemid;
		$result = $this->_model->savephoto();
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
		$url = 'index.php?option=com_wedding&view=album&layout=listitems&Itemid='.$Itemid;
		$result = $this->_model->remove();
		if($result)
			$msg = 'Ghi lại thành công';
		else
			$msg = 'Lỗi xảy ra, vui lòng thử lại: '. $this->_model->getError();
		$this->setRedirect($url, $msg);
	}
	
	function removephoto()
	{
		$juser = & JFactory::getUser();
		if($juser->guest)
		{
			$url = JURI::base();
			$msg = 'Bạn phải đăng nhập để thực hiện chức năng này';
			$this->setRedirect($url, $msg);
			return ;
		}
		
		$album_id = JRequest::getInt('album_id');
		$Itemid = JRequest::getInt('Itemid');
		$url = 'index.php?option=com_wedding&view=album&layout=edit&album_id='.$album_id.'&Itemid='.$Itemid;
		$result = $this->_model->removephoto();
		if($result)
			$msg = 'Ghi lại thành công';
		else
			$msg = 'Lỗi xảy ra, vui lòng thử lại: '. $this->_model->getError();
		$this->setRedirect($url, $msg);
	}
}