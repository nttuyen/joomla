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

jimport( 'joomla.application.component.modellist' );

/**
* @package	aPoll
* @since        1.6
*/
class ApollModelPolls extends JModelList
{
    //protected $_context = 'com_apoll.polls';

    /**
     * Method to auto-populate the model state.
     */
    protected function populateState($ordering = null, $direction = null)
    {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $accessId = $app->getUserStateFromRequest($this->context.'.filter.access', 'filter_access', null, 'int');
        $this->setState('filter.access', $accessId);

        $published = $app->getUserStateFromRequest($this->context.'.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        $categoryId = $app->getUserStateFromRequest($this->context.'.filter.category_id', 'filter_category_id', '');
        $this->setState('filter.category_id', $categoryId);

        $language = $app->getUserStateFromRequest($this->context.'.filter.language', 'filter_language', '');
        $this->setState('filter.language', $language);
                
        // Load the parameters.
        $params = JComponentHelper::getParams('com_apoll');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.title', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param    string        $id    A prefix for the store id.
     *
     * @return    string        A store id.
     */
    protected function getStoreId($id = '')
    {
        // Compile the store id.
        $id    .= ':'.$this->getState('filter.search');
        $id    .= ':'.$this->getState('filter.access');
        $id    .= ':'.$this->getState('filter.state');
        $id    .= ':'.$this->getState('filter.category_id');
        $id    .= ':'.$this->getState('filter.language');      

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return    JQuery
     */
    protected function getListQuery()
    {
        // Create a new query object.
        $db       = $this->getDbo();
        $query    = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select($this->getState('list.select', 'a.*'));
        $query->from('`#__apoll_polls` AS a');

		// Join over the language
		$query->select('l.title AS language_title');
		$query->join('LEFT', '`#__languages` AS l ON l.lang_code = a.language');
		
        // Join over the users for the checked out user.
        $query->select('uc.name AS editor');
        $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

        // Join over the asset groups.
        $query->select('ag.title AS access_level');
        $query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');

        // Join over the categories.
        $query->select('c.title AS category_title');
        $query->join('LEFT', '#__categories AS c ON c.id = a.catid');
        
        // Join over the poll votes.
        $query->select('(SELECT SUM(o.votes) FROM #__apoll_options AS o WHERE o.poll_id = a.id) AS votes');

        // Join over the poll options.
        $query->select('COUNT(o.id) AS options');
        $query->join('LEFT', '#__apoll_options AS o ON o.poll_id = a.id');

        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('a.access = '.(int) $access);
        }

        // Filter by published state
        $published = $this->getState('filter.state');
        if (is_numeric($published)) {
            $query->where('a.state = '.(int) $published);
        } else if ($published === '') {
            $query->where('(a.state IN (0, 1))');
        }

        // Filter by category.
        $categoryId = $this->getState('filter.category_id');
        if (is_numeric($categoryId)) {
            $query->where('a.catid = '.(int) $categoryId);
        }

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = '.(int) substr($search, 3));
            } else {
                $search = $db->Quote('%'.$db->getEscaped($search, true).'%');
                $query->where('a.title LIKE '.$search.' OR a.alias LIKE '.$search);
            }
        }
		
		// Group by 
		$query->group('a.id');
		
        // Add the list ordering clause.
        $query->order($db->getEscaped($this->getState('list.ordering', 'a.ordering')).' '.$db->getEscaped($this->getState('list.direction', 'ASC')));

        //DEBUG
        //echo nl2br(str_replace('#__','jos_',$query)); exit;
        return $query;
    }
    
    
    /**
    * Method to return a list of polls or single poll
    * with the corresponding state
    * 
    * @param int $poll_id - 0 if we are getting list of polls
    * @param int $state - if 1 selects all published polls
    * which is used in the front end poll selection
    * @return mixed array of poll objects or single poll object
    * 
    */
    function getPolls($poll_id = 0, $state = null) 
    {
        // if we are getting a single poll
        // add its id to the WHERE clause
        $where1  = ($state == 1) ? 'AND state = 1' : '';
        $where2  = ($poll_id) ? 'AND id='.$poll_id : '';
        
        // list of apolls for dropdown selection
        $query  = $this->_db->getQuery(true);
        
        $query->select('id, title, CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(0x3a, id, alias) ELSE id END AS slug');
        $query->from($this->_db->nameQuote('#__apoll_polls'));
        $query->where('state <> -2 '.$where1.$where2);
        $query->order('id');
            
        $this->_db->setQuery( $query );
        $list = ($poll_id) ? $this->_db->loadObject() : $this->_db->loadObjectList();        
    
        return $list;
    }    
}
?>
