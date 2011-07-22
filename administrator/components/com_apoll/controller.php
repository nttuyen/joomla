<?php
/**
 * aPoll Voting Component
 *
 * @version     $Id: controller.php 111 2010-10-16 09:20:06Z harrygg $
 * @package     Joomla
 * @copyright   Copyright (C) 2009 - 2010 aFactory. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

/**
 * @package		Joomla
 * @subpackage	aPoll
 */
class ApollController extends JController
{

    //protected $default_view = 'polls';
    /**
     * display task
     *
     * @return void
     */
    function display($cachable = false, $urlparams = false)
    {
        require_once JPATH_COMPONENT.DS.'helpers'.DS.'apoll.php';

        // Load the submenu.
        ApollHelper::addSubmenu(JRequest::getWord('view', 'polls'));

            $view		= JRequest::getWord('view', 'polls');
            $layout 	= JRequest::getWord('layout', 'default');
            $id			= JRequest::getInt('id');

            // Check for edit form.
            if ($view == 'poll' && $layout == 'edit' && !$this->checkEditId('com_apoll.edit.poll', $id)) {
                // Somehow the person just went to the form - we don't allow that.
                $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
                $this->setMessage($this->getError(), 'error');
                $this->setRedirect(JRoute::_('index.php?option=com_apoll&view=polls', false));

                return false;
            }
        // set the default view to 'polls', because otherwise it will be 'apoll'
        $this->default_view = "polls";
        parent::display();

        return $this;
    }
}