<?php
/**
 * components/com_wedding/views/users/view.html.php
 * @author 		: Phạm Văn An
 * @version 	: 1.0
*/
 
// no direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view'); 
 
class weddingViewAlbum extends JView
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
}