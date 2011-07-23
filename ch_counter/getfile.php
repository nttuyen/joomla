<?php

/*
 **************************************
 *
 * getfile.php
* -------------
 * last modified:	2007-01-13
 * -------------
 *
 * project:	chCounter
 * version:	3.1.3
 * copyright:	© 2005 Christoph Bachner
 *               since 2006-21-12 Bert Koern
 * license:	GPL vs2.0 or higher [ see docs/license.txt ]
 * contact:	http://chCounter.org/
 *
 **************************************
*/



error_reporting(E_ALL);
set_magic_quotes_runtime(0);

if( !isset( $_GET['id'] ) || empty( $_GET['id' ] ) )
{
	exit;
}
else
{
	$ID = intval( $_GET['id'] );
}

define( 'CHC_DOWNLOAD_OR_HYPERLINK', 'download' );

require( 'includes/config.inc.php' );
require( 'includes/common.inc.php' );
require( 'includes/functions.inc.php' );
require( 'includes/mysql.class.php' );

if( CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED == FALSE )
{
	exit;
}

$URL = require( 'includes/count_dl_or_link.inc.php' );
header("HTTP/1.1 301 Moved Permanently"); 
header( 'LOCATION: '. $URL );

?>
