<?php
class modBloggersHelper
{
	static function getBloggers($limit = 8)
	{
		$dbo = & JFactory::getDbo();		
		$query = "SELECT u.id, u.username, (SELECT profile_value FROM #__user_profiles up WHERE up.user_id = u.id AND profile_key = 'name_of_yours' LIMIT 1) AS couple_name, (SELECT avatar FROM #__wedding_users wu WHERE wu.user_id = u.id LIMIT 1) AS avatar FROM #__users u WHERE u.block = 0 ORDER BY u.registerDate DESC LIMIT {$limit}";
		$dbo->setQuery($query);
		return $dbo->loadObjectList();
	}
}
