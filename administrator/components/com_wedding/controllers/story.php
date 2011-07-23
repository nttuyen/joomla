<?php
class weddingControllerStory extends weddingController 
{
	function __construct($view = 'story')
	{
		parent::__construct($view);
	}
	
	function details()
	{
		$this->_view->setLayout('details');
		$this->_view->details();
	}
}