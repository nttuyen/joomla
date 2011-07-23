<?php
class TableTemplates extends JTable 
{
	function __construct(& $db)
	{
		parent::__construct('#__wedding_templates', 'id', $db);
	}
}