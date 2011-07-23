<?php
class TableGuestbook extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_guestbook', 'id', $db);
	}
}