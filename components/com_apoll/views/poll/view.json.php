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

jimport( 'joomla.application.component.view');
jimport( 'joomla.document.json.json' );
    
class ApollViewPoll extends JView
{
	function display( $tpl = null )
	{

        //check if we want to cast a vote before showing the results
        // if apoll_option_id exists the request is comming from the module
        if (JRequest::getInt( 'apoll_option')) {
            $vote = $this->get('Vote');
        }

        // Create a new empty object
        // and encode it to json      
        $obj = new stdClass();
        
        //$obj->poll   = $model->getItem();
        $obj->options = $this->get('Options');
        $obj->total_votes = $this->get('total_votes');

        if($errors = $this->get('Error')) {
            $obj->error = $errors;
        }
        
        $this->poll   = json_encode($obj);

        // Prepare the JSON document
        $this->_prepareDocument();  
              
	$this->setLayout('json');
		
        parent::display($tpl);
    }
    
    /**
     * Method to set up the document properties
     *
     * @return void
     */    
    protected function _prepareDocument() {
        $json = new JDocumentJSON();
        $json->setName('poll');
    }

}