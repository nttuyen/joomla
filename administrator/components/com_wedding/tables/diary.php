<?php
class TableDiary extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_diary', 'id', $db);
	}
}