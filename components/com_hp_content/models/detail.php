<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

class hpModelDetail extends JModelItem
{
	function getContentDetail($id)
	{
		$query = "SELECT * FROM #__content c WHERE state = 1 AND id = '$id'";		
		$result = mainHelper::getDbObjResult($query);
		
		return $result[0];
	}
	
	function getListContentRelated($id, $type = 'newer', $limit = 10)
	{
		if($type == 'newer')
		{
			$operation = '>';
			$order = 'ASC';
		}
		else
		{
			$operation = '<';
			$order = 'DESC';
		}
			
			
		$query = "SELECT * FROM #__content c WHERE state = 1 AND catid = (SELECT catid FROM #__content WHERE id = $id) AND id $operation $id ORDER BY id $order LIMIT $limit";
		
		$result = mainHelper::getDbObjResult($query);
		
		return $result;
	}
}