<?php
class TableVideo extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_videos', 'id', $db);
	}
}