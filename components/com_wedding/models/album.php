<?php
jimport('joomla.application.component.model');
class weddingModelAlbum extends JModel 
{
	var $_data = null;
	var $_pagination = null;
	var $_total = null;
	
	function getPhotos($album_id)
	{
		if( empty( $this->_data ) )
		{
			$limit = 20;
			$limitstart = JRequest::getInt('limitstart');
			$query = $this->_buildQuery($album_id);
            $this->_data = $this->_getList($query, $limitstart, $limit); 
		}
		return $this->_data;
	}
	
	function getTotal($album_id)
	{
		if(empty($this->_total))
		{
			require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'general.php');
			$this->_total = generalHelpers::getTotal('#__wedding_album_photos', 'id', 'album_id='.$album_id);
		}
	}
	
	function getPagination($album_id)
	{
        if( empty( $this->_pagination ) )
        {
            jimport( 'joomla.html.pagination' );
            $this->_pagination = new JPagination($this->getTotal($album_id), $limitstart, $limit );
        }
        return $this->_pagination;
	}
	
	function _buildQuery($album_id)
	{
		$query = "SELECT * FROM #__wedding_album_photos WHERE album_id = {$album_id} ORDER BY created_date DESC";
		return $query;
	}
	
	function getAlbums($user_id)
	{
		$db = & JFactory::getDbo();
		$query = 'SELECT * FROM #__wedding_albums WHERE user_id = '.$user_id;
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	
	function getAlbum()
	{
		$db = & JFactory::getDbo();
		$query = 'SELECT * FROM #__wedding_albums WHERE id = '.JRequest::getInt('album_id').' LIMIT 1';
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	function save()
	{
		$db = & JFactory::getDbo();
		$data = JRequest::get('post');
		$data['thumbnail'] = null;
		$data['intro'] = JRequest::getVar('intro', '', '', 'string', JREQUEST_ALLOWHTML);
		
		$row = & $this->getTable('album');
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
			$p = manThumb::resize($_FILES['image']['tmp_name'], 160, 120);
			
			if(!empty($data['old_image']) && file_exists($data['old_image']))
			{
				unlink($data['old_image']);
			}
			
			jimport('joomla.filesystem.folder');			
			$file = JPATH_ROOT.DS.'images'.DS.'wedding'.DS.'album'.DS;
			if(! JFolder::exists($file))
			{
				JFolder::create($file, 755);
			}
			$time = time();
			$sfile = $file.'album-'.$juser->id.$time.'.jpg';
			
			if(!imagejpeg($p, $sfile, 90))
			{
				imagedestroy($p);
				$this->setError('Lưu file bị lỗi');
				return false;
			}
			
			imagedestroy($p);
			$data['thumbnail'] = 'images/wedding/album/album-'.$juser->id.$time.'.jpg';
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
	
	function savephoto()
	{
		$juser = & JFactory::getUser();
		$db = & JFactory::getDbo();		
		$data = JRequest::get('post');
		$data['photos'] = null;
		$data['thumbnail'] = null;
		
		if( isset($data['album_id']) )
		{
			$query = "SELECT user_id FROM #__wedding_albums WHERE id = {$data['album_id']} LIMIT 1";
			$db->setQuery($query);
			$user_id = $db->loadResult();
			
			if($juser->id != $user_id)
			{
				$this->setError('Bạn không có quyền ghi nội dung này');
				return false;
			}
		}
		else
		{
			$this->setError('Bạn không có quyền ghi nội dung này');
			return false;
		}
		
		if(isset($_FILES['image']) && $_FILES['image']['error']==0)
		{
			require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'thumb.php');
			
			try
			{
				$p = manThumb::resize($_FILES['image']['tmp_name'], 160, 120);
			}
			catch(Exception $e)
			{
				$this->setError($e->getMessage());
				return false;
			}
			
			jimport('joomla.filesystem.folder');			
			$file = JPATH_BASE.DS.'images'.DS.'wedding'.DS.'album'.DS;
			if(! JFolder::exists($file))
			{
				JFolder::create($file, 755);
			}
			
			$time = time();
			$sfile = $file.'photo-'.$data['album_id'].$time.'.jpg';
			$tfile = $file.'thumb-'.$juser->id.$time.'.jpg';
			
			if(!imagejpeg($p, $tfile, 90))
			{
				imagedestroy($p);
				$this->setError('Lưu file bị lỗi');
				return false;
			}
			imagedestroy($p);
			try
			{
				$p = manThumb::resize($_FILES['image']['tmp_name'], 1100);
			}
			catch(Exception $e)
			{
				$this->setError($e->getMessage());
				return false;
			}
			
			if(!imagejpeg($p, $sfile, 90))
			{
				imagedestroy($p);
				$this->setError('Lưu file bị lỗi');
				return false;
			}
			imagedestroy($p);
			
			$data['thumbnail'] = 'images/wedding/album/thumb-'.$juser->id.$time.'.jpg';
			$data['photos'] = 'images/wedding/album/photo-'.$data['album_id'].$time.'.jpg';
			$data['created_date'] = date('Y-m-d H:i:s', $time);
			
			$row = $this->getTable('photo');			
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
		else
		{
			$msg = 'Upload file thất bại, hãy thử lại với file có kích thước nhỏ hơn';
			$this->setError($msg);
			return false;
		}
	}
	
	function remove()
	{
		$id = JRequest::getInt('id');
		$row = & $this->getTable('album');
		$row->load($id);
		$juser = & JFactory::getUser();
		
		// delete album
		if($row->user_id != $juser->id)
		{
			$this->setError('Bạn không có quyền xóa nội dung này');
			return false;
		}
		$thumbnail = $row->thumbnail;
		if(!$row->delete())
		{
			$this->setError($row->_db->getErrorMsg());
			return false;
		}
		if(!empty($thumbnail) && file_exists($thumbnail))
		{
			unlink($pt->thumbnail);
		}
		//----------------------
		
		// delete photo in album
		$db = & JFactory::getDbo();
		$query = 'SELECT id, thumbnail, photos FROM #__wedding_album_photos WHERE album_id = '.$id;
		$db->setQuery($query);
		$photos = $db->loadObjectList();
		
		foreach($photos as $pt)
		{
			if(!empty($pt->thumbnail) && file_exists($pt->thumbnail))
			{
				@unlink($pt->thumbnail);
			}
			if(!empty($pt->photos) && file_exists($pt->photos))
			{
				@unlink($pt->photos);
			}
		}
		
		$query = 'DELETE FROM #__wedding_album_photos WHERE album_id = '.$id;
		$db->setQuery($query);
		$db->query();
		//----------------------
		
		return true;
	}
	
	function removephoto()
	{
		$id = JRequest::getInt('id');
		$juser = & JFactory::getUser();
		
		$row = $this->getTable('photo');
		$row->load($id);
		
		$row2 = $this->getTable('album');
		$row2->load($row->album_id);
		
		if($row2->user_id != $juser->id)
		{
			$this->setError('Bạn không có quyền xóa nội dung này');
			return false;
		}
		
		$thumbnail = $row->thumbnail;
		$photos = $row->photos;
		
		if(!$row->delete())
		{
			$this->setError($row->_db->getErrorMsg());
			return false;
		}
		
		if(!empty($thumbnail) && file_exists($thumbnail))
		{
			@unlink($thumbnail);
		}
		if(!empty($photos) && file_exists($photos))
		{
			@unlink($photos);
		}
		
		return true;
	}
}
