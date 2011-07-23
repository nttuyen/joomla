<?php
class TablePlant extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_plants', 'id', $db);
	}
}