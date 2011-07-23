<?php
defined('_JEXEC') or die;

class TableApps extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_apps', 'id', $db);
	}
}