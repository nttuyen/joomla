<?php
/**
 * components/com_wedding/controller.php
 @author 		: Phạm Văn An
 @version 		: 1.0
*/
 
// No direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
class weddingController extends JController
{    
	var $_view;
	var $_model;
	var $_template = 'default';
	
	function __construct($view = 'usercp')
	{
		parent::__construct();
		$docs = & JFactory::getDocument();
		$type = $docs->getType();
		$this->checkpassword($view, $type);
		$this->_view = & $this->getView($view, $type);
		$this->_view->addTemplatePath(JPATH_COMPONENT.DS.'templates'.DS.'default'.DS);
		
		if( file_exists(JPATH_COMPONENT.DS.'models'.DS.$view.'.php') )
		{
			$this->_model = & $this->getModel($view);		
			$this->_view->setModel($this->_model, true);
		}
		
		$document = & JFactory::getDocument();
		$css = JURI::base().'components/com_wedding/media/css/general.css';
		$document->addStyleSheet($css);
	}
	
	function checkpassword($view, $type)
	{
		$url = JURI::current();
		$session = & JFactory::getSession();
		$login = $session->get('com_wedding.'.$view.'login', 0);
		if(!$login)
		{			
			$juser = & JFactory::getUser();
			$username = JRequest::getString('user', $juser->username);
			require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'general.php');
			$profile_id = generalHelpers::getUserId($username);
			if(is_null($profile_id)) $profile_id = $juser->id;
			
			if($profile_id != $juser->id)
			{
				$url = 'index.php?option=com_wedding&view='.$view;
				$dbo = & JFactory::getDbo();
				$query = "SELECT id FROM #__wedding_apps WHERE `url` = '{$url}'";
				$dbo->setQuery($query);
				$app_id = $dbo->loadResult();
				
				$query = "SELECT `password` FROM #__wedding_userapps WHERE user_id = {$profile_id} AND app_id = {$app_id}";
				$dbo->setQuery($query);
				$password = $dbo->loadResult();
				if(!empty($password))
				{
					$uri = JFactory::getURI();
					$url = $uri->toString(array('path', 'query', 'fragment'));					
					$this->_view = & $this->getView('auth', $type);
					$this->_view->addTemplatePath(JPATH_COMPONENT.DS.'templates'.DS.'default'.DS);
					$this->_view->setLayout('auth.default');
					$this->_view->display($view, $uri, $profile_id, $app_id);
					exit();
				}
			}
		}
		return false;
	}
	
	function authlogin()
	{
		$profile_id = JRequest::getInt('profile_id');
		$app_id = JRequest::getInt('app_id');
		$password = JRequest::getString('password', '', '', JREQUEST_ALLOWRAW);
		$query = "SELECT `password` FROM #__wedding_userapps WHERE user_id = {$profile_id} AND app_id = {$app_id}";
		$dbo = & JFactory::getDbo();
		$dbo->setQuery($query);
		$userpw = $dbo->loadResult();
		$url = JRequest::getString('url');
		$return = base64_decode($url);
		if($userpw == $password)
		{
			$view = JRequest::getString('loginview');			
			$session = & JFactory::getSession();
			$session->set('com_wedding.'.$view.'login', 1);
		}
		$this->setRedirect($return);
	}
	
	function display()
	{
		$this->_view->display();
	}
}
