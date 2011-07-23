<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

class hpModelHome extends JModelItem
{
	function getListContent($categoryId = 0, $limitStart = 0, $limit = 10)
	{
		$query = "SELECT * FROM #__content c WHERE state = 1";
		
		if($categoryId)
			$query .= " AND (catid = '$categoryId' OR catid IN (SELECT id FROM #__categories WHERE parent_id = '$categoryId'))";
		
		$query .= " ORDER BY id DESC ";
		
		if($limit)
			$query .= "LIMIT $limitStart, $limit";
			
		return mainHelper::getDbObjResult($query);
	}
	
	function getTotalContent($categoryId)
	{
		$query = "	SELECT COUNT(*) AS count_content FROM #__content 
					WHERE (catid = '$categoryId' OR catid IN (SELECT id FROM #__categories WHERE parent_id = '$categoryId')) AND state = 1
				";
		
		$result = mainHelper::getDbObjResult($query);
		
		return $result[0]->count_content;
	}
	
	function getIndexCategories($cId = null)
	{
		if($cId)
			$queryMore = " AND parent_id = '$cId' ";
		else
			$queryMore = " AND featured = 1 ";
			
		$query = "SELECT * FROM #__categories WHERE published = 1 $queryMore AND extension = 'com_content' ORDER BY id DESC";
		$result = mainHelper::getDbObjResult($query);
		
		//echo '<pre>';print_r($result); die;
		
		return $result;
	}
	
	function getCategoryInfo($cId)
	{
		$query = "SELECT * FROM #__categories WHERE id = '$cId'";
		$result = mainHelper::getDbObjResult($query);
		
		return $result[0];
	}
	
	function getSameLevelCategory($parentId = null, $currentId = null)
	{
		if(!$parentId) return false;
		
		$query = "	SELECT * 
					FROM #__categories 
					WHERE parent_id = '$parentId' AND id != '$currentId' AND published = 1  AND extension = 'com_content'
					ORDER BY id DESC 
					LIMIT 3";
		
		$result = mainHelper::getDbObjResult($query);
		
		return $result;
	}
}
