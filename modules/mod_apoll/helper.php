<?php
/**
 * aPoll Voting Component
 *
 * @version     $Id: helper.php 157 2011-02-20 20:36:00Z harrygg $
 * @package     Joomla
 * @copyright   Copyright (C) 2009 - 2010 aFactory. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// No Direct Access
defined( '_JEXEC' ) or die;

class modApollHelper
{

        /**
         * function to check if there is a cookie from previous votes
         *
         * @param <int> $poll_id
         * @return boolean $voted
         */
        function hasVoted($poll_id) {

		$cookieName = JUtility::getHash( 'com_apoll' . $poll_id );
		$voted      = JRequest::getInt( $cookieName, '0', 'COOKIE');

		return $voted;
	}

        /**
         * function to get the ids of all published polls
         *
         * @return <array> active polls
         */
        public function getActivePolls() {
            $db    = JFactory::getDBO();
            $query = $db->getQuery(true);
            $query->select('id');
            $query->from('#__apoll_polls');
            $query->where('state = 1');
            $db->setQuery($query);

            if ($ids = $db->loadResultArray()) {
                return $ids;
            } else {
                return false;
            }
        }

}
