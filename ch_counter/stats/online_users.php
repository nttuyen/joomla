<?php

/*
 **************************************
 *
 * stats/online_users.php
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

if( @ini_get( 'register_globals' ) )
{
	foreach ( $_REQUEST as $var_name => $void )
	{
		unset( ${$var_name} );
	}
}

header( 'Content-Type: text/html; charset=utf-8' ); 
@session_start();
@ini_set( 'arg_separator.output', '&amp;' );


// chCounter root path
define( 'CHC_ROOT', dirname( dirname( __FILE__ ) ) );

require_once( CHC_ROOT .'/includes/user_agents.lib.php' );
require_once( CHC_ROOT .'/includes/functions.inc.php' );
require_once( CHC_ROOT .'/includes/template.class.php' );
require_once( CHC_ROOT .'/includes/config.inc.php' );
require_once( CHC_ROOT .'/includes/common.inc.php' );
require_once( CHC_ROOT .'/includes/mysql.class.php' );

$_CHC_DB = new chC_mysql($_CHC_DBCONFIG['server'], $_CHC_DBCONFIG['user'], $_CHC_DBCONFIG['password'], $_CHC_DBCONFIG['database']);
$_CHC_CONFIG = chC_get_config();

$_CHC_TPL = new chC_template( CHC_ROOT .'/templates/stats/online_users.tpl.html' );

$available_languages = chC_get_available_languages( CHC_ROOT .'/languages' );
$lang = chC_get_language_to_use( $available_languages );
chC_send_select_list_to_tpl( 'COUNTER_LANGUAGES', $available_languages, $lang );
ob_start();
require_once( CHC_ROOT .'/languages/'. $lang .'/lang_config.inc.php' );
require_once( CHC_ROOT .'/languages/'. $lang .'/main.lang.php' );
ob_end_clean();


$chCounter_utf8_page_title = $_CHC_LANG['online_users_page_title'];
$chCounter_visible = 0;
$chC_seite_in_counterverzeichnis = 1;
if( $_CHC_CONFIG['counterstatus_statistikseiten'] == '0' )
{
	$chCounter_status = 'inactive';
}
$chCounter_force_new_db_connection = FALSE;
ob_start();
require_once( CHC_ROOT .'/counter.php' );
$counter = ob_get_contents();
ob_end_clean();


$login = chC_manage_login();
if( is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'online_users' ) ) )
{
	if( chC_logged_in() == FALSE )
	{
		$failed_login = ( $login == -1 ) ? 1 : 0;
		print chC_get_login_page(
			$_CHC_LANG['online_users_page_title'],
			$failed_login,
			$counter
		);
		exit;
	}
}


if( chC_logged_in() == 'admin' )
{
	$_CHC_TPL->assign( 'IS_ADMIN', '' );
}



$result = $_CHC_DB->query(
	'SELECT o.nr, o.ip, o.user_agent, o.seite, o.homepage_id, o.timestamp_erster_aufruf, o.timestamp_letzter_aufruf, o.seitenaufrufe, s.titel, s.counter_verzeichnis
	FROM `'. CHC_TABLE_ONLINE_USERS .'` as o
	LEFT JOIN `'. CHC_TABLE_PAGES .'` as s
		ON o.seite = s.wert AND o.homepage_id = s.homepage_id AND s.monat = '. chC_format_date( 'Ym', chC_get_timestamp( 'tag' ), FALSE ) .'
	WHERE o.timestamp_letzter_aufruf >= '. ( CHC_TIMESTAMP - $_CHC_CONFIG['user_online_fuer'] ) .'
	GROUP BY o.nr
	ORDER BY timestamp DESC'
);

$liste_homepages = chC_get_ids_and_urls( 'homepages' );
$i = 0;
while( $row = $_CHC_DB->fetch_assoc( $result ) )
{
	$row['ip'] = explode( '.', $row['ip'] );
	$count = count( $row['ip'] );
	$row['ip'] = implode( '.', array_slice( $row['ip'], 0, $_CHC_CONFIG['show_online_users_ip'] ) );
	for( $j = 0; $j < ( $count - $_CHC_CONFIG['show_online_users_ip'] ); $j++ )
	{
		$row['ip'] .= !empty( $row['ip'] ) ? '.x' : 'x';
	}

	if( !empty( $_CHC_CONFIG['hideout_list_pages'] ) && chC_list_match( $_CHC_CONFIG['hideout_list_pages'], $row['seite'] ) )
	{
		$row['seite'] = '';
	}
	else
	{
		if( empty( $row['titel'] ) || $_CHC_CONFIG['zeige_seitentitel'] == '0' )
		{
			$row['titel'] = $row['seite'];
		}
	}
	$blockarray = array(
		'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
		'PLAIN_No.'	=> $row['nr'],
		'No.'		=> number_format( $row['nr'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
		'IP'		=> $row['ip'],
		'USER_AGENT'	=> $row['user_agent'],
		'PAGE_URL'	=> !empty( $row['seite'] ) ? htmlentities( chC_get_url( ( $row['counter_verzeichnis'] == 1 ) ? 'counter' : 'homepage', $row['homepage_id'] ) . $row['seite'] ) : '',
		'PAGE_TITLE'	=> !empty( $row['titel'] ) ? chC_str_prepare_for_output( $row['titel'], $_CHC_CONFIG['wordwrap_seite_online_users'] ) : '',
		'PAGE_VIEWS'	=> $row['seitenaufrufe'],
		'FIRST_ACTIVITY'	=> $row['timestamp_erster_aufruf'] != '0'
			? chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['online_users'], $row['timestamp_erster_aufruf'] )
			: $_CHC_LANG['unknown'],
		'LAST_ACTIVITY'	=> chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['online_users'], $row['timestamp_letzter_aufruf'] )
	);

	$useragent_info = chC_analyse_user_agent( $row['user_agent'] );
	if( $useragent_info['browser'] == TRUE )
	{
		$blockarray['BROWSER'] = ( $useragent_info['browser'] == 'unknown' ) ? $_CHC_LANG['unknown_browser'] : $useragent_info['browser'];
		$blockarray['BROWSER_ICON'] = $useragent_info['browser_icon'];
		$blockarray['BROWSER_VERSION'] = ( $useragent_info['browser_version'] == TRUE && $useragent_info['browser_version'] != 'unknown' )
			? $useragent_info['browser_version']
			: '';
	}
	if( $useragent_info['robot'] == TRUE )
	{
		$blockarray['ROBOT'] = ( $useragent_info['robot'] == 'other') ? $_CHC_LANG['unknown_robot'] : $useragent_info['robot'];
		$blockarray['ROBOT_ICON'] = $useragent_info['robot_icon'];
		$blockarray['ROBOT_VERSION'] = ( $useragent_info['robot_version'] == TRUE && $useragent_info['robot'] != 'other' )
			? $useragent_info['robot_version']
			: '';
	}
	if( $useragent_info['os'] == TRUE && $useragent_info['robot'] != TRUE )
	{
		$blockarray['OS'] = ( $useragent_info['os'] == 'unknown' ) ? $_CHC_LANG['unknown_operating_system'] : $useragent_info['os'];
		$blockarray['OS_ICON'] = $useragent_info['os_icon'];
		$blockarray['OS_VERSION'] = ( $useragent_info['os_version'] == TRUE && $useragent_info['os_version'] != 'unknown' )
			? $useragent_info['os_version']
			: '';
	}

	$_CHC_TPL->add_block( 'ONLINE_USERS', $blockarray );
	$i++;
}


$zeitzone = $_CHC_LANG['time_zones'][$_CHC_CONFIG['zeitzone']];
if( $_CHC_CONFIG['dst'] == '1' )
{
	$zeitzone .= ' '. $_CHC_LANG['time_zone_dst'];
}

$_CHC_TPL->assign( array(
		'TIME_ZONE' => sprintf( $_CHC_LANG['time_zone'], $zeitzone ),
		'V_SCRIPT_VERSION' => $_CHC_CONFIG['script_version'],
		'COUNTER' => $counter,

		'L_CLOSE_WINDOW' => $_CHC_LANG['close_window'],
		'L_CURRENTLY_ONLINE' => $_CHC_LANG['Currently_online:'],
		'L_No.'	=> $_CHC_LANG['No.'],
		'L_IP' => $_CHC_LANG['IP'],
		'L_USER_AGENT' => $_CHC_LANG['user_agent'],
		'L_PAGE' => $_CHC_LANG['page'],
		'L_PAGE_VIEWS' => $_CHC_LANG['page_views'],
		'L_FIRST_ACTIVITY' => $_CHC_LANG['first_activity'],
		'L_LAST_ACTIVITY' => $_CHC_LANG['last_activity'],
		'L_NO_VISITORS_ONLINE' => $_CHC_LANG['no_visitors_online'],
		'L_LANGUAGE'	=> $_CHC_LANG['Language'],
		'L_OK'	=> $_CHC_LANG['OK'],
		'V_TOTAL' => sprintf(
			$_CHC_LANG['total_visitors_online'],
			number_format( $_CHC_DB->num_rows( $result ), 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] )
		)
	)
);

$_CHC_TPL->print_template();

?>
