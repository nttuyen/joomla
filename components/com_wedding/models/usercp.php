<?php
/**
 * components/com_wedding/models/usercp.php
 * @author 		: Phạm Văn An
 * @version 	: 1.0
*/
 
// no direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class weddingModelUsercp extends JModel 
{
	function store()
	{
		$order = JRequest::getVar('order', '', '', 'array');
		$title = JRequest::getVar('title', '', '', 'array');
		$app_show = JRequest::getVar('app_show', '', '', 'array');
		$password = JRequest::getVar('password', '', '', 'array');
		$juser = & JFactory::getUser();
		
		if($juser->guest)
		{
			$this->setError('Có lỗi xảy ra, bạn phải đăng nhập để thực hiện chức năng này');
			return false;
		}
		
		JArrayHelper::toInteger($order);
		JArrayHelper::toInteger($app_show);
		
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'application.php');
		$apps = applicationHelpers::getAppsId();
		$values = '';		
		$i = 0;
		foreach ($apps as $app_id)
		{
			if( !isset($title[$app_id]) || !isset($order[$app_id]) || !isset($app_show[$app_id]) || !isset($password[$app_id]) )
			{
				$error = 'Có lỗi xảy ra, vui lòng không bỏ trống thông tin tên menu, hoặc thứ tự menu';
				$this->setError();
				return false;
			}
			
			if($i==0)
			{
				$i++;
				$hyphen = '';
			}
			else
			{
				$hyphen = ',';
			}
			$values .= ($hyphen.' ('.$juser->id.', '.$app_id.', \''.$title[$app_id].'\', '.$order[$app_id].','.($app_show[$app_id]==0 ? 0 : 1).', \''.$password[$app_id].'\')');
		}
		
		$db = & JFactory::getDbo();
		$query = 'DELETE FROM #__wedding_userapps WHERE user_id = '. $juser->id;
		$db->setQuery($query);
		$result = $db->query();
		
		if(!$result)
		{
			$error = 'Có lỗi khi xử lý dữ liệu, vui lòng thử lại';
			$this->setError($error);
			return false;
		}
		
		$query = "INSERT INTO #__wedding_userapps(`user_id`, `app_id`, `app_title`, `app_ordering`, `app_show`, `password`) VALUES {$values}";
		$db->setQuery($query);
		$result = $db->query();
		
		if(!$result)
		{
			$error = 'Có lỗi khi cập nhật dữ liệu, vui lòng thử lại'.$db->getErrorMsg();
			$this->setError($error);
			return false;
		}
		$this->_reorder();
		return true;
	}
	
	function _reorder()
	{
		$juser = & JFactory::getUser();
		$db = & JFactory::getDbo();
		$query = "SELECT app_id FROM #__wedding_userapps WHERE user_id = {$juser->id} ORDER BY app_ordering ASC";
		
		$db->setQuery($query);
		$apps = $db->loadResultArray();
		$order = 0;
		foreach ($apps as $app_id)
		{
			$order++;
			$case .= " WHEN $app_id THEN $order";
		}
		
		$query = "UPDATE #__wedding_userapps SET app_ordering = CASE app_id {$case} END WHERE user_id = {$juser->id}";
		$db->setQuery($query);
		$db->query();
	}
}
