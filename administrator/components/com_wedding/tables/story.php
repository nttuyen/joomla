<?php
class TableStory extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_stories', 'id', $db);
	}
}