<?php 

// No direct access
defined('_JEXEC') or die;

class hpControllerHome extends hpController
{
	function display()
	{
		$mContent = $this->getModel('home');
		
		$cId = JRequest::getInt('category_id');
		
		$categoryInfo = $mContent->getCategoryInfo($cId);
		
		//print_r($categoryInfo);
		
		$pagination = null;

		if(!$cId || $categoryInfo->parent_id == 1)
		{
			$listCategories = $mContent->getIndexCategories($cId);
			
			foreach ($listCategories as & $c)
			{
				
				$c->listContent = $mContent->getListContent($c->id, 0, 3);
				$c->listSubIndexCates = $mContent->getSameLevelCategory($c->parent_id, $c->id);
				
			}
			
			$rows->listCategories = $listCategories;
			
			$rows->show_index = 1;
		}			
		else
		{
			$limit = 10;
			$limitstart	= JRequest::getInt('start');
	
			// In case limit has been changed, adjust limitstart accordingly
			$limitstart = ( $limit != 0 ? (floor($limitstart / $limit) * $limit) : 0 );
		
			$total = $mContent->getTotalContent($cId);
			
			// Create the pagination object
			//jimport('joomla.html.pagination');
			require_once(JPATH_ROOT . DS . 'libraries/joomla/html/hp_content_pagination.php');
			$pagination = new JPagination_HpContent($total, $limitstart, $limit);
			
			$testObj = new stdClass();
			
			$listCategories = array($testObj);
			
			foreach ($listCategories as & $c)
			{				
				$c->listContent = $mContent->getListContent($cId, $limitstart, $limit);				
			}
			
			$rows->listCategories = $listCategories;
			
			$rows->show_index = 0;
			
			$rows->categoryInfo = $mContent->getCategoryInfo($cId);
			
			//print_r($rows->categoryInfo);
			
			//$rows->listContent = $mContent->getListContent($cId, $limitstart, $limit);
		}
		
		//print_r($row);
		
		$this->_view->display($rows, $pagination);
	}
}
