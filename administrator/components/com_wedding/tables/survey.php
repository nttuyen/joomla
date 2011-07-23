<?php
class TableSurvey extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_surveys', 'id', $db);
	}
}