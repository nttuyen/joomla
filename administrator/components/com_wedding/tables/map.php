<?php
class TableMap extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_map', 'id', $db);
	}
}