<?php
defined('_JEXEC') or die();
require_once(dirname(__FILE__).DS.'helpers.php');
$albums = modAlbumsHelper::getAlbums();
require JModuleHelper::getLayoutPath('mod_albums', 'default');