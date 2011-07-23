<?php
$user =& JFactory::getUser();
if(!$user->id) return;

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_wedding'.DS.'helpers'.DS.'user.php');
$juser = & JFactory::getUser();
$apps = userHelpers::getApplications($juser->id);
require( JModuleHelper::getLayoutPath('mod_ediapps') );
