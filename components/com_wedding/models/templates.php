<?php
/**
 * components/com_wedding/models/usercp.php
 * @author 		: Phạm Văn An
 * @version 	: 1.0
*/
 
// no direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class weddingModelTemplates extends JModel 
{
	function store()
	{
		$juser = & JFactory::getUser();
		if($juser->guest)
		{
			$error = 'Lỗi, bạn phải đăng nhập để thực hiện chức năng này';
			$this->setError($error);
			return false;
		}
		
		$tpl_id = JRequest::getInt('template_id');
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'template.php');
		$arTmpl = templateHelpers::getTemplateId();
		
		if(!in_array($tpl_id, $arTmpl))
		{
			$error = 'Lỗi, không tìm thấy template bạn yêu cầu';
			$this->setError($error);
			return false;
		}
		
		// check user exists
		$db = & JFactory::getDbo();
		$query = "SELECT user_id FROM #__wedding_users WHERE user_id = {$juser->id} LIMIT 1";
		$db->setQuery($query);
		$user_id = $db->loadResult();
		
		if(is_null($user_id))
		{
			$query = "INSERT INTO #__wedding_users (user_id, template_id) VALUES ($juser->id, $tpl_id)";
		}
		else
		{
			$query = "UPDATE #__wedding_users SET template_id = {$tpl_id} WHERE user_id = {$juser->id}";
		}
		$db->setQuery($query);
		$result = $db->query();
		
		if(!$result)
		{
			$error = $db->getErrorMsg();
			$this->setError($error);
			return false;
		}
		
		return true;
	}
}