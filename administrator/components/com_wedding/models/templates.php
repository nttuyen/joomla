<?php
// no direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model'); 
 
class weddingModelTemplates extends JModel
{
	var $_data = null;
	var $_pagination = null;
	var $_total = null;
	
	function getItems()
	{
		if( empty( $this->_data ) )
		{
			$limit = 20;
			$limitstart = JRequest::getInt('limitstart');
			$query = $this->_buildQuery();
            $this->_data = $this->_getList($query, $limitstart, $limit); 
		}
		return $this->_data;
	}
	
	function getTotal()
	{
		if(empty($this->_total))
		{
			require_once(JPATH_COMPONENT.DS.'helpers'.DS.'general.php');
			$this->_total = generalHelpers::getTotal('#__wedding_templates');
		}
	}
	
	function getPagination()
	{
        if( empty( $this->_pagination ) )
        {
            jimport( 'joomla.html.pagination' );
            $this->_pagination = new JPagination($this->getTotal(), $limitstart, $limit );
        }
        return $this->_pagination;
	}
	
	function _buildQuery()
	{		
		$query = "SELECT * FROM #__wedding_templates ORDER BY title";
		return $query;
	}
	
	function store()
	{
		$data = JRequest::get('post');
		$row = $this->getTable('templates');
		
		if( !$row->bind($data) )
		{
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}
		
		if( !$row->store() )
		{
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}
		
		JRequest::setVar('apply_id', $row->id);
		
		return true;
	}
	
	function publish()
	{
		$cid = JRequest::getVar('cid', array(), '', 'array');
		JArrayHelper::toInteger($cid);
		$cids = implode(',', $cid);
		
		$db = & JFactory::getDbo();
		$query = "UPDATE #__wedding_templates SET published = 1 WHERE id IN ({$cids})";
		$db->setQuery($query);
		$result = $db->query();
		if(!$result)
		{
			$this->setError($db->getErrorMsg());
			return false;
		}
		return true;
	}
	
	function unpublish()
	{
		$cid = JRequest::getVar('cid', array(), '', 'array');
		JArrayHelper::toInteger($cid);
		$cids = implode(',', $cid);
		
		$db = & JFactory::getDbo();
		$query = "UPDATE #__wedding_templates SET published = 0 WHERE id IN ({$cids})";
		$db->setQuery($query);
		$result = $db->query();
		if(!$result)
		{
			$this->setError($db->getErrorMsg());
			return false;
		}
		return true;
	}
	
	function delete()
	{
		$cid = JRequest::getVar('cid', array(), '', 'array');
		JArrayHelper::toInteger($cid);
		$row = & $this->getTable('templates');
		foreach ($cid as $key => $id)
		{
			$row->load($id);
			
			if( !$row->delete() )
			{
				$row->reorder();
				$this->setError( $row->getError() );
				return false;
			}
		}
		$row->reorder();
		return true;
	}
	
	function setdefault()
	{
		$post = JRequest::get('post');
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		JArrayHelper::toInteger($cid);
		$db = & JFactory::getDbo();
		
		$query = "UPDATE #__wedding_templates SET is_default = 0 WHERE is_default = 1";
		$db->setQuery($query);
		$r = $db->query();		
		if(!$r)
		{
			$this->setError($db->getErrorMsg());
			return false;
		}
		
		$query = "UPDATE #__wedding_templates SET is_default = 1 WHERE id = {$cid[0]}";
		$db->setQuery($query);
		$r = $db->query();		
		if(!$r)
		{
			$this->setError($db->getErrorMsg());
			return false;
		}
		return true;
	}
}
