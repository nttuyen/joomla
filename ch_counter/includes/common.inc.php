<?php

/*
 **************************************
 *
 * includes/common.inc.php
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

define( 'CHC_DATABASE', $_CHC_DBCONFIG['database'] );

define( 'CHC_TABLE_CONFIG', $_CHC_DBCONFIG['tables_prefix'].'config' );
define( 'CHC_TABLE_DATA', $_CHC_DBCONFIG['tables_prefix'].'data' );
define( 'CHC_TABLE_DOWNLOADS_AND_HYPERLINKS', $_CHC_DBCONFIG['tables_prefix'].'downloads_and_hyperlinks' );
define( 'CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS', $_CHC_DBCONFIG['tables_prefix'].'downloads_and_hyperlinks_logs' );
define( 'CHC_TABLE_LOG_DATA', $_CHC_DBCONFIG['tables_prefix'].'log_data' );
define( 'CHC_TABLE_COUNTED_USERS', $_CHC_DBCONFIG['tables_prefix'].'counted_users' );
define( 'CHC_TABLE_IGNORED_USERS', $_CHC_DBCONFIG['tables_prefix'].'ignored_users' );
define( 'CHC_TABLE_ONLINE_USERS', $_CHC_DBCONFIG['tables_prefix'].'online_users' );
define( 'CHC_TABLE_ACCESS', $_CHC_DBCONFIG['tables_prefix'].'access' );
define( 'CHC_TABLE_SCREEN_RESOLUTIONS', $_CHC_DBCONFIG['tables_prefix'].'screen_resolutions' );
define( 'CHC_TABLE_USER_AGENTS', $_CHC_DBCONFIG['tables_prefix'].'user_agents' );
define( 'CHC_TABLE_SEARCH_ENGINES', $_CHC_DBCONFIG['tables_prefix'].'search_engines' );
define( 'CHC_TABLE_REFERRERS', $_CHC_DBCONFIG['tables_prefix'].'referrers' );
define( 'CHC_TABLE_LOCALE_INFORMATION', $_CHC_DBCONFIG['tables_prefix'].'locale_information' );
define( 'CHC_TABLE_PAGES', $_CHC_DBCONFIG['tables_prefix'].'pages' );

define( 'CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED', FALSE );

define( 'CHC_TIMESTAMP', time() );

?>