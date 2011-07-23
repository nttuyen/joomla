<?php
/**
 * components/com_wedding/views/profile/view.html.php
 * @author 		: Phạm Văn An
 * @version 	: 1.0
*/
 
// no direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view'); 
 
class weddingViewTemplates extends JView
{
    function display($juser, $templates, $user_template, $css, $tpl = null)
    {
    	$this->assignRef('juser', $juser);
    	$this->assignRef('templates', $templates);
    	$this->assignRef('user_template', $user_template);
    	$this->assignRef('css', $css);
    	
    	parent::display($tpl);
    }
}
