<?php
defined('_JEXEC') or die;

class weddingHelper
{
	public static $extention = 'com_content';
	
	function addSubmenu($vname)
	{
		$name = JText::_('COM_WEDDING_USERS');
		$link = 'index.php?option=com_wedding&view=users';
		JSubMenuHelper::addEntry($name, $link, $vname=='users');
		
		$name = JText::_('COM_WEDDING_APPS');
		$link = 'index.php?option=com_wedding&view=apps';
		JSubMenuHelper::addEntry($name, $link, $vname=='apps');
		
		$name = JText::_('COM_WEDDING_TEMPLATES');
		$link = 'index.php?option=com_wedding&view=templates';
		JSubMenuHelper::addEntry($name, $link, $vname=='templates');
		
		$name = 'Album';
		$link = 'index.php?option=com_wedding&view=album';
		JSubMenuHelper::addEntry($name, $link, $vname=='album');
		
		$name = 'Chuyện tình yêu';
		$link = 'index.php?option=com_wedding&view=story';
		JSubMenuHelper::addEntry($name, $link, $vname=='story');
	}
	
	function getUserTemplate()
	{
		$juser = & JFactory::getUser();
		$profile_id = JRequest::getInt('user_id', $juser->id);
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'user.php');
		return userHelpers::getCurrentTemplate($profile_id);
	}
	
	function getTemplateFolder($folder = 'css', $tmpl = 'default')
	{
		if(!empty($folder))
			$folder .= '/';
		return JURI::base().'components/com_wedding/templates/'.$tmpl.'/'.$folder;
	}
}