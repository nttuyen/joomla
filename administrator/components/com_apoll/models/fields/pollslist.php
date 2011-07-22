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

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldPollsList extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'PollsList';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	public function getOptions()
	{
		// Initialize variables.
		$options = array();

		$db     = JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('id AS value, title AS text');
		$query->from('#__apoll_polls');
                $query->where('state = 1');
		$query->order('id');

		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

                if(JRequest::getCmd('option') == "com_modules") {
                    array_unshift($options, JHTML::_('select.option', '', '- - - - - - - - - - -', 'value', 'text'));
                    array_unshift($options, JHTML::_('select.option', '0', JText::_('COM_APOLL_SHOW_RANDOM_POLL'), 'value', 'text'));
                } else {
                    array_unshift($options, JHTML::_('select.option', '0', '- - '.JText::_('COM_APOLL_SELECT_POLL').' - -', 'value', 'text'));

                }
                    return $options;
          }

}
