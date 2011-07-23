<?php
/**
 * @version		$Id: mod_ttol_categories.php 22-05-2010
 * @package		Joomla.Site
 * @subpackage	mod_ttol_categories
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

//require main helper
require_once(JPATH_ROOT.DS.'components'.DS.'com_hp_content'.DS.'helpers'.DS.'main.helper.php');

$id = JRequest::getInt('category_id', 0);

$listCategories = modHpCategoriesHelper::getListCategories($id, $params);

if($id)
	$categoryInfo = modHpCategoriesHelper::getCategoryInfo($id);
elseif(JRequest::getInt('id'))
	$categoryInfo = modHpCategoriesHelper::getCategoryInfoFromContentDetail();
else
{
	$categoryInfo->parent_id = 0;
	$categoryInfo->id = 0;
}

//print_r($categoryInfo);

if($params->get('set_menu_position') == 'left')
	require JModuleHelper::getLayoutPath('mod_hp_categories', $params->get('layout', 'default'));
elseif($params->get('set_menu_position') == 'top')
	require JModuleHelper::getLayoutPath('mod_hp_categories', $params->get('layout', 'top'));
	
