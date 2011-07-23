<?php

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML Article View class for the Content component
 *
 * @package		Joomla.Site
 * @subpackage	com_content
 * @since		1.5
 */
class hpViewDetail extends JView
{
	function display($row = null, $tpl = null)
	{
		$this->assignRef('row', $row);
		
		parent::display($tpl);
	}
}