<?php
/**
 * components/com_wedding/models/profile.php
 * @author 		: Phạm Văn An
 * @version 	: 1.0
*/
 
// no direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class weddingModelProfile extends JModel 
{
	function savesetting()
	{
		$juser = & JFactory::getUser();		
		if($juser->guest)
		{
			$error = 'Bạn phải đăng nhập để thực hiện chức năng này';
			$this->setError($error);
			return false;
		}
		
		$post = JRequest::get('post');
		JArrayHelper::toInteger($post);
		
		$data = array();
		$data['user_id'] = $juser->id;
		$data['show_counter'] = $post['show_counter']==0 ? 0 : 1;
		$data['email_subscribe'] = $post['email_subscribe']==0 ? 0 : 1;
		$data['email_notify'] = $post['email_notify']==0 ? 0 : 1;
		$data['pre_check'] = $post['pre_check']==0 ? 0 : 1;
		
		$row = & $this->getTable('users');
		
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
	
	function saveinfo()
	{
		$juser = & JFactory::getUser();
		if($juser->guest)
		{
			$error = 'Bạn phải đăng nhập để thực hiện chức năng này';
			$this->setError($error);
			return false;
		}
		
		$post = JRequest::get('post');
		$data = array();
		$data['user_id'] = $juser->id;
		$data['couple_name'] = $post['couple_name'];
		$data['address'] = $post['address'];
		$data['country'] = $post['country'];
		
		if(isset($_FILES['avatar']) && $_FILES['avatar']['error']==0)
		{
			require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'thumb.php');
			$p = manThumb::resize($_FILES['avatar']['tmp_name'], 96, 96);
			$name = 'avatar_'.$juser->id.'.jpg';
			$file = JPATH_ROOT.DS.'images'.DS.'wedding'.DS.'avatar'.DS.$name;
			imagejpeg($p, $file, 90);
			imagedestroy($p);
			$data['avatar'] = 'images/wedding/avatar/'.$name;
		}
		
		$row = & $this->getTable('users');
		
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
