<?php
class modAlbumsHelper
{
	static function getAlbums($limit = 8)
	{
		$dbo = & JFactory::getDbo();		
		$query = "SELECT a.id, a.user_id, a.title, a.thumbnail, (SELECT u.username FROM #__users u WHERE u.id = a.user_id ) AS username FROM #__wedding_albums a WHERE featured = 1 ORDER BY created_date DESC LIMIT {$limit}";
		$dbo->setQuery($query);
		return $dbo->loadObjectList();
	}
}
