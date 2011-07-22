<?php

defined('_JEXEC') or die;

class ApollHelper
{
    /**
     * Configure the Linkbar.
     *
     * @param    string    The name of the active view.
     */
    public static function addSubmenu($vName)
    {
        JSubMenuHelper::addEntry(
            JText::_('COM_APOLL_POLLS'),
            'index.php?option=com_apoll&view=polls',
            $vName == 'polls'
        );

        JSubMenuHelper::addEntry(
            JText::_('JCATEGORIES'),
            'index.php?option=com_categories&extension=com_apoll',
            $vName == 'categories'
        );

        if ($vName=='categories') {
                JToolBarHelper::title(
                        JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE', JText::_('com_apoll')),
                        'apoll-categories');
        }
		
    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @param    int        The category id.
     * @return    JObject
     */
    public static function getActions($categoryId = 0)
    {
        $user    = JFactory::getUser();
        $result    = new JObject;

        if (empty($categoryId)) {
            $assetName = 'com_apoll';
        } else {
            $assetName = 'com_apoll.category.'.(int) $categoryId;
        }

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action,    $user->authorise($action, $assetName));
        }

        return $result;
    }
}