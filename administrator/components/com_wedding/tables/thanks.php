<?php
class TableThanks extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_thanks', 'id', $db);
	}
}