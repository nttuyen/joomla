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

// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

$tabclass_arr = array ('sectiontableentry2', 'sectiontableentry1');

$details = "";

$poll_id = $params->get( 'poll_id', 0 );
//if Show random poll is selected
if (!$poll_id) {
    $ids = modApollHelper::getActivePolls();

    if (count($ids) > 1) {
        $poll_id = $ids[array_rand($ids)];
    } else {
        $poll_id = $ids[0];
    }
}

//get the component params
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_apoll'.DS.'tables');
$poll = JTable::getInstance('poll', 'ApollTable');
$poll->load( $poll_id );

$registry = new JRegistry;
$registry->loadJSON($poll->params);
$params->merge($registry);

//reset the var display_poll
$display_poll = false;

//check the start time and the end of poll
$date = JFactory::getDate();
//$date->setOffset($mainframe->getCfg('offset'));
$now   = $date->toFormat();

if(($now > $poll->publish_up) && ($now < $poll->publish_down)) {

    $display_submit = true;

    // if only registered users can vote and the user is a guest
    $user = JFactory::getUser();
    // if the poll is private and the user is guest
    if (!$params->get('public_voting') && $user->guest) {

        //display message please log in
        $display_poll = true;
        $display_submit = false;
        $msg = "MOD_APOLL_ERR_PLS_REGISTER";

    //if the poll is public
    } else {
        //if user has voted, according to the cookie check
        if( modApollHelper::hasVoted($poll_id) ) {
            //display the poll with disabled options or the results
            $display_poll = false;
            $display_submit = false;
            $msg = "MOD_APOLL_ERR_COOKIE";
        //if user has not voted according to the cookie
        } else {
            //display the poll
            $display_poll = true;
            $display_submit = true;
            $msg = null;
	}
    }

//if the poll hasn't started yet
} else {
    $display_submit = false;
    $display_poll = true;
    $msg = "MOD_APOLL_ERR_POLL_NOT_STARTED";
}
//if deadline has passed change the msg
if( $now > $poll->publish_down) {
    $display_poll = false;
    $msg = "MOD_APOLL_ERR_POLL_HAS_EXPIRED";
}
// and the disable option
$disabled = ($display_submit) ? '' : 'disabled = "disabled"';

if ( $poll && $poll->id ) {

    $layout = JModuleHelper::getLayoutPath('mod_apoll');
    $tabcnt = 0;
    //get the component params
    require_once(JPATH_SITE.DS.'components'.DS.'com_apoll'.DS.'models'.DS.'poll.php');
    $model = new ApollModelPoll();
    $options = $model->getOptions($poll_id);
    $total_votes = $model->getTotal_votes();

    require($layout);
}