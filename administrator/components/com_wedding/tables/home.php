<?php
class TableHome extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_home', 'id', $db);
	}
}
