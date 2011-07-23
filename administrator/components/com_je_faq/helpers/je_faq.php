<?php
/**
 * @version		$Id: banners.php 17244 2010-05-25 01:07:44Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.6
 */
class je_faqHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('Faqs Menu'),
			'index.php?option=com_je_faq&view=faqs',
			$vName == 'faqs'
		);

		JSubMenuHelper::addEntry(
			JText::_('Categories Menu'),
			'index.php?option=com_categories&extension=com_je_faq',
			$vName == 'categories'
		);
		
		if ($vName=='categories') {
			JToolBarHelper::title(
				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE',JText::_('Faqs Categories')),
				'banners-categories');
		}
	}
	
	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param	int		The category ID.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions($categoryId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($categoryId)) {
			$assetName = 'com_je_faq';
		} else {
			$assetName = 'com_je_faq.category.'.(int) $categoryId;
		}

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
}