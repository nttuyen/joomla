<?php
/**
 * components/com_wedding/controller.php
 @author 		: Phạm Văn An
 @version 		: 1.0
 */
 
// No direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
class weddingController extends JController
{    
	var $_view;
	var $_model;
	
	function __construct($view)
	{
		parent::__construct();		
		$docs = & JFactory::getDocument();
		$type = $docs->getType();		
		$this->_view = & $this->getView($view, $type);
		$this->_model = & $this->getModel($view);
		
		$this->_view->setModel($this->_model, true);	
		$this->registerTask('add', 'edit');
		
		require_once(JPATH_COMPONENT.DS.'helpers'.DS.'wedding.php');
		weddingHelper::addSubmenu($view);
	}
	
	function display()
	{
		$this->_view->display();
	}
	
	function edit()
	{
		$this->_view->setLayout('edit');
		$this->_view->edit();		
	}
	
	function apply()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$c = JRequest::getCmd('view');
		$o = JRequest::getCmd('option');
		
		$result = $this->_model->store();
		$apply_id = JRequest::getInt('apply_id');
		$link = 'index.php?option='.$o.'&view='.$c.'&task=edit&cid[]='.$apply_id;
				
		if($result)
		{
			$this->setRedirect($link, JText::_('SAVE_SUCCESS'));
		}
		else
		{
			JError::raiseWarning('SAVE_FAILURE', $this->_model->getError());
			$this->setRedirect($link);
		}
	}
	
	function save()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$c = JRequest::getCmd('view');
		$o = JRequest::getCmd('option');
		$result = $this->_model->store();
		if($result)
		{
			$this->setRedirect('index.php?option='.$o.'&view='.$c, JText::_('SAVE_SUCCESS'));
		}
		else
		{
			JError::raiseWarning('SAVE_FAILURE', $this->_model->getError());
			$this->setRedirect('index.php?option='.$o.'&view='.$c);
		}
	}
	
	function remove()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$c = JRequest::getCmd('view');
		$o = JRequest::getCmd('option');
		$result = $this->_model->delete();
		if($result)
		{
			$this->setRedirect('index.php?option='.$o.'&view='.$c, JText::_('DELETE_SUCCESS'));
		}
		else
		{
			JError::raiseWarning('DELETE_FAILURE', $this->_model->getError());
			$this->setRedirect('index.php?option='.$o.'&view='.$c);
		}
	}
	
	function cancel()
	{
		$c = JRequest::getCmd('view');
		$o = JRequest::getCmd('option');
		$this->setRedirect('index.php?option='.$o.'&view='.$c, JText::_('OPERATION_CANCELED'));
	}
	
	function orderup()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$c = JRequest::getCmd('view');
		$o = JRequest::getCmd('option');
		
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$result = $this->_model->order($cid[0], -1);
		if($result)
		{
			$msg = JText::_('ORDERUP_SUCCESS');
			$this->setRedirect('index.php?option='.$o.'&view='.$c, $msg);
		}
		else
		{
			JError::raiseWarning('ORDERUP_FAILURE', $this->_model->getError());
			$this->setRedirect('index.php?option='.$o.'&view='.$c);
		}
	}
	
	function orderdown()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$c = JRequest::getCmd('view');
		$o = JRequest::getCmd('option');
		
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$result = $this->_model->order($cid[0], 1);
		if($result)
		{
			$msg = JText::_('ORDERDOWN_SUCCESS');
			$this->setRedirect('index.php?option='.$o.'&view='.$c, $msg);
		}
		else
		{
			JError::raiseWarning('ORDERDOWN_FAILURE', $this->_model->getError());
			$this->setRedirect('index.php?option='.$o.'&view='.$c);
		}
	}
	
	function publish()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$c = JRequest::getCmd('view');
		$o = JRequest::getCmd('option');
		
		$result = $this->_model->publish();
		if($result)
		{
			$msg = JText::_('PUBLISH_SUCCESS');
			$this->setRedirect('index.php?option='.$o.'&view='.$c, $msg);
		}
		else
		{
			JError::raiseWarning('PUBLISH_FAILURE', $this->_model->getError());
			$this->setRedirect('index.php?option='.$o.'&view='.$c);
		}
	}
	
	function unpublish()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$c = JRequest::getCmd('view');
		$o = JRequest::getCmd('option');
		
		$result = $this->_model->unpublish();
		if($result)
		{
			$msg = JText::_('UNPUBLISH_SUCCESS');
			$this->setRedirect('index.php?option='.$o.'&view='.$c, $msg);
		}
		else
		{
			JError::raiseWarning('UNPUBLISH_FAILURE', $this->_model->getError());
			$this->setRedirect('index.php?option='.$o.'&view='.$c);
		}
	}
	
	function saveorder()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$c = JRequest::getCmd('view');
		$o = JRequest::getCmd('option');
		
		$result = $this->_model->saveorder();
		if($result)
		{
			$msg = JText::_('SAVE_ORDER_SUCCESS');
			$this->setRedirect('index.php?option='.$o.'&view='.$c, $msg);
		}
		else
		{
			JError::raiseWarning('SAVE_ORDER_FAILURE', $this->_model->getError());
			$this->setRedirect('index.php?option='.$o.'&view='.$c);
		}
	}
	
	function setdefault()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$c = JRequest::getCmd('view');
		$o = JRequest::getCmd('option');
		
		$result = $this->_model->setdefault();
		if($result)
		{
			$msg = JText::_('SET_DEFAULT_SUCCESS');
			$this->setRedirect('index.php?option='.$o.'&view='.$c, $msg);
		}
		else
		{
			JError::raiseWarning('SET_DEFAULT_FAILURE', $this->_model->getError());
			$this->setRedirect('index.php?option='.$o.'&view='.$c);
		}
	}
}
