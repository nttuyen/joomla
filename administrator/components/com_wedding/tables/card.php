<?php
class TableCard extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_card', 'id', $db);
	}
}