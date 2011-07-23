<?php
/**
 * @version		$Id: mod_ttol_featured_content.php 22-05-2010
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

if(!$id)
	$id = modHpFeaturedContentHelper::getCategoryId(JRequest::getInt('id'));

$limit = $params->get('number_to_display');
$tmpl = $params->get('type_of_content');

$i = 0;

for($i = 1; $i < 11; $i ++)
{
	$arrImg[] = $params->get('content_slider_image_'.$i);
}

$contentSliderId = $params->get('content_slider_article_id');
$contentSliderTitle = $params->get('content_slider_title');
$contentSliderAlias = $params->get('content_slider_alias');
$contentSliderDesc = $params->get('content_slider_desc');

$listContent = modHpFeaturedContentHelper::getListContent($id, $limit);

$latestContent = modHpFeaturedContentHelper::getListContent($id, 13, true);

//print_r($categoryInfo);

require JModuleHelper::getLayoutPath('mod_hp_featured_content', $params->get('layout', $tmpl));
