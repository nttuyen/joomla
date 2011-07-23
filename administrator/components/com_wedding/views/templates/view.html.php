<?php
/**
 * components/com_wedding/views/templates/view.html.php
 * @author 		: Phạm Văn An
 * @version 	: 1.0
*/
 
// no direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view'); 
 
class weddingViewTemplates extends JView
{
    function display($tpl = null)
    {
    	JToolBarHelper::addNew();
    	JToolBarHelper::editListX();
    	JToolBarHelper::publishList();
    	JToolBarHelper::unpublishList();
    	JToolBarHelper::deleteListX(JText::_('COM_WEDDING_DELETE_APPS_CONFIRM'));
    	
    	$model = & $this->getModel();
    	$items = & $model->getItems();
    	$pagination = $model->getPagination();
    	
    	$this->assignRef('items', $items);
    	$this->assignRef('pagination', $pagination);
    	
    	parent::display($tpl);
    }
    
    function edit($tpl = null)
    {
    	JToolBarHelper::save();
    	JToolBarHelper::apply();
    	JToolBarHelper::cancel();
    	
    	$cid = JRequest::getVar('cid', array(0), '', 'array');
    	JArrayHelper::toInteger($cid);
    	$id = $cid[0];
    	if($id <= 0) $item = null;    	
    	else
    	{
    		require_once(JPATH_COMPONENT.DS.'helpers'.DS.'template.php');
    		$item = templateHelpers::getTemplate($id);
    	}
    	
    	$this->assignRef('item', $item);
    	
    	parent::display($tpl);
    }
}