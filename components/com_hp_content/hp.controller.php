<?php 

class hpController extends JController
{
	var $_view 	= null;
	var $_model = null;
	
    /**
     * Constructor
     */
    function __construct($viewName = 'home' )
	{
        parent::__construct();

        $document = &JFactory::getDocument();
        $viewType = $document->getType();

        $this->_view 	= &$this->getView($viewName, $viewType);
    }
    
    function checkUserLogin()
    {
    	$return = false;
    	
    	$user = &JFactory::getUser();
    	
    	if ($user->get('gid'))
    		$return = $user;
    	else
    		$this->setRedirect('index.php', 'Please Login First', 'notice');
    		
    	return $return;
    }
}