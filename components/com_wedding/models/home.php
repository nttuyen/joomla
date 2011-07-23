<?php
jimport('joomla.application.component.model');
class weddingModelHome extends JModel 
{
	function save()
	{
		$db = & JFactory::getDbo();
		$data = JRequest::get('post');
		$data['intro'] = JRequest::getVar('intro', '', '', 'string', JREQUEST_ALLOWHTML);
		$data['content'] = JRequest::getVar('content', '', '', 'string', JREQUEST_ALLOWHTML);
		
		$row = & $this->getTable('home');
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
			$data['id'] = null;
			require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'user.php');
			$content = userHelpers::getContent($juser->id);
			if(!empty($content) && $content->id > 0)
				$data['id'] = $content->id;
		}
		
		$data['user_id'] = $juser->id;
		if(isset($_FILES['image']) && $_FILES['image']['error']==0)
		{
			require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'thumb.php');
			$p = manThumb::resize($_FILES['image']['tmp_name'], 540);
			jimport('joomla.filesystem.folder');
			
			$file = JPATH_ROOT.DS.'images'.DS.'wedding'.DS.'home'.DS;//;
			if(! JFolder::exists($file))
			{
				JFolder::create($file, 755);
			}
			imagejpeg($p, $file.'home-'.$juser->id.'.jpg', 90);
			imagedestroy($p);
			$data['image'] = 'images/wedding/home/home-'.$juser->id.'.jpg';
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
}