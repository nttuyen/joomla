<?php

/*
 **************************************
 *
 * stats/versions.php
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

header( 'Content-Type: text/html; charset=utf-8' ); 
@session_start();
@ini_set( 'arg_separator.output', '&amp;' );

if( @ini_get( 'register_globals' ) )
{
	foreach ( $_REQUEST as $var_name => $void )
	{
		unset( ${$var_name} );
	}
}


// chCounter root path
define( 'CHC_ROOT', dirname( dirname( __FILE__ ) ) );

require_once( CHC_ROOT .'/includes/user_agents.lib.php' );
require_once( CHC_ROOT .'/includes/functions.inc.php' );
require_once( CHC_ROOT .'/includes/template.class.php' );
require_once( CHC_ROOT .'/includes/config.inc.php' );
require_once( CHC_ROOT .'/includes/common.inc.php' );
require_once( CHC_ROOT .'/includes/mysql.class.php' );

$_CHC_DB = new chC_mysql( $_CHC_DBCONFIG['server'], $_CHC_DBCONFIG['user'], $_CHC_DBCONFIG['password'], $_CHC_DBCONFIG['database'] );

$_CHC_TPL = new chC_template( CHC_ROOT .'/templates/stats/versions.tpl.html' );

$_CHC_CONFIG = chC_get_config();

// which language?
$available_languages = chC_get_available_languages( CHC_ROOT .'/languages' );
$lang = chC_get_language_to_use( $available_languages );
chC_send_select_list_to_tpl( 'COUNTER_LANGUAGES', $available_languages, $lang );
ob_start();
require_once( CHC_ROOT .'/languages/'. $lang .'/lang_config.inc.php' );
require_once( CHC_ROOT .'/languages/'. $lang .'/main.lang.php' );
ob_end_clean();


$chCounter_utf8_page_title = $_CHC_LANG['versions_page_title'];
$chCounter_visible = 0;
$chC_seite_in_counterverzeichnis = 1;
if( $_CHC_CONFIG['counterstatus_statistikseiten'] == '0' )
{
	$chCounter_status = 'inactive';
}
$chCounter_force_new_db_connection = FALSE;
ob_start();
require_once( CHC_ROOT .'/counter.php' );
$counter_output = ob_get_contents();
ob_end_clean();


if( is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'versions' ) ) )
{
	$login = chC_manage_login();
	if( chC_logged_in() == FALSE )
	{
		$failed_login = ( $login == -1 ) ? 1 : 0;
		print chC_get_login_page(
			$_CHC_LANG['versions_page_title'],
			$failed_login,
			$counter_output
		);
		exit;
	}
}



$liste_monate = array(
	'01'	=> $_CHC_LANG['date']['January'],
	'02'	=> $_CHC_LANG['date']['February'],
	'03'	=> $_CHC_LANG['date']['March'],
	'04'	=> $_CHC_LANG['date']['April'],
	'05'	=> $_CHC_LANG['date']['May'],
	'06'	=> $_CHC_LANG['date']['June'],
	'07'	=> $_CHC_LANG['date']['July'],
	'08'	=> $_CHC_LANG['date']['August'],
	'09'	=> $_CHC_LANG['date']['September'],
	'10'	=> $_CHC_LANG['date']['October'],
	'11'	=> $_CHC_LANG['date']['November'],
	'12'	=> $_CHC_LANG['date']['December']
);

$result = $_CHC_DB->query(
	"SELECT
		DISTINCT monat
	FROM `".CHC_TABLE_USER_AGENTS."`
	WHERE
		typ LIKE 'version~%'
		AND monat > 0
	ORDER BY monat DESC"
);
$liste = array(
	'all_months' => $_CHC_LANG['since_statistics_start'],
	'' => '--------------'
);
while( $row = $_CHC_DB->fetch_array( $result ) )
{
	$tmp_jahr = substr( $row['monat'], 0, 4 );
	$tmp_monat = substr( $row['monat'], 4 );
	$tmp_monat = str_replace( array_keys( $liste_monate ), $liste_monate, $tmp_monat );
	$liste[$row['monat']] = $tmp_monat .' '. $tmp_jahr;
}
$monat = ( isset( $_GET['month'] ) && !empty( $_GET['month'] ) && isset( $liste[$_GET['month']] ) ) ?  $_GET['month'] : chC_format_date( 'Ym', $_CHC_VARIABLES['timestamp_tagesanfang'], FALSE );
chC_send_select_list_to_tpl( 'MONTH', $liste, $monat );




$hideout_browser = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_browsers'] );
$hideout_browser = !empty( $hideout_browser ) ? 'AND ' . $hideout_browser : $hideout_browser;

$hideout_os = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_os'] );
$hideout_os = !empty( $hideout_os ) ? 'AND ' . $hideout_os : $hideout_os;

$hideout_robot = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_robots'] );
$hideout_robot = !empty( $hideout_robot ) ? 'AND ' . $hideout_robot : $hideout_robot;


#if( $monat == 'all_months' )
#{
	$vorhandene_versionen = $_CHC_DB->query(
		"SELECT DISTINCT wert, typ
		FROM `".CHC_TABLE_USER_AGENTS."`
		WHERE	(
			( wert LIKE '%~versionen\_gesamt'
			AND typ LIKE 'version~os'
			". $hideout_os ." )
			OR
			( wert LIKE '%~versionen\_gesamt'
			AND typ LIKE 'version~browser'
			". $hideout_browser ." )
			OR
			( wert LIKE '%~versionen\_gesamt'
			AND typ LIKE 'version~robot'
			". $hideout_robot .' )
			)'
	);
/*}
else
{
	$vorhandene_versionen = $_CHC_DB->query(
		"SELECT DISTINCT wert, typ
		FROM `".CHC_TABLE_USER_AGENTS."`
		WHERE	(
			( wert LIKE '%~versionen\_gesamt'
			AND typ LIKE 'version~os'
			". $hideout_os ." )
			OR
			( wert LIKE '%~versionen\_gesamt'
			AND typ LIKE 'version~browser'
			". $hideout_browser ." )
			OR
			( wert LIKE '%~versionen\_gesamt'
			AND typ LIKE 'version~robot'
			". $hideout_robot .' )
			)'
			#AND monat = '. $monat
	);
}*/

