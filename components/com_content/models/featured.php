<?php
/**
 * @version		$Id: featured.php 18650 2010-08-26 13:28:49Z ian $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__) . DS . 'articles.php';

/**
 * Frontpage Component Model
 *
 * @package		Joomla.Site
 * @subpackage	com_content
 * @since 1.5
 */
class ContentModelFeatured extends ContentModelArticles
{
	/**
	 * Model context string.
	 *
	 * @var		string
	 */
	public $_context = 'com_content.frontpage';

	public function getCategories()
	{
		$db =& JFactory::getDbo();
		
		$query = "SELECT * FROM #__categories WHERE extension = 'com_content' AND published = 1 AND level = 2 AND featured = 1";
		$db->setQuery($query);
		
		$result = $db->loadObjectList();
		
		//load 3 news in each category
		foreach ($result as & $row)
		{
			$query = "SELECT * FROM #__content WHERE state = 1 AND catid = '$row->id' ORDER BY id DESC LIMIT 3";
			$db->setQuery($query);
			
			$row->listNews = $db->loadObjectList(); 
		}
		
		return $result;		
	}
}
