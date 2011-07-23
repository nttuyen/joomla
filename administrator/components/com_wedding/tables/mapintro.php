<?php
class TableMapIntro extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_map_intro', 'id', $db);
	}
}