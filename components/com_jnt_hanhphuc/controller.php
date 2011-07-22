<?php
/**
 * @version		$Id: controller.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_banners
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Banners Controller
 *
 * @package		Joomla.Site
 * @subpackage	com_banners
 * @since		1.5
 */
class Jnt_HanhPhucController extends JController {
    
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->default_view = 'intros';
    }


    public function display($cachable = false, $urlparams = false) {
        parent::display($cachable, $urlparams);
    }
}
