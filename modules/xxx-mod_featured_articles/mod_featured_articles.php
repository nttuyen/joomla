<?php
/**
 * @version		$Id: mod_custom.php 14276 2010-01-18 14:20:28Z louis $
 * @package		Joomla.Site
 * @subpackage	mod_custom
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once 'helper.php';

$listFeaturedArticles = modFeaturedArticlesHelper::getList();

require JModuleHelper::getLayoutPath('mod_featured_articles', $params->get('layout', 'default'));
