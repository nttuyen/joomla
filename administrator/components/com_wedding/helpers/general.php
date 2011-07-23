<?php
defined('_JEXEC') or die;

class generalHelpers
{
	function getTotal($table, $count_field = 'id', $where = '')
	{
		if($where)
			$where = 'WHERE '.$where;
		$db = & JFactory::getDbo();
		$query = "SELECT COUNT({$count_field}) FROM {$table} {$where} LIMIT 1";
		$db->setQuery($query);
		$result = $db->loadResult();
		
		if(empty($result)) return 0;
		return $result;
	}
	
	function getMaxOrder($table, $where = '', $field = 'ordering')
	{
		if($where)
			$where = 'WHERE '.$where;
		$db = & JFactory::getDbo();
		$query = "SELECT MAX({$field}) FROM {$table} {$where}";
		$db->setQuery($query);
		return $db->loadResult();
	}
	
	function getUserId($username)
	{
		$db = & JFactory::getDbo();
		$query = "SELECT id FROM #__users WHERE username = '{$username}' LIMIT 1";
		$db->setQuery($query);
		return $db->loadResult();
	}
}