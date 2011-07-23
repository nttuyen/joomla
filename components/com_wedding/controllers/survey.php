<?php
class weddingControllerSurvey extends weddingController 
{
	function __construct($view = 'survey')
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
		$rows->survey = $this->_model->getSurveyDetails($profile_id);		
		$rows->is_voted = JRequest::getVar('com_wedding_survey_voted_'.$rows->survey->id, 0, 'cookie', 'int');
		
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
		
		$rows->survey = $this->_model->getResultDetails();
		
		$this->_view->setLayout('index');
		$this->_view->svresult($rows);
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
		$rows->surveys = $this->_model->getSurveys($juser->id);
		$rows->pagination = $this->_model->getPagination($juser->id);
		
		$this->_view->setLayout('survey.list');
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
		$rows->survey = $this->_model->getSurvey();
		$rows->answers = $this->_model->getAnswers($rows->survey->id);
		$rows->pagination = $this->_model->getPagination($rows->survey->id);
		$this->_view->setLayout('survey.edit');
		$this->_view->edit($rows);
	}
	
	function ansedit()
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
		$rows->answer = $this->_model->getAnswer();
		$this->_view->setLayout('survey.ansedit');
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
		$url = 'index.php?option=com_wedding&view=survey&layout=listitems&Itemid='.$Itemid;
		$result = $this->_model->save();
		if($result)
			$msg = 'Ghi lại thành công';
		else
			$msg = 'Lỗi xảy ra, vui lòng thử lại: '. $this->_model->getError();
		$this->setRedirect($url, $msg);
	}
	
	function saveanswer()
	{
		$juser = & JFactory::getUser();
		if($juser->guest)
		{
			$url = JURI::base();
			$msg = 'Bạn phải đăng nhập để thực hiện chức năng này';
			$this->setRedirect($url, $msg);
			return ;
		}
		
		$survey_id = JRequest::getInt('survey_id');
		$Itemid = JRequest::getInt('Itemid');
		$url = 'index.php?option=com_wedding&view=survey&layout=edit&survey_id='.$survey_id.'&Itemid='.$Itemid;
		$result = $this->_model->saveanswer();
		if($result)
			$msg = 'Ghi lại thành công';
		else
			$msg = 'Lỗi xảy ra, vui lòng thử lại: '. $this->_model->getError();
		$this->setRedirect($url, $msg);
	}
	
	function publish()
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
		$url = 'index.php?option=com_wedding&view=survey&layout=listitems&Itemid='.$Itemid;
		$result = $this->_model->publish();
		if($result)
			$msg = 'Ghi lại thành công';
		else
			$msg = 'Lỗi xảy ra, vui lòng thử lại: '. $this->_model->getError();
		$this->setRedirect($url, $msg);
	}
	
	function correct()
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
		$survey_id = JRequest::getInt('survey_id');
		$url = 'index.php?option=com_wedding&view=survey&survey_id='.$survey_id.'&layout=edit&Itemid='.$Itemid;
		$result = $this->_model->correct();
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
		$url = 'index.php?option=com_wedding&view=survey&layout=listitems&Itemid='.$Itemid;
		$result = $this->_model->remove();
		if($result)
			$msg = 'Ghi lại thành công';
		else
			$msg = 'Lỗi xảy ra, vui lòng thử lại: '. $this->_model->getError();
		$this->setRedirect($url, $msg);
	}
	
	function removeanswer()
	{
		$juser = & JFactory::getUser();
		if($juser->guest)
		{
			$url = JURI::base();
			$msg = 'Bạn phải đăng nhập để thực hiện chức năng này';
			$this->setRedirect($url, $msg);
			return ;
		}
		
		$survey_id = JRequest::getInt('survey_id');
		$Itemid = JRequest::getInt('Itemid');
		$url = 'index.php?option=com_wedding&view=survey&layout=edit&survey_id='.$survey_id.'&Itemid='.$Itemid;
		$result = $this->_model->removeanswer();
		if($result)
			$msg = 'Ghi lại thành công';
		else
			$msg = 'Lỗi xảy ra, vui lòng thử lại: '. $this->_model->getError();
		$this->setRedirect($url, $msg);
	}
	
	function dosurvey()
	{
		$limitstart = JRequest::getInt('limitstart');
		$survey_id = JRequest::getInt('survey_id');
		$query = "SELECT user_id FROM #__wedding_surveys WHERE id = {$survey_id} AND published = 1";
		$dbo = & JFactory::getDBO();
		$dbo->setQuery($query);
		$user_id = $dbo->loadResult();
		
		$juser = & JFactory::getUser($user_id);
		$url = 'index.php?option=com_wedding&view=survey&user='.$juser->username.'&tmpl=component';
		$result = $this->_model->dosurvey();
		if($result)
			$msg = 'Ghi lại thành công';
		else
			$msg = 'Lỗi xảy ra, vui lòng thử lại: '. $this->_model->getError();
		$this->setRedirect($url, $msg);
	}
}
