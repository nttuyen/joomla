<?php
class TableCardIntro extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_card_intro', 'id', $db);
	}
}