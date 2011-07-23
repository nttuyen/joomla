<?php 

// No direct access
defined('_JEXEC') or die;

class hpControllerDetail extends hpController
{
	function display()
	{
		$mContent = $this->getModel('detail');
		
		$id = JRequest::getInt('id');

		$row = $mContent->getContentDetail($id);
		
		$row->listNewerContent = array_reverse($mContent->getListContentRelated($id));
		
		$row->listOlderContent = $mContent->getListContentRelated($id, 'older');
		
		$this->_view->display($row);
	}
}