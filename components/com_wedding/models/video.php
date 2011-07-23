<?php
jimport('joomla.application.component.model');
class weddingModelVideo extends JModel 
{
	var $_data = null;
	var $_pagination = null;
	var $_total = null;
	
	function getVideos($user_id, $p = 0)
	{
		if( empty( $this->_data ) )
		{
			$limit = 20;
			$limitstart = JRequest::getInt('limitstart');
			$query = $this->_buildQuery($user_id, $p);
            $this->_data = $this->_getList($query, $limitstart, $limit); 
		}
		return $this->_data;
	}
	
	function getTotal($user_id, $p = 0)
	{
		if(empty($this->_total))
		{
			require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'general.php');
			$this->_total = generalHelpers::getTotal('#__wedding_videos', 'id', 'user_id='.$user_id.' AND published >= '.$p);
		}
	}
	
	function getPagination($user_id, $p = 0)
	{
        if( empty( $this->_pagination ) )
        {
            jimport( 'joomla.html.pagination' );
            $this->_pagination = new JPagination($this->getTotal($user_id, $p), $limitstart, $limit );
        }
        return $this->_pagination;
	}
	
	function _buildQuery($user_id, $p = 0)
	{		
		$juser = & JFactory::getUser();
		$query = "SELECT * FROM #__wedding_videos WHERE user_id = {$user_id} AND published >= {$p} ORDER BY created_date DESC";
		return $query;
	}
	
	function getVideo()
	{
		$db = & JFactory::getDbo();
		$query = 'SELECT * FROM #__wedding_videos WHERE id = '.JRequest::getInt('id').' LIMIT 1';
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	function save()
	{
		$juser = & JFactory::getUser();
		$db = & JFactory::getDbo();
		$data = JRequest::get('post');
		$old_file = null;
		
		$row = & $this->getTable('video');
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
			$data['type'] = empty($row->file) ? 1 : 0;
			$old_file = $row->file;
		}
		else
		{
			$data['type'] = JRequest::getInt('type');
			$data['created_date'] = date('Y-m-d H:i:s');
		}
			
		$data['user_id'] = $juser->id;
		
		if(isset($data['type']) && $data['type']==0)
		{
			$data['embed'] = '';
			
			if( isset($_FILES['file']) && $_FILES['file']['error']==0 )
			{
				$ext = substr($_FILES['file']['name'], -4);
				if($ext=='.flv' || $ext=='.wmv' || $ext=='.avi' || $ext=='.mp4' || $ext=='.mpg')
				{
					$file = JPATH_BASE.DS.'images'.DS.'wedding'.DS.'videos'.DS.$juser->id.DS;
					jimport('joomla.filesystem.folder');
					if(!JFolder::exists($file))
					{
						JFolder::create($file);
					}
					move_uploaded_file($_FILES['file']['tmp_name'], $file.$_FILES['file']['name']);
					
					$data['file'] = 'images/wedding/videos/'.$juser->id.'/'.$_FILES['file']['name'];
				}
				else
				{
					$this->setError('file videos phải ở dạng .flv, .wmv, .avi, .mpg hoặc .mp4');
					return false;
				}
			}
			else
			{
				$this->setError('upload file lỗi');
				return false;
			}
		}
		else
		{
			$data['file'] = '';
			$data['embed'] = JRequest::getVar('embed', '', '', 'string', JREQUEST_ALLOWRAW);
			$data['embed'] = $db->getEscaped($data['embed']);
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
		
		if(!empty($old_file) && file_exists($old_file) && $old_file!=$row->file)
			@unlink($old_file);
		
		return true;
	}
	
	function publish()
	{
		$id = JRequest::getInt('id');
		$row = & $this->getTable('video');
		$row->load($id);
		$juser = & JFactory::getUser();
		
		// delete survey
		if($row->user_id != $juser->id)
		{
			$this->setError('Bạn không có quyền sửa nội dung này');
			return false;
		}
		
		$row->published = ($row->published == 0 ? 1 : 0);
		
		if(!$row->store())
		{
			$this->setError($row->_db->getErrorMsg());
			return false;
		}
		
		return true;
	}
	
	function remove()
	{
		$id = JRequest::getInt('id');
		$row = & $this->getTable('video');
		$row->load($id);
		$juser = & JFactory::getUser();
		
		// delete survey
		if($row->user_id != $juser->id)
		{
			$this->setError('Bạn không có quyền xóa nội dung này');
			return false;
		}
		$old_file = $row->file;
		if(!$row->delete())
		{
			$this->setError($row->_db->getErrorMsg());
			return false;
		}
		//----------------------
		
		// delete answers
		if(!empty($old_file) && file_exists($old_file))
			@unlink($old_file);
		//----------------------
		
		return true;
	}
}