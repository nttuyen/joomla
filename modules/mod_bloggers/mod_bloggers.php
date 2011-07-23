<?php
defined('_JEXEC') or die();
require_once(dirname(__FILE__).DS.'helpers.php');
$bloggers = modBloggersHelper::getBloggers();
require JModuleHelper::getLayoutPath('mod_bloggers', 'default');