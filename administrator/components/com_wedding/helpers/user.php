<?php
defined('_JEXEC') or die;

class userHelpers
{
	function getUserInfo($user_id)
	{
		$db = & JFactory::getDbo();
		$query = "SELECT wu.*, u.username, u.name, u.email, u.block FROM #__users u LEFT JOIN #__wedding_users wu ON u.id = wu.user_id WHERE u.id = {$user_id} LIMIT 1";
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	function getApplications($user_id)
	{
		$db = & JFactory::getDbo();
		$query = "SELECT a.*, ua.* FROM #__wedding_apps a LEFT JOIN #__wedding_userapps ua ON a.id = ua.app_id AND ua.user_id = {$user_id} WHERE a.published = 1 ORDER BY app_ordering ASC, ordering ASC";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	
	function getUserAppsId($user_id)
	{
		$db = & JFactory::getDbo();
		$query = "SELECT app_id FROM #__wedding_userapps WHERE user_id = {$user_id} ORDER BY ordering";
		$db->setQuery($query);
		return $db->loadResultArray();
	}
	
	function getCurrentTemplate($user_id)
	{
		$db = & JFactory::getDbo();
		$query = "SELECT template_id FROM #__wedding_users WHERE user_id = {$user_id} LIMIT 1";
		$db->setQuery($query);
		$tmpl_id = $db->loadResult();
		
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'template.php');
		if(is_null($tmpl_id))
			return templateHelpers::getDefault();
		return templateHelpers::getTemplate($tmpl_id);
	}
	
	function getContent($user_id)
	{
		$db = & JFactory::getDbo();
		$query = "SELECT * FROM #__wedding_home WHERE user_id = {$user_id} LIMIT 1";
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	function getUserMenu($user_id)
	{
		$apps = self::getApplications($user_id);
		$juser = & JFactory::getUser($user_id);
		if($juser->guest)
		{
			echo 'Trang web không tồn tại';
			jexit();
		}
		
		if($apps)
		{
			$menu = '<ul id="blogmenu">';
			foreach($apps as $app)
			{
				$uri = new JURI(JURI::base().$app->url);
				$view = $uri->getVar('view');
				if($app->app_show===0 || $app->app_show==='0')
					continue;
				$title = empty($app->app_title) ? $app->title : $app->app_title;
				$menu .= '<li><a href="'.JURI::base().$juser->username.'/'.$view.'"><span>'.$title.'</span></a></li>';
			}
			$menu .= '</ul>';
		}
		
		return $menu;
	}
	
	function getUserData($user_id)
	{
		$data = array();
		$dbo = & JFactory::getDbo();
		$query = "SELECT profile_value FROM #__user_profiles WHERE user_id = {$user_id} AND profile_key = 'name_of_yours' LIMIT 1";
		$dbo->setQuery($query);
		$data['yours_name'] = $dbo->loadResult();
		
		$query = "SELECT profile_value FROM #__user_profiles WHERE user_id = {$user_id} AND profile_key = 'website_slogan' LIMIT 1";
		$dbo->setQuery($query);
		$data['slogan'] = $dbo->loadResult();
		
		$query = "SELECT profile_value FROM #__user_profiles WHERE user_id = {$user_id} AND profile_key = 'date_specify_later' LIMIT 1";
		$dbo->setQuery($query);
		$data['unknown'] = $dbo->loadResult();
		
		if(!$data['unknown'])
		{
			$query = "SELECT DATEDIFF(`profile_value`, CURRENT_DATE) FROM #__user_profiles WHERE user_id = {$user_id} AND profile_key = 'date_organization' LIMIT 1";
			$dbo->setQuery($query);
			$data['counter'] = $dbo->loadResult();
		}
		
		$query = "SELECT image FROM #__wedding_home WHERE user_id = {$user_id}";
		$dbo->setQuery($query);
		$data['homeimg'] = $dbo->loadResultArray();
		
		return $data;
	}
}