$browser = array();
$os = array();
$robot = array();
$typen = array();

while( $row = $_CHC_DB->fetch_assoc( $vorhandene_versionen ) )
{
	$kategorie = explode( '~', $row['typ'] );
	$typ = explode( '~', $row['wert'] );
	${$kategorie[1]}[$typ[0]] = $typ[0];
}
$liste = array_merge($browser, $os, $robot );

$_GET['type'] = isset( $_GET['type'] ) ? rawurldecode( $_GET['type'] ) : '';
if( $_GET['type'] == 'other_robots' )
{
	$_GET['type'] = 'other';
}
if( empty( $_GET['type'] ) || !isset( $liste[$_GET['type']] ) )
{
	$_GET['type'] = 'Firefox';
}

if( isset( $browser[$_GET['type']] ) )
{
	$browser_os_or_robot = 'browser';
}
elseif( isset( $os[$_GET['type']] ) )
{
	$browser_os_or_robot = 'os';
}
elseif( isset( $robot[$_GET['type']] ) )
{
	$browser_os_or_robot = 'robot';
}
else
{
	#$browser_os_or_robot = 'browser';
	#$_GET['type'] = 'Firefox';
}

if( count ( $browser ) > 0 )
{
	asort( $browser );
	chC_send_select_list_to_tpl( 'OPTIONS_BROWSERS', $browser, $_GET['type'] );
}
if( count( $os ) > 0 )
{
	asort( $os );
	chC_send_select_list_to_tpl( 'OPTIONS_OSes', $os, $_GET['type'] );
}
if( count( $robot ) > 0 )
{
	asort( $robot );
	if( isset( $robot['other'] ) )
	{
		$robot['other'] = $_CHC_LANG['other'];
	}
	chC_send_select_list_to_tpl( 'OPTIONS_ROBOTS', $robot, $_GET['type'] );
}



