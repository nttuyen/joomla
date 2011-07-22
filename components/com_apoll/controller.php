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

jimport('joomla.application.component.controller');

class ApollController extends JController
{
    function display()
    {
        // Get the document object.
        $document = JFactory::getDocument();

        // Set the default view name and format from the Request.
        $vName        = JRequest::getWord('view', 'categories');
        $vFormat      = $document->getType();
        $lName        = JRequest::getWord('layout', 'default');

        // Get and render the view.
        if ($view     = $this->getView($vName, $vFormat))
        {
            $model    = $this->getModel($vName);


            // Push the model into the view (as default).
            $view->setModel($model, true);
            $view->setLayout($lName);

            // Push document object into the view.
            $view->assignRef('document', $document);

            $view->display();
        }
    }

	/**
 	 * Vote for an option
 	 */
	function vote()
	{
            //global $mainframe;

            // Check for request forgeries
            JRequest::checkToken() or jexit( 'Invalid Token' );

            $db		= JFactory::getDBO();
            $poll_id	= JRequest::getInt( 'id' );
            $option_id	= JRequest::getInt( 'option_id' );
            $poll 	= JTable::getInstance('apoll','Table');

            if (!$poll->load( $poll_id ) || $poll->published != 1) {
                    JError::raiseWarning( 404, JText::_('ALERTNOTAUTH') );
                    return;
            }

            $cookieName	= JUtility::getHash( $mainframe->getName() . 'apoll' . $poll_id );
            $voted = JRequest::getVar( $cookieName, '0', 'COOKIE', 'INT');

            if ($voted || !$option_id )
            {
                    if($voted) {
                    $msg = JText::_('You already voted for this poll!');
                    $tom = "error";
                    }

                    if(!$option_id){
                            $msg = JText::_('WARNSELECT');
                            $tom = "error";
                    }
            }
            else
            {
                require_once(JPATH_COMPONENT.DS.'models'.DS.'apoll.php');
                $model = new ApollModelApoll();
                if ( $model->vote( $poll_id, $option_id )) {
        //Set cookie showing that user has voted
        setcookie( $cookieName, '1', time() + 60*$poll->lag );
        }

                    $msg = JText::_( 'Thanks for your vote!' );
                    $tom = "";
            }

            // set Itemid id for links
            $menu	 = &JSite::getMenu();
            $items   = $menu->getItems('link', 'index.php?option=com_apoll&view=apoll');

            $itemid  = isset($items[0]) ? '&Itemid='.$items[0]->id : '';

            $this->setRedirect( JRoute::_('index.php?option=com_apoll&view=apoll&id='. $poll_id.':'.$poll->alias.$itemid, false), $msg, $tom);
    }

}
?>