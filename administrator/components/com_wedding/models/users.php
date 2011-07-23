<?php
// no direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model'); 
 
class weddingModelUsers extends JModel
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
			$this->_total = generalHelpers::getTotal('#__users');
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
		$query = "SELECT wu.*, u.username, u.name, u.email, u.block FROM #__wedding_users wu RIGHT JOIN #__users u ON u.id = wu.user_id";
		return $query;
	}
	
	function store()
	{
		$data = JRequest::get('post');
		$row = $this->getTable('users');
		
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
	
	function delete()
	{
		return true;
	}
}
