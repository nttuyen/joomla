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

jimport('joomla.application.component.modelitem');

/**
* @package		Joomla
* @subpackage	aPoll
*/
class ApollModelPoll extends JModelItem
{    
	/**
	 * Model context string.
	 *
	 * @var		string
	 */
	protected $_context = 'com_apoll.poll';

        protected $total_votes = 0;
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
    protected function populateState()
    {
            $app = JFactory::getApplication('site');

            // Load state from the request.
            $poll_id = JRequest::getInt('poll_id');
            $this->setState('poll.id', $poll_id);

            // Load the parameters.
            $params = $app->getParams();
            $this->setState('params', $params);

    }
    /**
     * Method to get the options for current poll.
     * The query selects * from options table
     * and calculates total_votes and percent
     *
     * @return   array      Array of poll options 
     * 
     */

    function getOptions($poll_id = 0)
    {
        //if poll_id > 0 then the request is comming from the module
        //else it's comming from the view
        $poll_id = ($poll_id) ? $poll_id : $this->getState('poll.id');
        // Get options and votes for this poll
        $query = $this->_db->getQuery(true);
        $query->select('*');
        $query->from('#__apoll_options');
        $query->where('poll_id = ' . $poll_id);
        $query->order('ordering');

        $this->_db->setQuery((string)$query);
        $options = $this->_db->loadObjectList();

        // Check for a database error.
        if ($this->_db->getErrorNum()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        //count total_votes
        foreach ($options as $option) {
            $this->total_votes += $option->votes;
        }

        //DEBUG
        //print_r($options); exit;
        return $options;

    }

    function getTotal_votes() {
        return $this->total_votes;
    }
     /**
     * Add vote to the options table
     */
    function getVote()
    {
        $poll_id    = $this->getState('poll.id');

        //get all params if poll is published
        //if not return error
        if(!($params = $this->getPollParams($poll_id))) {
            $this->setError('MOD_APOLL_ERR_POLL_NOT_PUBLISHED');
            return false;
        }
        //check cookies for previous votes

        //get poll params for check if poll is only for registrated users
        jimport( 'joomla.registry.registry' );
        $registry = new JRegistry;
        $registry->loadJSON($params);
        $params = $registry;

        //check if the poll is only for registered users
        if($params->get('only_registered')) {
            $user = JFactory::getUser();

            if($user->guest) {
                $this->setError('MOD_APOLL_ERR_NOT_REGISTERED');
                //skip the voting
                return true;
            }
        //ok the poll is not for registered users only
        //then check for cookies
        } else {

            $cookieName	= JUtility::getHash( 'com_apoll' . $poll_id );
            //if cookie exists exit with error
            if(JRequest::getInt( $cookieName )) {
                $this->setError('MOD_APOLL_ERR_COOKIE');
                //skip the voting
                return true;
            }
        }

        //if none of the checks failed VOTE and set the cookie
        if($this->storeVote($cookieName, $params->get('lag'))) {
            return true;
        }
        return false;
    }

    /**
     * function to store the votes for options
     */
    function storeVote($cookieName, $lag) {

        $option_id  = JRequest::getInt('apoll_option');

        $query = $this->_db->getQuery(true);
        $query->update('#__apoll_options');
        $query->set('votes = (votes + 1)');
        $query->where('id = ' . $option_id);

        $query = $this->_db->setQuery((string)$query);
        $this->_db->query();

        // Check for a database error.
        if ($this->_db->getErrorNum()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        //Set cookie showing that user has voted
        setcookie( $cookieName, '1', time() + 3600 * $lag );

        return true;
    }
    /**
     * function to get the params for current poll
     *
     * @param int $poll_id
     * @return string $params the json string of poll parameters
     */
    private function getPollParams($poll_id) {

        $query = $this->_db->getQuery(true);
        $query->select('params ');
        $query->from(' #__apoll_polls ');
        $query->where(' id = ' . $poll_id . ' AND state=1 ');
        
        $query = $this->_db->setQuery((string)$query);
  
        $params = $this->_db->loadObject();

        // Check for a database error.
        if ($this->_db->getErrorNum()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        return ($params) ? $params->params : 0;
    }
}