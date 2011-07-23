<?php
/**
 * components/com_wedding/views/home/view.html.php
 * @author 		: Phạm Văn An
 * @version 	: 1.0
*/
 
// no direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view'); 
 
class weddingViewAuth extends JView
{
    function display($view, $uri, $profile_id, $app_id, $tpl = null)
    {
    	$this->assignRef('uri', $uri);
    	$this->assignRef('view', $view);
    	$this->assignRef('profile_id', $profile_id);
    	$this->assignRef('app_id', $app_id);
    	parent::display($tpl);
    }
}