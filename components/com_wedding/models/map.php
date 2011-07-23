<?php
jimport('joomla.application.component.model');
class weddingModelMap extends JModel 
{
	var $_data = null;
	var $_pagination = null;
	var $_total = null;
	
	function getStories($user_id)
	{
		if( empty( $this->_data ) )
		{
			$limit = 20;
			$limitstart = JRequest::getInt('limitstart');
			$query = $this->_buildQuery($user_id);
            $this->_data = $this->_getList($query, $limitstart, $limit); 
		}
		return $this->_data;
	}
	
	function getTotal($user_id)
	{
		if(empty($this->_total))
		{
			require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'general.php');
			$this->_total = generalHelpers::getTotal('#__wedding_map', 'id', 'user_id='.$user_id);
		}
	}
	
	function getPagination($user_id)
	{
        if( empty( $this->_pagination ) )
        {
            jimport( 'joomla.html.pagination' );
            $this->_pagination = new JPagination($this->getTotal($user_id), $limitstart, $limit );
        }
        return $this->_pagination;
	}
	
	function _buildQuery($user_id)
	{		
		$juser = & JFactory::getUser();
		$query = "SELECT * FROM #__wedding_map WHERE user_id = {$user_id} ORDER BY created_date DESC";
		return $query;
	}
	
	function getDetails($user_id)
	{
		$db = & JFactory::getDbo();
		$query = 'SELECT * FROM #__wedding_map WHERE id = '.JRequest::getInt('id').' AND user_id = '.$user_id.' LIMIT 1';
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	function getStory()
	{
		$db = & JFactory::getDbo();
		$query = 'SELECT * FROM #__wedding_map WHERE id = '.JRequest::getInt('id').' LIMIT 1';
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	function getIntro($user_id)
	{
		$db = & JFactory::getDbo();
		$query = "SELECT intro FROM #__wedding_map_intro WHERE user_id = {$user_id} LIMIT 1";
		$db->setQuery($query);
		return $db->loadResult();
	}
	
	function save()
	{
		$db = & JFactory::getDbo();
		$data = JRequest::get('post');
		$data['intro'] = JRequest::getVar('intro', '', '', 'string', JREQUEST_ALLOWHTML);
		$data['content'] = JRequest::getVar('content', '', '', 'string', JREQUEST_ALLOWHTML);
		
		$row = & $this->getTable('map');
		$juser = & JFactory::getUser();
		
		if(isset($data['id']) && $data['id'] > 0)
		{
			$row->load($data['id']);
			if($row->user_id != $juser->id)
			{
				$error = 'Bạn không có quyền ghi nội dung này';
				$this->setError($error);
				return false;
			}
		}
		else
		{
			$data['created_date'] = date('Y-m-d H:i:s');
		}
		
		$data['modified_date'] = date('Y-m-d H:i:s');
		
		$data['user_id'] = $juser->id;
		if(isset($_FILES['image']) && $_FILES['image']['error']==0)
		{
			require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'thumb.php');
			$p = manThumb::resize($_FILES['image']['tmp_name'], 540);
			
			if(!empty($data['old_image']) && file_exists($data['old_image']))
			{
				unlink($data['old_image']);
			}
			
			jimport('joomla.filesystem.folder');			
			$file = JPATH_ROOT.DS.'images'.DS.'wedding'.DS.'map'.DS;
			if(! JFolder::exists($file))
			{
				JFolder::create($file, 755);
			}
			$time = time();
			$sfile = $file.'map-'.$juser->id.$time.'.jpg';
			
			imagejpeg($p, $sfile, 90);
			imagedestroy($p);
			$data['image'] = 'images/wedding/map/map-'.$juser->id.$time.'.jpg';
		}
		
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
	
	function saveintro()
	{
		$juser = & JFactory::getUser();
		if($juser->guest)
		{
			$this->setError('Bạn phải đăng nhập để thực hiện chức năng này');
			return false;
		}
		$data = array();
		$data['user_id'] = $juser->id;
		$db = & JFactory::getDbo();
		$query = 'SELECT id FROM #__wedding_map_intro WHERE user_id = '.$juser->id.' LIMIT 1';
		$db->setQuery($query);
		$data['id'] = $db->loadResult();
		$data['intro'] = JRequest::getVar('intro', '', '', 'string', JREQUEST_ALLOWHTML);
		
		$row = $this->getTable('mapintro');
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
		$row = & $this->getTable('map');
		$row->load($id);
		$juser = & JFactory::getUser();
		
		if($row->user_id != $juser->id)
		{
			$this->setError('Bạn không có quyền xóa nội dung này');
			return false;
		}
		$image = $row->image;
		if(!$row->delete())
		{
			$this->setError($row->_db->getErrorMsg());
			return false;
		}
		if(strlen($image) && file_exists($image))
		{
			unlink($image);
		}
		
		return true;
	}
}
