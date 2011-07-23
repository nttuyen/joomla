<?php
/**
 * @version		$Id: index.php 18650 2010-08-26 13:28:49Z ian $
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

//#nttuyen edit 
error_reporting(0);
#nttuyen edit end

// Set flag that this is a parent file.

define('_JEXEC', 1);
define('JPATH_BASE', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);

require_once JPATH_BASE.DS.'includes'.DS.'defines.php';

require_once JPATH_BASE.DS.'includes'.DS.'framework.php';

// Mark afterLoad in the profiler.
JDEBUG ? $_PROFILER->mark('afterLoad') : null;

// Instantiate the application.
$app = JFactory::getApplication('site');

// Initialise the application.
$app->initialise();

// Mark afterIntialise in the profiler.
JDEBUG ? $_PROFILER->mark('afterInitialise') : null;

// Route the application.
$app->route();

// Mark afterRoute in the profiler.
JDEBUG ? $_PROFILER->mark('afterRoute') : null;

// Dispatch the application.
$app->dispatch();

// Mark afterDispatch in the profiler.
JDEBUG ? $_PROFILER->mark('afterDispatch') : null;

// Render the application.
$app->render();

// Mark afterRender in the profiler.
JDEBUG ? $_PROFILER->mark('afterRender') : null;

ini_set('display_errors', 1);

// Return the response.
echo $app;
// Counter.
$chCounter_visible = 0;
$chCounter_status = 'active';
//include( '/home/thongti3/domains/hanhphuc.vn/public_html/ch_counter/counter.php' );
