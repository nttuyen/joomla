<?php
defined('_JEXEC') or die;

class templateHelpers
{
	function getTemplate($id)
	{
		if(empty($id)) return self::getDefault();
		
		$db = & JFactory::getDbo();
		$query = "SELECT * FROM #__wedding_templates WHERE id = {$id} AND published = 1 LIMIT 1";
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	function getDefault()
	{
		$db = & JFactory::getDbo();
		$query = "SELECT * FROM #__wedding_templates WHERE is_default = 1 AND published = 1 LIMIT 1";
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	function getAllTemplates()
	{
		$db = & JFactory::getDbo();
		$query = "SELECT * FROM #__wedding_templates WHERE published = 1";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	
	function getTemplateId()
	{
		$db = & JFactory::getDbo();
		$query = "SELECT id FROM #__wedding_templates WHERE published = 1";
		$db->setQuery($query);
		return $db->loadResultArray();
	}
}
