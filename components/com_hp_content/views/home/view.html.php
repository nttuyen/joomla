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
class hpViewHome extends JView
{
	function display($rows = null, $pagination = null, $tpl = null)
	{
		$this->assignRef('row', $rows);
		
		$this->assignRef('pagination', $pagination);
		
		parent::display($tpl);
	}
}