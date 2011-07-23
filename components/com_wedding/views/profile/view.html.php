<?php
/**
 * components/com_wedding/views/profile/view.html.php
 * @author 		: Phạm Văn An
 * @version 	: 1.0
*/
 
// no direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view'); 
 
class weddingViewProfile extends JView
{
    function display($juser, $cuser, $tpl = null)
    {
    	$this->assignRef('juser', $juser);
    	$this->assignRef('cuser', $cuser);
    	
    	parent::display($tpl);
    }
}
