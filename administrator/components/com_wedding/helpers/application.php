<?php
class applicationHelpers
{
	function getApplication($id)
	{
		if(empty($id)) return null;
		
		$db = & JFactory::getDbo();
		$query = "SELECT * FROM #__wedding_apps WHERE id = {$id}";
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	function getAllApplication()
	{
		$db = & JFactory::getDbo();
		$query = "SELECT * FROM #__wedding_apps WHERE published = 1 ORDER BY ordering";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	
	function getAppsId()
	{
		$db = & JFactory::getDbo();
		$query = "SELECT id FROM #__wedding_apps WHERE published = 1 ORDER BY ordering";
		$db->setQuery($query);
		return $db->loadResultArray();
	}
}