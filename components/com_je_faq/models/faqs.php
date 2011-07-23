<?php
/**
 * @version		$Id: banners.php 18613 2010-08-24 02:29:33Z ian $
 * @package		Joomla.Site
 * @subpackage	com_banners
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_banners/tables');

/**
 * Banners model for the Joomla Banners component.
 *
 * @package		Joomla.Site
 * @subpackage	com_banners
 * @since		1.6
 */
class je_faqModelFaqs extends JModelList
{
	/**
	 * Gets a list of banners
	 *
	 * @return	array	An array of banner objects.
	 * @since	1.6
	 */
	function getListQuery()
	{
		$db			= $this->getDbo();
		$query		= $db->getQuery(true);
		
		$query->select(
			'a.id as id,'.
			'a.type as type,'.
			'a.name as name,'.
			'a.description as description'
		);
		$query->from('#__je_faqs as a');
		$query->where('a.state=1');

		$query->order('a.name ASC');

		return $query;
	}
}