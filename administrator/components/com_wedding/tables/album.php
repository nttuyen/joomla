<?php
class TableAlbum extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_albums', 'id', $db);
	}
}