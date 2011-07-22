<?php
/**
 * aPoll Voting Component
 *
 * @version     $Id$
 * @package     Joomla
 * @copyright   Copyright (C) 2009 - 2010 aFactory. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// No Direct Access
defined( '_JEXEC' ) or die;

class JElementApoll extends JElement
{

	var	$_name = 'Apoll';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$db =& JFactory::getDBO();
                
		$query = 'SELECT a.id, a.title'
		. ' FROM ' . $db->nameQuote("#__apoll_polls") . ' AS a'
		. ' WHERE a.published = 1'
		. ' ORDER BY a.title'
		;
		$db->setQuery( $query );
		$options = $db->loadObjectList();
          
        if(JRequest::getCmd('option') == "com_modules") {
            array_unshift($options, JHTML::_('select.option', '', '- - - - - - - - - - -', 'id', 'title'));  
            array_unshift($options, JHTML::_('select.option', '0', JText::_('Show random poll'), 'id', 'title'));        
        } else {
            array_unshift($options, JHTML::_('select.option', '0', '- - '.JText::_('Select Poll').' - -', 'id', 'title'));  
        }

		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="inputbox"', 'id', 'title', $value, $control_name.$name );
	}
}
