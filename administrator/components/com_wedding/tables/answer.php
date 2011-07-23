<?php
class TableAnswer extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_survey_answers', 'id', $db);
	}
}