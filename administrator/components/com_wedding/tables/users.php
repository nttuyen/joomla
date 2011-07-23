<?php
defined('_JEXEC') or die;

class TableUsers extends JTable 
{
	function __construct(& $db)
	{
		parent::__construct('#__wedding_users', 'user_id', $db);
	}
}