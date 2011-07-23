<?php
// no direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model'); 
 
class weddingModelApps extends JModel
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
			$this->_total = generalHelpers::getTotal('#__wedding_apps');
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
		$query = "SELECT * FROM #__wedding_apps ORDER BY ordering ASC";
		return $query;
	}
	
	function store()
	{
		$data = JRequest::get('post');
		if( !isset($data['id']) )
		{
			require_once(JPATH_COMPONENT.DS.'helpers'.DS.'general.php');
			$data['ordering'] = generalHelpers::getMaxOrder('#__wedding_apps') + 1;
		}
		$row = $this->getTable('apps');
		
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
	
	function saveorder()
	{
		$cid = JRequest::getVar('cid', array(), '', 'array');
		$order = JRequest::getVar('order', array(), '', 'array');
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);
		
		$row = & $this->getTable('apps');
		foreach ($cid as $key => $id)
		{
			$row->load($id);
			$row->ordering = $order[$key];
			
			if( !$row->store() )
			{
				$this->setError( $row->getError() );
				return false;
			}
		}
		$row->reorder();
		
		return true;
	}
	
	function order($id, $delta)
	{
		$row = & $this->getTable('apps');
		$row->load($id);
		$result = $row->move($delta);
		if($result===true)
			return true;
		else
		{
			$this->setError( $row->getError() );
			return false;
		}
	}
	
	function publish()
	{
		$cid = JRequest::getVar('cid', array(), '', 'array');
		JArrayHelper::toInteger($cid);
		$cids = implode(',', $cid);
		
		$db = & JFactory::getDbo();
		$query = "UPDATE #__wedding_apps SET published = 1 WHERE id IN ({$cids})";
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
		$query = "UPDATE #__wedding_apps SET published = 0 WHERE id IN ({$cids})";
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
		$row = & $this->getTable('apps');
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
		
		$query = "UPDATE #__wedding_apps SET is_default = 0 WHERE is_default = 1";
		$db->setQuery($query);
		$r = $db->query();		
		if(!$r)
		{
			$this->setError($db->getErrorMsg());
			return false;
		}
		
		$query = "UPDATE #__wedding_apps SET is_default = 1 WHERE id = {$cid[0]}";
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
