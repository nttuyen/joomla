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

/**
 * Supports an HTML select list of categories
 *
 * @package		Joomla.Administrator
 * @subpackage	com_apoll
 * @since		1.6
 */
class JFormFieldOrdering extends JFormField
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Ordering';

	/**
	 * Method to get the field input.
	 *
	 * @return	string		The field input.
	 */
	protected function getInput()
	{
        // Initialize variables.
        $html = array();
        $attr = '';

        // Initialize some field attributes.
        $attr .= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
        $attr .= ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';
        $attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';

        // Initialize JavaScript field attributes.
        $attr .= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';

        // Get some field values from the form.
        $pollId    = (int) $this->form->getValue('id');
        $categoryId    = (int) $this->form->getValue('catid');

        // Build the query for the ordering list.
        $query        = 'SELECT ordering AS value, title AS text'
                    . ' FROM #__apoll_polls'
                    . ' WHERE catid = ' . $categoryId
                    . ' ORDER BY ordering';

        // Create a read-only list (no name) with a hidden input to store the value.
        if ((string) $this->element['readonly'] == 'true') {
            $html[] = JHtml::_('list.ordering', '', $query, trim($attr), $this->value, $pollId ? 0 : 1);
            $html[] = '<input type="hidden" name="'.$this->name.'" value="'.$this->value.'"/>';
        }
        // Create a regular list.
        else {
            $html[] = JHtml::_('list.ordering', $this->name, $query, trim($attr), $this->value, $pollId ? 0 : 1);
        }

        return implode($html);
	}
}