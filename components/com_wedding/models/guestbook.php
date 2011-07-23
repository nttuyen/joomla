<?php
jimport('joomla.application.component.model');
class weddingModelGuestbook extends JModel 
{
	var $_data = null;
	var $_pagination = null;
	var $_total = null;
	
	function getGuestbooks($user_id, $published)
	{
		if( empty( $this->_data ) )
		{
			$limit = 20;
			$limitstart = JRequest::getInt('limitstart');
			$query = $this->_buildQuery($user_id, $published);
            $this->_data = $this->_getList($query, $limitstart, $limit); 
		}
		return $this->_data;
	}
	
	function getTotal($user_id, $published)
	{
		if(empty($this->_total))
		{
			require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'general.php');
			$this->_total = generalHelpers::getTotal('#__wedding_guestbook', 'id', 'user_id='.$user_id.' AND published >= '.$published);
		}
	}
	
	function getPagination($user_id, $published)
	{
        if( empty( $this->_pagination ) )
        {
            jimport( 'joomla.html.pagination' );
            $this->_pagination = new JPagination($this->getTotal($user_id, $published), $limitstart, $limit );
        }
        return $this->_pagination;
	}
	
	function _buildQuery($user_id, $published)
	{		
		$juser = & JFactory::getUser();
		$query = "SELECT * FROM #__wedding_guestbook WHERE user_id = {$user_id} AND published >= {$published} ORDER BY created_date DESC";
		return $query;
	}
	
	function save()
	{
		$db = & JFactory::getDbo();
		$data = JRequest::get('post');
		$data['content'] = JRequest::getVar('description', '', '', 'string', JREQUEST_ALLOWHTML);		
		$data['created_date'] = date('Y-m-d H:i:s');
		$data['published'] = 1;
		$data['user_id'] = JRequest::getInt('user_id');
		
		$row = & $this->getTable('guestbook');
		if(!$row->bind($data))
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		if(!$row->store())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		return true;
	}
	
	function remove()
	{
		$id = JRequest::getInt('id');
		$row = & $this->getTable('guestbook');
		$row->load($id);
		$juser = & JFactory::getUser();
		
		if($row->user_id != $juser->id)
		{
			$this->setError('Bạn không có quyền xóa nội dung này');
			return false;
		}
		
		if(!$row->delete())
		{
			$this->setError($row->_db->getErrorMsg());
			return false;
		}
		return true;
	}
	
	function publish()
	{
		$id = JRequest::getInt('id');
		$row = & $this->getTable('guestbook');
		$row->load($id);
		$juser = & JFactory::getUser();
		
		if($row->user_id != $juser->id)
		{
			$this->setError('Bạn không có quyền xóa nội dung này');
			return false;
		}
		
		$row->published = $row->published ? 0 : 1;
		if(!$row->store())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		return true;
	}
}
