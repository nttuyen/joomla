<?php
class TableVote extends JTable 
{
	function __construct(&$db)
	{
		parent::__construct('#__wedding_survey_votes', 'id', $db);
	}
}