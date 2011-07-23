<?php
/**
 * components/com_wedding/views/users/view.html.php
 * @author 		: Phạm Văn An
 * @version 	: 1.0
*/
 
// no direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view'); 
 
class weddingViewStory extends JView
{
    function display($tpl = null)
    {
    	JToolBarHelper::publishList();
    	JToolBarHelper::unpublishList();
    	
    	$model = & $this->getModel();
    	$items = & $model->getItems();
    	$pagination = $model->getPagination();
    	
    	$this->assignRef('items', $items);
    	$this->assignRef('pagination', $pagination);
    	
    	return parent::display($tpl);
    }
    
    function details($tpl = null)
    {
    	JToolBarHelper::back('Quay lại');
    	
    	$model = & $this->getModel();
    	$item = $model->getItem();
    	$this->assignRef('item', $item);
    	
    	return parent::display($tpl);
    }
}