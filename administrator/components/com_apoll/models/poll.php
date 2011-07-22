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

jimport('joomla.application.component.modeladmin');

/**
* @package       Joomla
* @subpackage    aPoll
*/
class ApollModelPoll extends JModelAdmin
{
     /* @var	string	The prefix to use with controller messages.
     * @since	1.6
     */
    protected $text_prefix = 'COM_APOLL'; 

    public $total_votes;
    
    /**
     * Method to test whether a record can be deleted.
     *
     * @param    object    A record object.
     * @return   boolean    True if allowed to delete the record. Defaults to the permission set in the component.
     * @since    1.6
     */
    protected function canDelete($record)
    {
        $user = JFactory::getUser();

        if ($record->catid) {
            return $user->authorise('core.delete', 'com_apoll.category.'.(int) $record->catid);
        }
        else {
            return parent::canDelete($record);
        }
    }

    /**
     * Method to test whether a record can be deleted.
     *
     * @param    object    A record object.
     * @return    boolean    True if allowed to change the state of the record. Defaults to the permission set in the component.
     * @since    1.6
     */
    protected function canEditState($record)
    {
        $user = JFactory::getUser();

        if (!empty($record->catid)) {
            return $user->authorise('core.edit.state', 'com_apoll.category.'.(int) $record->catid);
        }
        else {
            return parent::canEditState($record);
        }
    }
    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param    type    The table type to instantiate
     * @param    string    A prefix for the table class name. Optional.
     * @param    array    Configuration array for model. Optional.
     * @return    JTable    A database object
     * @since    1.6
     */
    public function getTable($type = 'Poll', $prefix = 'ApollTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param    array    $data        An optional array of data for the form to interogate.
     * @param    boolean    $loadData    True if the form is to load its own data (default case), false if not.
     * @return    JForm    A JForm object on success, false on failure
     * @since    1.6
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Initialise variables.
        $app    = JFactory::getApplication();

        // Get the form.
        $form = $this->loadForm('com_apoll.poll', 'poll', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }

        // Determine correct permissions to check.
        if ($this->getState('poll.id')) {
            // Existing record. Can only edit in selected categories.
            $form->setFieldAttribute('catid', 'action', 'core.edit');
        } else {
            // New record. Can only create in selected categories.
            $form->setFieldAttribute('catid', 'action', 'core.create');
        }

        // Modify the form based on access controls.
        if (!$this->canEditState((object) $data)) {
            // Disable fields for display.
            $form->setFieldAttribute('ordering', 'disabled', 'true');
            $form->setFieldAttribute('state', 'disabled', 'true');
            $form->setFieldAttribute('publish_up', 'disabled', 'true');
            $form->setFieldAttribute('publish_down', 'disabled', 'true');

            // Disable fields while saving.
            // The controller has already verified this is a record you can edit.
            $form->setFieldAttribute('ordering', 'filter', 'unset');
            $form->setFieldAttribute('state', 'filter', 'unset');
            $form->setFieldAttribute('publish_up', 'filter', 'true');
            $form->setFieldAttribute('publish_down', 'filter', 'true');
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return    mixed    The data for the form.
     * @since    1.6
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_apoll.edit.poll.data', array());

        if (empty($data)) {
            $data = $this->getItem();

            // Prime some default values.
            if ($this->getState('poll.id') == 0) {
                    $app = JFactory::getApplication();
                    $data->set('catid', JRequest::getInt('catid', $app->getUserState('com_poll.polls.filter.category_id')));
            }
        }

        return $data;
    }

    /**
     * Method to get a single record.
     *
     * @param    integer    The id of the primary key.
     *
     * @return    mixed    Object on success, false on failure.
     * @since    1.6
     */
    public function getItem($pk = null)
    {
        $item = parent::getItem($pk);

        // Prime required properties.
        if (empty($item->id))
        {
            $table	= $this->getTable();
        
            // Prepare data for a new record.
            //if we are creating new poll automatically set up the
            //publish_up and publish_down dates for 1 week
            $now = JFactory::getDate()->toMySQL();
            $table->created      = $now;
            $table->publish_up   = $now;
            $table->publish_down = JFactory::getDate('+7 days')->toMySQL();

            // Convert to the JObject before adding other data.
            $item = JArrayHelper::toObject($table->getProperties(1), 'JObject');

        }
        // Convert the params field to an array.
        //$registry = new JRegistry;
        //$registry->loadJSON($table->params);
        //$value->params = $registry->toArray();

        return $item;
    }

    /**
     * Prepare and sanitise the table prior to saving.
     *
     * @since    1.6
     */
    protected function prepareTable(&$table)
    {
        jimport('joomla.filter.output');
        $date = JFactory::getDate();
        $user = JFactory::getUser();

        $table->title        = htmlspecialchars_decode($table->title, ENT_QUOTES);
        $table->alias        = JApplication::stringURLSafe($table->alias);

        if (empty($table->alias)) {
            $table->alias = JApplication::stringURLSafe($table->title);
        }

        if (empty($table->id)) {
            // Set the values

            // Set ordering to the last item if not set
            if (empty($table->ordering)) {
                $db = JFactory::getDbo();
                $db->setQuery('SELECT MAX(ordering) FROM #__apoll_polls');
                $max = $db->loadResult();

                $table->ordering = $max+1;
            }
        }
        else {
            // Set the values
            //$table->modified    = $date->toMySQL();
            //$table->modified_by = $user->get('id');
        }
    }

    /**
     * A protected method to get a set of ordering conditions.
     *
     * @param    object    A record object.
     * @return    array    An array of conditions to add to add to ordering queries.
     * @since    1.6
     */
    protected function getReorderConditions($table = null)
    {
        $condition = array();
        $condition[] = 'catid = '.(int) $table->catid;
        return $condition;
    }    
    

    /**
     * Method to get the options for current poll.
     *
     * @return   array      Array of poll options with votes they received.
     */
    function getOptions()
    {
        // Initialise variables.
        $pk = (!empty($pk)) ? $pk : (int)$this->getState('poll.id');

        // Get options and votes for this poll
        $query = $this->_db->getQuery(true);
        $query->select('o.* ');
        $query->from('#__apoll_options AS o');
        $query->where('o.poll_id=' . (int) $pk);
        //$query->group('o.id');
        $query->order('o.ordering');

        $this->_db->setQuery((string)$query);
        $options = $this->_db->loadObjectList();

        // Check for a database error.
        if ($this->_db->getErrorNum()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        //DEBUG
        //print_r($options); exit;
        return $options;

    }
    
    /**
     * Method to get the total votes for current poll.
     *
     * @return   array      Array of poll options with votes they received.
     */
    function getVotes()
    {
        // Initialise variables.
        $pk = (!empty($pk)) ? $pk : (int)$this->getState('poll.id');

        // Get votes for this poll from simple logs
        $query = $this->_db->getQuery(true);
        $query->select('SUM(o.votes) AS total_votes ');
        $query->from('#__apoll_options AS o');
        $query->where('o.poll_id=' . (int) $pk);

        $this->_db->setQuery((string)$query);
        $total_votes = $this->_db->loadResult();

        // Check for a database error.
        if ($this->_db->getErrorNum()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        //DEBUG
        //echo $total_votes; exit;
        return $total_votes;

    }
    
    /**
     * Method to save the form data.
     *
     * @param    array    The form data.
     * @return    boolean    True on success.
     * @since    1.6
     */
    public function save($data)
    {
        $table  = $this->getTable();

        // Store the poll data and options.
        if (parent::save($data)) {

            $pk     = $this->getState('poll.id');
            $isNew  = $this->getState('poll.new');
           
            //save the poll options
            if(!$this->saveOptions($isNew, $pk)) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }

        } else {
            $this->setError($table->getError());
            return false;
        }

        return true;
    }

    /**
     * Method for deleting options or votes
     *
     * @param    string     the table suffix 'options' or 'votes'.
     * @param    array      The IDs of the primary keys to delete.
     * @param    boolean    True if we are deleting entries based on poll_id.
     *                      False if we are deleting entries by using their ids
     * @return   boolean    False on failure or error, true otherwise.
     */
    function deleteDependant($table_name, &$ids, $poll = false)
    {
        if ($table_name == 'options' || $table_name == 'votes')
        {
            $poll  = $poll ? 'poll_' : '';
            $ids   = is_array($ids) ? implode(',', $ids) : $ids;
            // Delete options and votes for this poll
            $query = $this->_db->getQuery(true);
            $query->delete();
            $query->from('#__apoll_' . $table_name);
            $query->where($poll . 'id IN ('.$ids.')');
            $this->_db->setQuery((string)$query);
            $this->_db->query();

            // Check for a database error.
            if ($this->_db->getErrorNum()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
            return true;
        }
        return false;
    }

    function clearVotes($poll_id)
    {
            $ids = is_array($poll_id) ? implode(',', $poll_id) : $poll_id;
            // Delete options and votes for this poll

            $query = $this->_db->getQuery(true);
            //$query = "UPDATE #__apoll_options SET votes = 0";
            $query->update('#__apoll_options');
            $query->set('votes = 0');
            $query->where('poll_id IN ('.$ids.')');
            $this->_db->setQuery((string)$query);
            $this->_db->query();

            // Check for a database error.
            if ($this->_db->getErrorNum()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
            return true;

    }

    /**
     * Method to save poll options
     *
     * @param    integer    Are we creating a new poll?
     * @param    integer    The ID of the poll we are messing with.
     * @return   boolean    False on failure or error, true otherwise.
     */
    function saveOptions($isNew, $poll_id) {

        // put all poll options and their colors and ordering in arrays
        $app        = JFactory::getApplication();
        $post       = JRequest::get( 'post' );
        $options    = JArrayHelper::getValue( $post, 'poll_option', array(), 'array' );
        $colors     = JArrayHelper::getValue( $post, 'colorValue', array(), 'array' );
        $orderings  = JArrayHelper::getValue( $post, 'ordering', array(), 'array' );

         //save the options represented by id=>option_text
         foreach ($options as $i=>$text) {
            $this->saveOption($i, $text, $colors[$i], $orderings[$i], $isNew, $poll_id);
        }

        // Check to see if new options are added
        $new_options = JArrayHelper::getValue( $post, 'new_poll_option', array(), 'array' );

        // If there are save them
        if (!empty($new_options)) {
            $new_orderings= JArrayHelper::getValue( $post, 'new_ordering', array(), 'array' );
            $new_colors  = JArrayHelper::getValue( $post, 'new_colorValue', array(), 'array' );

            //Insert in the database the newly created options
            foreach ($new_options as $k=>$text) {
              $this->saveOption($k, $text, $new_colors[$k], $new_orderings[$k], true, $poll_id);
            }
        }

        // delete the marked for deletion options
        $ids_to_delete = JRequest::getString('ids_to_delete', '', 'POST');

        if (!empty($ids_to_delete)) {
            $this->deleteDependant('options', $ids_to_delete);
        }

        //delete all votes the poll if reset flag is raised
        if(JRequest::getInt('reset_votes', 0)) {
            if(!$this->clearVotes($poll_id)) {
                JError::raiseWarning(500, $this->getError());
            } else {
                $app->enqueueMessage(JText::_('COM_APOLL_VOTES_DELETED'));
            }
        }


        return true;
    }
     /**
     * Method to save poll options
     *
     * @param    integer    The id of the option
     * @param    integer    Text of the option
     * @param    string     Color for option
     * @param    integer    Ordering number
     * @param    integer    Are we creating a new poll?
     * @param    integer    The ID of the poll we are messing with.
     * @return   boolean    False on failure or error, true otherwise.
     */

     function saveOption(&$option_id, &$text, &$color, &$ordering, $isNew, &$poll_id) {

        //if somehow options has no text skip it
        if ($text != '') {

            // turns ' into &#039;
            $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

            $obj  = new stdClass();

            $obj->text     = $text;
            $obj->color    = $color;
            $obj->ordering = $ordering;

            if ($isNew) {

                $obj->poll_id  = (int) $poll_id;

                if (!$this->_db->insertObject('#__apoll_options', $obj)) {
                    return false;
                }

            } else {

                $obj->id       = (int) $option_id;

                if(!$this->_db->updateObject('#__apoll_options', $obj, 'id')) {
                    return false;
                }
            }
        }
         return true;
     }

}