if( $monat == 'all_months' )
{
	$result = $_CHC_DB->query(
		"SELECT DISTINCT wert, typ, SUM(anzahl) AS anzahl
		FROM `".CHC_TABLE_USER_AGENTS."`
		WHERE
			typ = 'version~". $browser_os_or_robot ."'
			AND wert LIKE '".$_CHC_DB->escape_string( $_GET['type'] )."~%'
			AND wert != '".$_CHC_DB->escape_string( $_GET['type'] )."~versionen_gesamt'
		GROUP BY wert
		ORDER by anzahl DESC
		LIMIT 0, ". $_CHC_CONFIG['statistiken_anzahl_browser']
	);

	$gesamt = $_CHC_DB->query(
		"SELECT SUM( anzahl ) AS anzahl
		FROM `". CHC_TABLE_USER_AGENTS ."`
		WHERE
			typ = 'version~". $browser_os_or_robot ."'
			AND wert = '".$_CHC_DB->escape_string( $_GET['type'] )."~versionen_gesamt'
		LIMIT 0, 1"
	);
}
else
{
	$result = $_CHC_DB->query(
		"SELECT wert, anzahl
		FROM `".CHC_TABLE_USER_AGENTS."`
		WHERE   (
			typ = 'version~". $browser_os_or_robot ."'
			AND wert LIKE '".$_CHC_DB->escape_string( $_GET['type'] )."~%'
			AND wert != '".$_CHC_DB->escape_string( $_GET['type'] )."~versionen_gesamt'
			)
			AND monat = ". $monat .'
		ORDER by anzahl DESC
		LIMIT 0, '. $_CHC_CONFIG['statistiken_anzahl_browser']
	);

	$gesamt = $_CHC_DB->query(
		"SELECT anzahl
		FROM `". CHC_TABLE_USER_AGENTS ."`
		WHERE
			typ = 'version~". $browser_os_or_robot ."'
			AND wert = '".$_CHC_DB->escape_string( $_GET['type'] )."~versionen_gesamt'
			AND monat = ". $monat .'
		LIMIT 0, 1'
	);
}
$gesamt = $_CHC_DB->fetch_assoc( $gesamt );

$i = 0;
while( $row = $_CHC_DB->fetch_assoc( $result ) )
{
	$version = explode( '~', $row['wert'] );
	$version = $version[count( $version ) - 1];
	if( $_GET['type'] == 'others' )
	{
		$version = '[...]'. $version .'[...]';
	}
	$percent = @round( $row['anzahl'] / $gesamt['anzahl']* 100, 2 );
	$_CHC_TPL->add_block( 'VERSIONS', array(
			'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
			'No.'		=> $i + 1,
			'VERSION'	=> $version == 'unknown' ? $_CHC_LANG['unknown'] : $version,
			'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
			'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
			'GRAPH_PERCENTAGE' => (int) $percent,
		)
	);
	$i++;
}


$_CHC_TPL->assign( array(
		'V_TOTAL_VERSIONS' => $_CHC_DB->num_rows( $result ),
		'V_TOTAL_QUANTITY' => number_format( $gesamt['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
		'V_SCRIPT_VERSION' => $_CHC_CONFIG['script_version'],

		'L_BROWSERS' => $_CHC_LANG['browsers'],
		'L_OSes' => $_CHC_LANG['operating_systems'],
		'L_ROBOTS' => $_CHC_LANG['robots'],

		'COUNTER' => $counter_output,

		'L_CLOSE_WINDOW' => $_CHC_LANG['close_window'], 
		'L_TOTAL:'	=> $_CHC_LANG['total:'],
		'L_VERSIONS_INFO'	=> $_CHC_LANG['versions_info'],
		'L_OK'	=> $_CHC_LANG['OK'],
		'L_VERSION' => $_CHC_LANG['version'],
		'L_No.'	=> $_CHC_LANG['No.'],
		'L_QUANTITY'	=> $_CHC_LANG['quantity'],
		'L_PERCENTAGE'	=> $_CHC_LANG['percentage'],
		'L_LANGUAGE'	=> $_CHC_LANG['Language'],
		'L_NO_ENTRY_IN_DATABASE'	=> $_CHC_LANG['no_entry_in_database'],
		'L_SHOW' => $_CHC_LANG['show:'],
		'L_TIME_FRAME' => $_CHC_LANG['time_frame:']
	)
);

$_CHC_TPL->print_template();

?>
