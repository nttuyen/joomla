<?php
class TablePhoto extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_album_photos', 'id', $db);
	}
}