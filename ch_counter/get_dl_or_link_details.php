<?php

/*
 **************************************
 *
 * get_dl_or_link_details.php
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


require_once( dirname( __FILE__ ) .'/includes/config.inc.php' );
require_once( dirname( __FILE__ ) .'/includes/common.inc.php' );
require_once( dirname( __FILE__ ) .'/includes/functions.inc.php' );
require_once( dirname( __FILE__ ) .'/includes/mysql.class.php' );
require_once( dirname( __FILE__ ) .'/includes/dl_or_link_details.class.php' );

$chCounter_dl_or_link_details = new chC_dl_or_link_details( $_CHC_DBCONFIG['server'], $_CHC_DBCONFIG['user'], $_CHC_DBCONFIG['password'], $_CHC_DBCONFIG['database'] );

?>
