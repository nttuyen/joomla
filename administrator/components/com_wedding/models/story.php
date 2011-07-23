<?php
// no direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model'); 
 
class weddingModelStory extends JModel
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
			$this->_total = generalHelpers::getTotal('#__wedding_stories');
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
		$query = "SELECT s.id, s.title, s.intro, s.featured, u.username FROM #__wedding_stories s JOIN #__users u ON s.user_id = u.id ORDER BY created_date DESC";
		return $query;
	}
	
	function getItem()
	{
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = (int) $cid[0];
		if($id <= 0) return null;
		
		$dbo = & JFactory::getDbo();
		$query = 'SELECT s.id, s.title, s.intro, s.content, s.image, u.username FROM #__wedding_stories s JOIN #__users u ON s.user_id = u.id WHERE s.id = '.$id;
		$dbo->setQuery($query);
		return $dbo->loadObject();
	}
	
	function publish()
	{
		$cid = JRequest::getVar('cid', array(), '', 'array');
		JArrayHelper::toInteger($cid);
		$cids = implode(',', $cid);
		
		$db = & JFactory::getDbo();
		$query = "UPDATE #__wedding_stories SET featured = 1 WHERE id IN ({$cids})";
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
		$query = "UPDATE #__wedding_stories SET featured = 0 WHERE id IN ({$cids})";
		$db->setQuery($query);
		$result = $db->query();
		if(!$result)
		{
			$this->setError($db->getErrorMsg());
			return false;
		}
		return true;
	}
}