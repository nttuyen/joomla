<?php
/**
 * @file: components/com_wedding/wedding.php
 * @author: Pham Van An
 * @version: 1.0
 */

defined('_JEXEC') or die('Restricted access');

// Require the base controller 
require_once( JPATH_COMPONENT.DS.'controller.php' );
 
// Require specific controller if requested
if($controller = JRequest::getWord('view', 'usercp')) {
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}
 
// Create the controller
$classname    = 'weddingController'.$controller;
$controller   = new $classname();
 
// Perform the Request task
$task = JRequest::getCmd('task');
if(empty($task))
{
	$task = JRequest::getCmd('layout');
}

$controller->execute($task);
 
// Redirect if set by the controller
$controller->redirect();
