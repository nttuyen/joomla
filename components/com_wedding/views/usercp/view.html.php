<?php
/**
 * components/com_wedding/views/profile/view.html.php
 * @author 		: Phạm Văn An
 * @version 	: 1.0
*/
 
// no direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view'); 
 
class weddingViewUsercp extends JView
{
    function display($juser, $apps, $tpl = null)
    {
    	$this->assignRef('juser', $juser);
    	$this->assignRef('apps', $apps);
    	
    	parent::display($tpl);
    }
}
