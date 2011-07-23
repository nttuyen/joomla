<?php

/*
 **************************************
 *
 * stats/index.php
* -------------
 * last modified:	2007-01-01
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

// Includes
require_once( CHC_ROOT .'/includes/config.inc.php' );
require_once( CHC_ROOT .'/includes/common.inc.php' );
require_once( CHC_ROOT .'/includes/mysql.class.php' );
require_once( CHC_ROOT .'/includes/template.class.php' );
require_once( CHC_ROOT .'/includes/functions.inc.php' );


// Datenbank
$_CHC_DB = new chC_mysql( $_CHC_DBCONFIG['server'], $_CHC_DBCONFIG['user'], $_CHC_DBCONFIG['password'], $_CHC_DBCONFIG['database'] );


// Template
$_CHC_TPL = new chC_template( CHC_ROOT .'/templates/stats/index_header.tpl.html' );


// settings
$_CHC_CONFIG = chC_get_config();


// welche Sprache?
$available_languages = chC_get_available_languages( CHC_ROOT .'/languages' );
$lang = chC_get_language_to_use( $available_languages );
chC_send_select_list_to_tpl( 'COUNTER_LANGUAGES', $available_languages, $lang );

// Sprachdateien einbinden
ob_start();
require_once( CHC_ROOT .'/languages/'. $lang .'/lang_config.inc.php' );
require_once( CHC_ROOT .'/languages/'. $lang .'/main.lang.php' );
ob_end_clean();


$liste_kategorien = array(
	'main' => $_CHC_LANG['statistics_main_page'],
	'pages' => $_CHC_LANG['statistics_pages'],
	'referrers' => $_CHC_LANG['statistics_referrers'],
	'visitors_details' => $_CHC_LANG['statistics_visitors_details'],
	'access_statistics' => $_CHC_LANG['statistics_access_stats'],
);
if( CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED == TRUE )
{
	$_CHC_TPL->assign( 'DOWNLOAD_AND_LINK_COUNTER_ACTIVATED', TRUE );
	$liste_kategorien['downloads_and_hyperlinks'] = $_CHC_LANG['statistics_downloads_and_hyperlinks'];
}
if( !( isset( $_GET['cat'] ) && isset( $liste_kategorien[$_GET['cat']] ) ) )
{
	$_GET['cat'] = 'main';
}                                    ;
$_CHC_TPL->assign( 'CAT_'. strtoupper( $_GET['cat'] ), $liste_kategorien[$_GET['cat']] );


// seitentitel:
if( isset( $_GET['list_all'] ) )
{
	$liste_typen = array(
		'keywords' => array(
			'singular' => $_CHC_LANG['search_keyword'],
			'plural' => $_CHC_LANG['search_keywords'],
			'typ' => 'suchwort',
			'tabelle' => CHC_TABLE_SEARCH_ENGINES
		),
		'search_phrases' => array(
			'singular' => $_CHC_LANG['search_phrase'],
			'plural' => $_CHC_LANG['search_phrases'],
			'typ' => 'suchphrase',
			'tabelle' => CHC_TABLE_SEARCH_ENGINES
		),
		'search_engines' => array(
			'singular' => $_CHC_LANG['search_engine'],
			'plural' => $_CHC_LANG['search_engines'],
			'typ' => 'suchmaschine',
			'tabelle' => CHC_TABLE_SEARCH_ENGINES
		),
		'pages'	=> array(
			'singular' => $_CHC_LANG['page'],
			'plural' => $_CHC_LANG['pages'],
			'typ' => '',
			'tabelle' => CHC_TABLE_PAGES
		),
		'entry_pages' => array(
			'singular' => $_CHC_LANG['entry_page'],
			'plural' => $_CHC_LANG['entry_pages'],
			'typ' => '',
			'tabelle' => CHC_TABLE_PAGES
		),
		'exit_pages' => array(
			'singular' => $_CHC_LANG['exit_page'],
			'plural' => $_CHC_LANG['exit_pages'],
			'typ' => '',
			'tabelle' => CHC_TABLE_PAGES
		),
		'referrers' => array(
			'singular' => $_CHC_LANG['referrer'],
			'plural' => $_CHC_LANG['referrers'],
			'typ' => 'referrer',
			'tabelle' => CHC_TABLE_REFERRERS
		),
		'referring_domains' => array(
			'singular' => $_CHC_LANG['referring_domain'],
			'plural' => $_CHC_LANG['referring_domains'],
			'typ' => 'domain',
			'tabelle' => CHC_TABLE_REFERRERS
		),
		'user_agents' => array(
			'singular' => $_CHC_LANG['user_agent'],
			'plural' => $_CHC_LANG['user_agents'],
			'typ' => 'user_agent',
			'tabelle' => CHC_TABLE_USER_AGENTS
		),
		'browsers' => array(
			'singular' => $_CHC_LANG['browser'],
			'plural' => $_CHC_LANG['browsers'],
			'typ' => 'browser',
			'tabelle' => CHC_TABLE_USER_AGENTS
		),
		'operating_systems' => array(
			'singular' => $_CHC_LANG['operating_system'],
			'plural' => $_CHC_LANG['operating_systems'],
			'typ' => 'os',
			'tabelle' => CHC_TABLE_USER_AGENTS
		),
		'robots' => array(
			'singular' => $_CHC_LANG['robot'],
			'plural' => $_CHC_LANG['robots'],
			'typ' => 'robot',
			'tabelle' => CHC_TABLE_USER_AGENTS
		),
		'screen_resolutions' => array(
			'singular' => $_CHC_LANG['screen_resolution'],
			'plural' => $_CHC_LANG['screen_resolutions'],
			'typ' => '',
			'tabelle' => CHC_TABLE_SCREEN_RESOLUTIONS
		),
		'countries' => array(
			'singular' => $_CHC_LANG['country'],
			'plural' => $_CHC_LANG['countries'],
			'typ' => 'country',
			'tabelle' => CHC_TABLE_LOCALE_INFORMATION
		),
		'languages' => array(
			'singular' => $_CHC_LANG['language'],
			'plural' => $_CHC_LANG['languages'],
			'typ' => 'language',
			'tabelle' => CHC_TABLE_LOCALE_INFORMATION
		),
		'hosts_tlds' => array(
			'singular' => $_CHC_LANG['host_tld'],
			'plural' => $_CHC_LANG['hosts_tlds'],
			'typ' => 'host_tld',
			'tabelle' => CHC_TABLE_LOCALE_INFORMATION
		),
		'downloads' => array(
			'singular' => $_CHC_LANG['download'],
			'plural' => $_CHC_LANG['downloads'],
			'typ' => 'download',
			'tabelle' => CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS
		),
		'hyperlinks' => array(
			'singular' => $_CHC_LANG['hyperlink'],
			'plural' => $_CHC_LANG['hyperlinks'],
			'typ' => 'hyperlink',
			'tabelle' => CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS
		)
	);
	if( !( isset( $_GET['list_all'] ) && isset( $liste_typen[$_GET['list_all']] ) ) )
	{
		$_GET['list_all'] = 'pages';
	}
	$chCounter_utf8_page_title = sprintf( $_CHC_LANG['statistics_page_title_all_lists'], $liste_typen[$_GET['list_all']]['plural'] );
}
else
{
	switch( $_GET['cat'] )
	{
		case 'access_statistics':	$chCounter_utf8_page_title = $_CHC_LANG['statistics_page_title_access_stats'];
						break;
		case 'visitors_details':	$chCounter_utf8_page_title = $_CHC_LANG['statistics_page_title_visitors_details'];
						break;
		case 'pages':			$chCounter_utf8_page_title = $_CHC_LANG['statistics_page_title_pages'];
						break;
		case 'downloads_and_hyperlinks': $chCounter_utf8_page_title = $_CHC_LANG['statistics_page_title_downloads_and_hyperlinks'];
						break;
		case 'referrers':		$chCounter_utf8_page_title = $_CHC_LANG['statistics_page_title_referrers'];
						break;
		default:			$chCounter_utf8_page_title = $_CHC_LANG['statistics_page_title_main'];
	}
}


// Counter einbinden

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



$zeitzone = $_CHC_LANG['time_zones'][$_CHC_CONFIG['zeitzone']];
if( $_CHC_CONFIG['dst'] == '1' )
{
	$zeitzone .= ' '. $_CHC_LANG['time_zone_dst'];
}

// unabhängig von jeweilig anzuzeigender Statistik benötigte Variablen
$_CHC_TPL->assign( array(
		'V_SCRIPT_VERSION'	=> $_CHC_CONFIG['script_version'],
		'L_GNU_GPL' 		=> $_CHC_LANG['released_under_the_GNU_GPL'],
		'V_TRANSLATION_INFO'	=> !empty( $_CHC_LANG['CONFIG']['translator'] )
			? sprintf( $_CHC_LANG['translation_by:'], $available_languages[$lang], $_CHC_LANG['CONFIG']['translator'] )
			: '',
		'V_STATISTICS_FOR' => sprintf( $_CHC_LANG['statistics_for_'], $_CHC_CONFIG['default_homepage_url'] ),
		'L_STATISTICS_PAGE_TITLE'	=> chC_str_prepare_for_output( $chCounter_utf8_page_title ),
		'L_LANGUAGE'		=> $_CHC_LANG['Language'],
		'V_TIME_ZONE'	=> sprintf( $_CHC_LANG['time_zone'], $zeitzone ),
		'COUNTER'	=> $counter_output ,
		'L_QUANTITY'	=> $_CHC_LANG['quantity'],
		'L_PERCENTAGE'	=> $_CHC_LANG['percentage'],
		'L_TOTAL:'	=> $_CHC_LANG['total:'],
		'L_No.'	=> $_CHC_LANG['No.'],
		'L_NO_ENTRY_IN_DATABASE' => $_CHC_LANG['no_entry_in_database'],

		'L_STATISTICS_MAIN_PAGE'	=> $_CHC_LANG['statistics_main_page'],
		'L_STATISTICS_PAGES'	=> $_CHC_LANG['statistics_pages'],
		'L_STATISTICS_DOWNLOADS_AND_HYPERLINKS'	=> $_CHC_LANG['statistics_downloads_and_hyperlinks'],
		'L_STATISTICS_REFERRERS'	=> $_CHC_LANG['statistics_referrers'],
		'L_STATISTICS_USERS_DETAILS'	=> $_CHC_LANG['statistics_visitors_details'],
		'L_STATISTICS_ACCESS_STATS'	=> $_CHC_LANG['statistics_access_stats'],

		'L_OK'	=> $_CHC_LANG['OK'],

		'V_LANG_CODE' => $lang,
		'L_SHOW_ALL_ENTRIES' => $_CHC_LANG['show_all_entries'],
		'L_GO_TO_TOP' => $_CHC_LANG['go_to_top']
	)
);

if( isset( $_GET['cat'] ) && $_GET['cat'] != 'main' )
{
	$_CHC_TPL->assign( 'V_CAT', $_GET['cat'] );
}



if( is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index;' ) ) )
{
	$login = chC_manage_login();
	if( chC_logged_in() == FALSE )
	{
		$output = "</form>\n";
		$output .= chC_get_login_form( $login == -1 ? 1 : 0 );
		$output .= "\n<form method=\"GET\" action=\"\">\n";
		$_CHC_TPL->load_template( $output );
		$_CHC_TPL->load_file( CHC_ROOT .'/templates/stats/index_footer.tpl.html' );
		$_CHC_TPL->print_template();
		exit;
	}
}





$aktueller_monat = chC_format_date( 'Ym', $_CHC_VARIABLES['timestamp_tagesanfang'], FALSE );
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





if( isset( $_GET['list_all'] ) )
{
	if( is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index:all_lists' ) ) )
	{
		$login = chC_manage_login();
		if( chC_logged_in() == FALSE )
		{
			$output = "</form>\n";
			$output .= chC_get_login_form( $login == -1 ? 1 : 0 );
			$output .= "\n<form method=\"GET\" action=\"\">\n";
			$_CHC_TPL->load_template( $output );
			$_CHC_TPL->load_file( CHC_ROOT .'/templates/stats/index_footer.tpl.html' );
			$_CHC_TPL->print_template();
			exit;
		}
	}


	$_CHC_TPL->load_file( CHC_ROOT .'/templates/stats/index_body_all_lists.tpl.html' );


	/* $liste_typen und bearbeitung von $_GET['list_all']: siehe oberhalb (bei Seitentitel) */

	/* if( $_GET['list_all'] == 'downloads' || $_GET['list_all'] == 'hyperlinks' )
	{
		$typ = $_GET['list_all'] == 'downloads' ? 'download' : 'hyperlink';

		$result = $_CHC_DB->query(
			'SELECT DISTINCT b.monat
			FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."` AS a
			WHERE a.typ = '". $typ ."'
			LEFT JOIN  `". CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS .'` AS b
				ON a.id = b.id
			ORDER BY b.monat DESC'
		);

		$liste = array(
			'all_months' => $_CHC_LANG['since_statistics_start'],
			'' => '--------------'
		);

		if( $_CHC_DB->num_rows( $result ) == 0 )
		{
			$liste[$aktueller_monat] = chC_format_month( $aktueller_monat, $liste_monate );
		}
		else
		{
			while( $row = $_CHC_DB->fetch_array( $result ) )
			{
				$liste[$row['monat']] = chC_format_month( $row['monat'], $liste_monate );
			}
		}

		$monat = ( isset( $_GET['month'] ) && !empty( $_GET['month'] ) && isset( $liste[$_GET['month']] ) ) ?  $_GET['month'] : $aktueller_monat;
		chC_send_select_list_to_tpl( 'SELECT_LIST_MONTHS', $liste, $monat );
		$_CHC_TPL->assign( 'MONTH', $monat );
	}
	else*/
	if( $_GET['list_all'] != 'user_agents' )
	{
		$bedingung = !empty( $liste_typen[$_GET['list_all']]['typ'] ) ? "typ = '". $liste_typen[$_GET['list_all']]['typ'] ."'" : '';
		$liste = chC_stats_create_list_of_available_months( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung );
		$monat = ( isset( $_GET['month'] ) && !empty( $_GET['month'] ) && isset( $liste[$_GET['month']] ) ) ?  $_GET['month'] : $aktueller_monat;
		chC_send_select_list_to_tpl( 'SELECT_LIST_MONTHS', $liste, $monat );
		$_CHC_TPL->assign( 'MONTH', $monat );
	}


	if( !isset( $_GET['sort_by'] ) )
	{
		$_GET['sort_by'] = 'number';
	}
	switch( $_GET['sort_by'] )
	{
		case 'last_occurrence':	$order_by = 'timestamp';	break;
		case 'alphabet':	$order_by = 'wert';	break;
		default:		$order_by = 'anzahl';
	}


	if( !( isset( $_GET['sort_order'] ) && $_GET['sort_order'] == 'asc' ) )
	{
		$_GET['sort_order'] = 'desc';
	}
	switch( $_GET['sort_order'] )
	{
		case 'asc':	$sort_mode = 'ASC'; break;
		default: 	$sort_mode = 'DESC';
	}


	$liste = array(
		'number' => $_CHC_LANG['by_quantity'],
		'last_occurrence' => $_CHC_LANG['by_last_occurrence'],
		'alphabet' => $_CHC_LANG['by_alphabet']
	);
	chC_send_select_list_to_tpl( 'SORT_BY', $liste, $_GET['sort_by'] );

	$liste = array(
		'asc'	=> $_CHC_LANG['ascending'],
		'desc'	=> $_CHC_LANG['descending']
	);
	chC_send_select_list_to_tpl( 'SORT_ORDER', $liste, $_GET['sort_order'] );

	unset( $statistikstart );

	if( $_GET['list_all'] == 'referring_domains' )
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_referrer'];

		if( $_CHC_CONFIG['fremde_URLs_verlinken'] == '1' )
		{
			$_CHC_TPL->assign( 'LINK_URLs' , TRUE );
		}

		$hideout_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_referrers'] );
		$hideout_condition = !empty( $hideout_condition ) ? ' AND '. $hideout_condition : '';

		$bedingung = !empty( $liste_typen[$_GET['list_all']]['typ'] ) ? "typ = '". $liste_typen[$_GET['list_all']]['typ'] ."'" : '';
		$result = chC_stats_select_entries( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $_CHC_CONFIG['statistiken_anzahl_all_lists'], $monat, $order_by, $sort_mode );
		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$_CHC_TPL->assign( 'ENTRIES_AVAILABLE', TRUE );

			$anzahl = chC_stats_select_sum_count_max( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$i = 0;
			$sum_angezeigt = 0;
			$divisor = $anzahl['sum'] * ( 1/100 );
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$sum_angezeigt += $row['anzahl'];
				$url = ( substr( $row['wert'], 0, 9 ) == 'localhost' ) ? 'http://'. $row['wert'] : $row['wert'];
				$_CHC_TPL->add_block( 'REFERRING_DOMAINS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'REFERRING_DOMAIN'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'URL' => 'http://'. htmlentities( $url ),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( $row['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $row['timestamp'] )
					)
				);
				$i++;
			}
			$array = array(
				'anzahl' => 0,
				'timestamp' => 0,
			);
			if( $monat == 'all_months' )
			{
				$result = $_CHC_DB->query(
					'SELECT DISTINCT wert, SUM( anzahl ) as anzahl, timestamp
					FROM `'. CHC_TABLE_REFERRERS ."`
					WHERE typ = 'domain' AND wert = '__chC:more__'
					GROUP BY wert;"
				);
			}
			else
			{
				$result = $_CHC_DB->query(
					'SELECT wert, anzahl, timestamp
					FROM `'. CHC_TABLE_REFERRERS ."`
					WHERE typ = 'domain' AND wert = '__chC:more__' AND monat = ". $monat .';'
				);
			}
			if( $_CHC_DB->num_rows() == 1 )
			{
				$more = $_CHC_DB->fetch_assoc( $result );
				$array['anzahl'] = $more['anzahl'];
				$array['timestamp'] = $more['timestamp'];
			}
			if( $anzahl['sum'] > ( $sum_angezeigt + $array['anzahl'] ) )
			{
				$array['anzahl'] = $anzahl['sum'] - $sum_angezeigt;
			}

			if( $array['anzahl'] > 0 )
			{
				$_CHC_TPL->add_block( 'REFERRING_DOMAINS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> '',
						'REFERRING_DOMAIN'	=> chC_str_prepare_for_output( $_CHC_LANG['other'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'URL' => '',
						'QUANTITY'	=> number_format( $array['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( $array['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $array['timestamp'] == 0
							? $_CHC_LANG['unknown']
							: chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $array['timestamp'] )
					)
				);
			}
		}
	}
	elseif( $_GET['list_all'] == 'referrers' )
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_referrer'];

		if( $_CHC_CONFIG['fremde_URLs_verlinken'] == '1' )
		{
			$_CHC_TPL->assign( 'LINK_URLs' , TRUE );
		}

		$hideout_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_referrers'] );
		$hideout_condition = !empty( $hideout_condition ) ? ' AND '. $hideout_condition : '';

		$bedingung = !empty( $liste_typen[$_GET['list_all']]['typ'] ) ? "typ = '". $liste_typen[$_GET['list_all']]['typ'] ."'" : '';
		$result = chC_stats_select_entries( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $_CHC_CONFIG['statistiken_anzahl_all_lists'], $monat, $order_by, $sort_mode );

		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$_CHC_TPL->assign( 'ENTRIES_AVAILABLE', TRUE );
			$divisor = $anzahl['sum'] * ( 1/100 );
			$i = 0;
			$sum_angezeigt = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$sum_angezeigt += $row['anzahl'];
				$_CHC_TPL->add_block( 'REFERRERS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'REFERRER'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'URL' => htmlentities( $row['wert'] ),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( $row['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $row['timestamp'] )
					)
				);
				$i++;
			}
			$array = array(
				'anzahl' => 0,
				'timestamp' => 0,
			);
			if( $monat == 'all_months' )
			{
				$result = $_CHC_DB->query(
					'SELECT DISTINCT wert, SUM( anzahl ) as anzahl, timestamp
					FROM `'. CHC_TABLE_REFERRERS ."`
					WHERE typ = 'referrer' AND wert = '__chC:more__'
					GROUP BY wert;"
				);
			}
			else
			{
				$result = $_CHC_DB->query(
					'SELECT wert, anzahl, timestamp
					FROM `'. CHC_TABLE_REFERRERS ."`
					WHERE typ = 'referrer' AND wert = '__chC:more__' AND monat = ". $monat .';'
				);
			}
			if( $_CHC_DB->num_rows() == 1 )
			{
				$more = $_CHC_DB->fetch_assoc( $result );
				$array['anzahl'] = $more['anzahl'];
				$array['timestamp'] = $more['timestamp'];
			}
			if( $anzahl['sum'] > ( $sum_angezeigt + $array['anzahl'] ) )
			{
				$array['anzahl'] = $anzahl['sum'] - $sum_angezeigt;
				$array['referrer'] = 0;
			}

			if( $array['anzahl'] > 0 )
			{
				$_CHC_TPL->add_block( 'REFERRERS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> '',
						'REFERRER'	=> chC_str_prepare_for_output( $_CHC_LANG['other'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'URL' => '',
						'QUANTITY'	=> number_format( $array['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( $array['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $array['timestamp'] == 0
							? $_CHC_LANG['unknown']
							: chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $array['timestamp'] )
					)
				);
			}
		}
	}
	elseif( $_GET['list_all'] == 'pages' || $_GET['list_all'] == 'entry_pages' || $_GET['list_all'] == 'exit_pages' )
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_seiten'];

		if( $_GET['list_all'] == 'entry_pages' )
		{
			$bedingung = ' WHERE anzahl_einstiegsseite > 0' ;
			$anzahl_feld = 'anzahl_einstiegsseite';
		}
		elseif( $_GET['list_all'] == 'exit_pages' )
		{
			$bedingung = ' WHERE anzahl_ausgangsseite > 0' ;
			$anzahl_feld = 'anzahl_ausgangsseite';
		}
		else
		{
			$bedingung = '';
			$anzahl_feld = 'anzahl';
		}

		$order_by = str_replace( 'anzahl', $anzahl_feld, $order_by );
		$hideout_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_pages'] );
		if( !empty( $hideout_condition ) )
		{
			$hideout_condition = empty( $bedingung ) ? ' WHERE '. $hideout_condition : ' AND '. $hideout_condition;
		}


		if( $monat == 'all_months' )
		{
			$result = $_CHC_DB->query(
				'SELECT DISTINCT wert as seite, homepage_id, counter_verzeichnis, titel, SUM( '. $anzahl_feld .' ) AS anzahl, timestamp
				FROM `'. CHC_TABLE_PAGES .'`'
				.$bedingung . $hideout_condition
				.' GROUP BY seite
				ORDER BY '. $order_by .' '. $sort_mode ."\n"
				. 'LIMIT 0, '. $_CHC_CONFIG['statistiken_anzahl_all_lists']
			);
		}
		else
		{
			$result = $_CHC_DB->query(
				'SELECT wert as seite, homepage_id, counter_verzeichnis, titel, '. $anzahl_feld .' AS anzahl, timestamp
				FROM `'. CHC_TABLE_PAGES .'`'
				.$bedingung . $hideout_condition
				. ( ( empty( $bedingung ) && empty( $hideout_condition ) ) ? ' WHERE monat = '. $monat .' ' : ' AND monat = '. $monat .' ' )
				.'ORDER BY '. $order_by .' '. $sort_mode ."\n"
				.'LIMIT 0, '. $_CHC_CONFIG['statistiken_anzahl_all_lists']
			);
		}

		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			if( $monat == 'all_months' )
			{
				$anzahl = $_CHC_DB->query(
					'SELECT SUM('. $anzahl_feld .') as sum, COUNT( DISTINCT wert ) as count
					FROM `'. CHC_TABLE_PAGES ."`
					". $hideout_condition
				);
			}
			else
			{
				$anzahl = $_CHC_DB->query(
					'SELECT SUM('. $anzahl_feld .') as sum, COUNT( '. $anzahl_feld .') as count
					FROM `'. CHC_TABLE_PAGES ."`
					". $hideout_condition
					. ( empty( $hideout_condition ) ? ' WHERE monat = '. $monat : ' AND monat = '. $monat )
				);
			}
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$_CHC_TPL->assign( 'ENTRIES_AVAILABLE', TRUE );

			$divisor =  $anzahl['sum'] * ( 1/100 );
			$i = 0;
			$sum_angezeigt = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$sum_angezeigt += $row['anzahl'];

				if( !empty( $_CHC_CONFIG['hideout_list_pages'] ) && chC_list_match( $_CHC_CONFIG['hideout_list_pages'], $row['seite'] ) )
				{
					$row['seite'] = '';
				}
				else
				{
					if( empty( $row['titel'] ) )
					{
						$row['titel'] = $row['seite'];
					}
				}
				$prozent = @( $row['anzahl'] / $divisor );
				$_CHC_TPL->add_block( 'PAGES',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'PAGE'	=> chC_str_prepare_for_output( $row['titel'], $_CHC_CONFIG['wordwrap_all_lists'], TRUE, TRUE ),
						'URL' => htmlentities( chC_get_url( ( $row['counter_verzeichnis'] == 1 ) ? 'counter' : 'homepage', $row['homepage_id'] ) . $row['seite'] ),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( $row['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $row['timestamp'] )
					)
				);
				$i++;
			}
			if( $anzahl['sum'] > $sum_angezeigt )
			{
				$_CHC_TPL->add_block( 'PAGES',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> '',
						'PAGE'	=> chC_str_prepare_for_output( $_CHC_LANG['other'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( ( $anzahl['sum'] - $sum_angezeigt ), 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( ( $anzahl['sum'] - $sum_angezeigt ) / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $_CHC_LANG['unknown']
					)
				);
			}
		}
	}
	elseif( $_GET['list_all'] == 'downloads' && CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED == TRUE )
	{
		if( $monat == 'all_months' )
		{
			$result = $_CHC_DB->query(
				'SELECT id, wert, anzahl, timestamp
				FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."`
				WHERE typ = 'download'  AND `in_statistik_verbergen` = 0
				ORDER BY ". $order_by . ' '. $sort_mode .'
				LIMIT 0, '. $_CHC_CONFIG['statistiken_anzahl_all_lists']
			);
		}
		else
		{
			$result = $_CHC_DB->query(
				'SELECT b.id, b.wert, a.anzahl, a.timestamp
				FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS .'` AS a
				LEFT JOIN `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."` AS b
					ON a.id = b.id
				WHERE a.typ = 'download' AND a.monat = ". $monat .' AND b.in_statistik_verbergen = 0 AND b.id IS NOT NULL
				ORDER BY '. $order_by . ' '. $sort_mode .'
				LIMIT 0, '. $_CHC_CONFIG['statistiken_anzahl_all_lists']
			);
		}

		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			if( $monat == 'all_months' )
			{
				$anzahl = $_CHC_DB->query(
					'SELECT
						SUM(anzahl) as sum,
						COUNT(id) as count,
						MAX(anzahl) as max
					FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."`
					WHERE typ = 'download' AND in_statistik_verbergen = 0;"
				);
			}
			else
			{
				$anzahl = $_CHC_DB->query(
					'SELECT
						SUM( a.anzahl ) as sum,
						COUNT( a.id ) as count,
						MAX( a.anzahl ) as max
					FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS .'` as a
					LEFT JOIN `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."` AS b
						ON a.id = b.id
					WHERE a.typ = 'download' AND a.monat = ". $monat .' AND b.in_statistik_verbergen = 0 AND b.id IS NOT NULL;'
				);
			}
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$_CHC_TPL->assign( 'ENTRIES_AVAILABLE', TRUE );

			$divisor =  $anzahl['sum'] * ( 1/100 );
			$i = 0;
			$sum_angezeigt = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$sum_angezeigt += $row['anzahl'];

				$prozent = @( $row['anzahl'] / $divisor );
				$_CHC_TPL->add_block( 'DOWNLOADS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'DOWNLOAD_NAME'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_all_lists'], TRUE, TRUE ),
						'DOWNLOAD_URL' => htmlentities( $_CHC_CONFIG['aktuelle_counter_url'] .'/getfile.php?id='. $row['id'] ),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( $row['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $row['timestamp'] != '0' ? chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $row['timestamp'] ) : '-'
					)
				);
				$i++;
			}
			if( $anzahl['sum'] > $sum_angezeigt )
			{
				$_CHC_TPL->add_block( 'DOWLOADS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> '',
						'DOWNLOAD_NAME'	=> chC_str_prepare_for_output( $_CHC_LANG['other'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( ( $anzahl['sum'] - $sum_angezeigt ), 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( ( $anzahl['sum'] - $sum_angezeigt ) / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $_CHC_LANG['unknown']
					)
				);
			}
		}
	}
	elseif( $_GET['list_all'] == 'hyperlinks' && CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED == TRUE )
	{
		if( $monat == 'all_months' )
		{
			$result = $_CHC_DB->query(
				'SELECT id, wert, anzahl, timestamp
				FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."`
				WHERE typ = 'hyperlink' AND in_statistik_verbergen = 0
				ORDER BY ". $order_by . ' '. $sort_mode .'
				LIMIT 0, '. $_CHC_CONFIG['statistiken_anzahl_all_lists']
			);
		}
		else
		{
			$result = $_CHC_DB->query(
				'SELECT b.id, b.wert, a.anzahl, a.timestamp
				FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS .'` AS a
				LEFT JOIN `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."` AS b
					ON a.id = b.id
				WHERE a.typ = 'hyperlink' AND a.monat = ". $monat .'  AND b.in_statistik_verbergen = 0 AND b.id IS NOT NULL
				ORDER BY '. $order_by . ' '. $sort_mode .'
				LIMIT 0, '. $_CHC_CONFIG['statistiken_anzahl_all_lists']
			);
		}

		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			if( $monat == 'all_months' )
			{
				$anzahl = $_CHC_DB->query(
					'SELECT
						SUM(anzahl) as sum,
						COUNT(id) as count,
						MAX(anzahl) as max
					FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."`
					WHERE typ = 'hyperlink' AND in_statistik_verbergen = 0;"
				);
			}
			else
			{
				$anzahl = $_CHC_DB->query(
					'SELECT
						SUM( a.anzahl ) as sum,
						COUNT( a.id ) as count,
						MAX( a.anzahl ) as max
					FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS .'` as a
					LEFT JOIN `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."` AS b
						ON a.id = b.id
					WHERE a.typ = 'hyperlink' AND a.monat = ". $monat .' AND b.in_statistik_verbergen = 0 AND b.id IS NOT NULL;'
				);
			}
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$_CHC_TPL->assign( 'ENTRIES_AVAILABLE', TRUE );

			$divisor =  $anzahl['sum'] * ( 1/100 );
			$i = 0;
			$sum_angezeigt = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$sum_angezeigt += $row['anzahl'];

				$prozent = @( $row['anzahl'] / $divisor );
				$_CHC_TPL->add_block( 'HYPERLINKS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'LINK_NAME'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_all_lists'], TRUE, TRUE ),
						'LINK_URL' => htmlentities( $_CHC_CONFIG['aktuelle_counter_url'] .'/refer.php?id='. $row['id'] ),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( $row['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $row['timestamp'] != '0' ? chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $row['timestamp'] ) : '-'
					)
				);
				$i++;
			}
			if( $anzahl['sum'] > $sum_angezeigt )
			{
				$_CHC_TPL->add_block( 'HYPERLINKS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> '',
						'DOWNLOAD_NAME'	=> chC_str_prepare_for_output( $_CHC_LANG['other'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( ( $anzahl['sum'] - $sum_angezeigt ), 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( ( $anzahl['sum'] - $sum_angezeigt ) / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $_CHC_LANG['unknown']
					)
				);
			}
		}
	}
	elseif( $_GET['list_all'] == 'keywords' )
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_suchwoerter_suchphrasen'];

		$hideout_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_keywords'] );
		$hideout_condition = !empty( $hideout_condition ) ? ' AND '. $hideout_condition : '';

		$bedingung = !empty( $liste_typen[$_GET['list_all']]['typ'] ) ? "typ = '". $liste_typen[$_GET['list_all']]['typ'] ."'" : '';
		$result = chC_stats_select_entries( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $_CHC_CONFIG['statistiken_anzahl_all_lists'], $monat, $order_by, $sort_mode );

		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$_CHC_TPL->assign( 'ENTRIES_AVAILABLE', TRUE );

			$divisor = $anzahl['sum'] * ( 1/100 );
			$i = 0;
			$sum_angezeigt = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$sum_angezeigt += $row['anzahl'];
				$_CHC_TPL->add_block( 'KEYWORDS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'KEYWORD'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( $row['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $row['timestamp'] )
					)
				);
				$i++;
			}
			if( $anzahl['sum'] > $sum_angezeigt )
			{
				$_CHC_TPL->add_block( 'KEYWORDS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> '',
						'KEYWORD'	=> chC_str_prepare_for_output( $_CHC_LANG['other'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( ( $anzahl['sum'] - $sum_angezeigt ), 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( ( $anzahl['sum'] - $sum_angezeigt ) / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $_CHC_LANG['unknown']
					)
				);
			}
		}
	}
	elseif( $_GET['list_all'] == 'search_phrases' )
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_suchwoerter_suchphrasen'];

		$hideout_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_search_phrases'] );
		$hideout_condition = !empty( $hideout_condition ) ? ' AND '. $hideout_condition : '';

		$bedingung = !empty( $liste_typen[$_GET['list_all']]['typ'] ) ? "typ = '". $liste_typen[$_GET['list_all']]['typ'] ."'" : '';
		$result = chC_stats_select_entries( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $_CHC_CONFIG['statistiken_anzahl_all_lists'], $monat, $order_by, $sort_mode );

		if(  $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$_CHC_TPL->assign( 'ENTRIES_AVAILABLE', TRUE );

			$divisor = $anzahl['sum'] * ( 1/100 );
			$i = 0;
			$sum_angezeigt = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$sum_angezeigt += $row['anzahl'];
				$_CHC_TPL->add_block( 'SEARCH_PHRASES',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'SEARCH_PHRASE'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( $row['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $row['timestamp'] )
					)
				);
				$i++;
			}
			if( $anzahl['sum'] > $sum_angezeigt )
			{
				$_CHC_TPL->add_block( 'SEARCH_PHRASES',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> '',
						'SEARCH_PHRASE'	=> chC_str_prepare_for_output( $_CHC_LANG['other'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( ( $anzahl['sum'] - $sum_angezeigt ), 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( ( $anzahl['sum'] - $sum_angezeigt ) / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $_CHC_LANG['unknown']
					)
				);
			}
		}
	}
	elseif( $_GET['list_all'] == 'search_engines' )
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_suchmaschinen'];

		require_once( CHC_ROOT .'/includes/search_engines.lib.php' );

		$hideout_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_search_engines'] );
		$hideout_condition = !empty( $hideout_condition ) ? ' AND '. $hideout_condition : '';

		$bedingung = !empty( $liste_typen[$_GET['list_all']]['typ'] ) ? "typ = '". $liste_typen[$_GET['list_all']]['typ'] ."'" : '';
		$result = chC_stats_select_entries( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $_CHC_CONFIG['statistiken_anzahl_all_lists'], $monat, $order_by, $sort_mode );

		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$_CHC_TPL->assign( 'ENTRIES_AVAILABLE', TRUE );

			$divisor = $anzahl['sum'] * ( 1/100 );
			$i = 0;
			$sum_angezeigt = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$sum_angezeigt += $row['anzahl'];
				$_CHC_TPL->add_block( 'SEARCH_ENGINES',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'IMG' => isset( $chC_search_engines[$row['wert']] ) ? $chC_search_engines[$row['wert']]['icon'] : 'search_engine.png',
						'SEARCH_ENGINE'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( $row['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $row['timestamp'] )
					)
				);
				$i++;
			}
			if( $anzahl['sum'] > $sum_angezeigt )
			{
				$_CHC_TPL->add_block( 'SEARCH_ENGINES',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> '',
						'IMG' => 'search_engine.png',
						'SEARCH_ENGINE'	=> chC_str_prepare_for_output( $_CHC_LANG['other'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( ( $anzahl['sum'] - $sum_angezeigt ), 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( ( $anzahl['sum'] - $sum_angezeigt ) / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $_CHC_LANG['unknown']
					)
				);
			}
		}
	}
	elseif( $_GET['list_all'] == 'browsers' )
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_browser'];

		$vorhandene_versionen = chC_user_agents_get_available_versions( 'browsers' );
		require_once( CHC_ROOT .'/includes/user_agents.lib.php' );

		$hideout_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_browsers'] );
		$hideout_condition = !empty( $hideout_condition ) ? ' AND '. $hideout_condition : '';

		$bedingung = !empty( $liste_typen[$_GET['list_all']]['typ'] ) ? "typ = '". $liste_typen[$_GET['list_all']]['typ'] ."'" : '';
		$result = chC_stats_select_entries( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $_CHC_CONFIG['statistiken_anzahl_all_lists'], $monat, $order_by, $sort_mode );

		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$_CHC_TPL->assign( 'ENTRIES_AVAILABLE', TRUE );

			$divisor = $anzahl['sum'] * ( 1/100 );
			$i = 0;
			$sum_angezeigt = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$sum_angezeigt += $row['anzahl'];
                                $blockarray = array(
					'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
					'No.'		=> $i + 1,
					'IMG' => isset( $chC_ualib_browsers[$row['wert']] ) ? $chC_ualib_browsers[$row['wert']]['icon'] : 'blank.png',
					'BROWSER'	=> chC_str_prepare_for_output( ( $row['wert'] == 'unknown' ? $_CHC_LANG['unknown'] : $row['wert'] ), $_CHC_CONFIG['wordwrap_all_lists'] ),
					'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'PERCENTAGE'	=> @number_format( @round( $row['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'LAST_ACTIVITY' => chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $row['timestamp'] )
				);
                                if( is_int( strpos( $vorhandene_versionen, $row['wert'] ) ) )
				{
					$blockarray['VERSIONS'] = urlencode( $row['wert'] );
				}
				$_CHC_TPL->add_block( 'BROWSERS', $blockarray );
				$i++;
			}
			if( $anzahl['sum'] > $sum_angezeigt )
			{
				$_CHC_TPL->add_block( 'BROWSERS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> '',
						'IMG' => 'blank.png',
						'BROWSER'	=> chC_str_prepare_for_output( $_CHC_LANG['other'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( ( $anzahl['sum'] - $sum_angezeigt ), 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( ( $anzahl['sum'] - $sum_angezeigt ) / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $_CHC_LANG['unknown']
					)
				);
			}
		}
	}
	elseif( $_GET['list_all'] == 'operating_systems' )
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_os'];

		$vorhandene_versionen = chC_user_agents_get_available_versions( 'operating_systems' );
		require_once( CHC_ROOT .'/includes/user_agents.lib.php' );

		$hideout_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_os'] );
		$hideout_condition = !empty( $hideout_condition ) ? ' AND '. $hideout_condition : '';

		$bedingung = !empty( $liste_typen[$_GET['list_all']]['typ'] ) ? "typ = '". $liste_typen[$_GET['list_all']]['typ'] ."'" : '';
		$result = chC_stats_select_entries( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $_CHC_CONFIG['statistiken_anzahl_all_lists'], $monat, $order_by, $sort_mode );

		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$_CHC_TPL->assign( 'ENTRIES_AVAILABLE', TRUE );

			$divisor = $anzahl['sum'] * ( 1/100 );
			$i = 0;
			$sum_angezeigt = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$sum_angezeigt += $row['anzahl'];
                                $blockarray = array(
					'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
					'No.'		=> $i + 1,
					'IMG' => isset( $chC_ualib_os[$row['wert']] ) ? $chC_ualib_os[$row['wert']]['icon'] : 'blank.png',
					'OS'	=> chC_str_prepare_for_output( ( $row['wert'] == 'unknown' ? $_CHC_LANG['unknown'] : $row['wert'] ), $_CHC_CONFIG['wordwrap_all_lists'] ),
					'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'PERCENTAGE'	=> @number_format( @round( $row['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'LAST_ACTIVITY' => chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $row['timestamp'] )
				);
                                if( is_int( strpos( $vorhandene_versionen, $row['wert'] ) ) )
				{
					$blockarray['VERSIONS'] = urlencode( $row['wert'] );
				}
				$_CHC_TPL->add_block( 'OS', $blockarray );
				$i++;
			}
			if( $anzahl['sum'] > $sum_angezeigt )
			{
				$_CHC_TPL->add_block( 'OS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> '',
						'IMG' => 'blank.png',
						'OS'	=> chC_str_prepare_for_output( $_CHC_LANG['other'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( ( $anzahl['sum'] - $sum_angezeigt ), 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( ( $anzahl['sum'] - $sum_angezeigt ) / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $_CHC_LANG['unknown']
					)
				);
			}
		}
	}
	elseif( $_GET['list_all'] == 'robots' )
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_robots'];

		$vorhandene_versionen = chC_user_agents_get_available_versions( 'robots' );
		require_once( CHC_ROOT .'/includes/user_agents.lib.php' );

		$hideout_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_robots'] );
		$hideout_condition = !empty( $hideout_condition ) ? ' AND '. $hideout_condition : '';

		$bedingung = !empty( $liste_typen[$_GET['list_all']]['typ'] ) ? "typ = '". $liste_typen[$_GET['list_all']]['typ'] ."'" : '';
		$result = chC_stats_select_entries( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $_CHC_CONFIG['statistiken_anzahl_all_lists'], $monat, $order_by, $sort_mode );

		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$_CHC_TPL->assign( 'ENTRIES_AVAILABLE', TRUE );

			$divisor = $anzahl['sum'] * ( 1/100 );
			$i = 0;
			$sum_angezeigt = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$sum_angezeigt += $row['anzahl'];
                                $blockarray = array(
					'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
					'No.'		=> $i + 1,
					'IMG' => isset( $chC_ualib_robots[$row['wert']] ) ? $chC_ualib_robots[$row['wert']]['icon'] : 'blank.png',
					'ROBOT'	=> chC_str_prepare_for_output(  ( $row['wert'] == 'other' ) ? $_CHC_LANG['others'] : $row['wert'], $_CHC_CONFIG['wordwrap_all_lists'] ),
					'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'PERCENTAGE'	=> @number_format( @round( $row['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'LAST_ACTIVITY' => chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $row['timestamp'] )
				);
                                if( is_int( strpos( $vorhandene_versionen, $row['wert'] ) ) )
				{
					$blockarray['VERSIONS'] = urlencode( $row['wert'] );
				}
				$_CHC_TPL->add_block( 'ROBOTS', $blockarray );
				$i++;
			}
			if( $anzahl['sum'] > $sum_angezeigt )
			{
				$_CHC_TPL->add_block( 'ROBOTS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> '',
						'IMG' => 'blank.png',
						'ROBOT'	=> chC_str_prepare_for_output( $_CHC_LANG['other'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( ( $anzahl['sum'] - $sum_angezeigt ), 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( ( $anzahl['sum'] - $sum_angezeigt ) / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $_CHC_LANG['unknown']
					)
				);
			}

		}
	}
	elseif( $_GET['list_all'] == 'user_agents' )
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_user_agents'];

		$hideout_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_user_agents'] );
		$hideout_condition = !empty( $hideout_condition ) ? ' AND '. $hideout_condition : '';

		$monat = 'all_months';
		$bedingung = !empty( $liste_typen[$_GET['list_all']]['typ'] ) ? "typ = '". $liste_typen[$_GET['list_all']]['typ'] ."'" : '';
		$result = chC_stats_select_entries( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $_CHC_CONFIG['statistiken_anzahl_all_lists'], $monat, $order_by, $sort_mode );

		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$_CHC_TPL->assign( 'ENTRIES_AVAILABLE', TRUE );

			$divisor = $anzahl['sum'] * ( 1/100 );
			$i = 0;
			$sum_angezeigt = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$sum_angezeigt += $row['anzahl'];
				$row['wert'] = ( $_CHC_CONFIG['user_agents_kuerzen_nach'] > 0 && strlen( $row['wert'] ) > $_CHC_CONFIG['user_agents_kuerzen_nach'] )
					? substr( $row['wert'], 0, $_CHC_CONFIG['user_agents_kuerzen_nach'] ) . $_CHC_CONFIG['user_agents_kuerzungszeichen']
					: $row['wert'];
				$_CHC_TPL->add_block( 'USER_AGENTS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'USER_AGENT'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( $row['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $row['timestamp'] )
					)
				);
				$i++;
			}
			$array = array(
				'anzahl' => 0,
				'timestamp' => 0
			);
			$result = $_CHC_DB->query(
				'SELECT anzahl, timestamp
				FROM `'. CHC_TABLE_USER_AGENTS ."`
				WHERE typ = 'user_agent' AND wert = '__chC:more__';"
			);
			if( $_CHC_DB->num_rows() == 1 )
			{
				$more = $_CHC_DB->fetch_assoc( $result );
				$array['anzahl'] = $more['anzahl'];
				$array['timestamp'] = $more['timestamp'];
			}
			if( $anzahl['sum'] > ( $sum_angezeigt + $array['anzahl'] ) )
			{
				$array['anzahl'] = $anzahl['sum'] - $sum_angezeigt;
			}

			if( $array['anzahl'] > 0 )
			{
				$_CHC_TPL->add_block( 'USER_AGENTS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> '',
						'USER_AGENT'	=> chC_str_prepare_for_output( $_CHC_LANG['other'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( $array['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( $array['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $array['timestamp'] == 0
							? $_CHC_LANG['unknown']
							: chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $array['timestamp'] )
					)
				);
			}
		}
	}
	elseif( $_GET['list_all'] == 'screen_resolutions' )
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_aufloesungen'];

		$hideout_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_screen_resolutions'] );
		$hideout_condition = !empty( $hideout_condition ) ? ' WHERE '. $hideout_condition : '';

		$bedingung = !empty( $liste_typen[$_GET['list_all']]['typ'] ) ? "typ = '". $liste_typen[$_GET['list_all']]['typ'] ."'" : '';
		$result = chC_stats_select_entries( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $_CHC_CONFIG['statistiken_anzahl_all_lists'], $monat, $order_by, $sort_mode );

		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung . $hideout_condition, $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$_CHC_TPL->assign( 'ENTRIES_AVAILABLE', TRUE );

			$divisor = $anzahl['sum'] * ( 1/100 );
			$i = 0;
			$sum_angezeigt = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$sum_angezeigt += $row['anzahl'];
				$_CHC_TPL->add_block( 'SCREEN_RESOLUTIONS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'SCREEN_RESOLUTION'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( $row['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $row['timestamp'] != '0'
							? chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $row['timestamp'] )
							: $_CHC_LANG['unknown']     // // bei Versionen < 3.0.0 wurde bei den Auflösungen kein Datum gespeichert
					)
				);
				$i++;
			}
			if( $anzahl['sum'] > $sum_angezeigt )
			{
				$_CHC_TPL->add_block( 'SCREEN_RESOLUTIONS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> '',
						'SCREEN_RESOLUTION'	=> chC_str_prepare_for_output( $_CHC_LANG['other'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( ( $anzahl['sum'] - $sum_angezeigt ), 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( ( $anzahl['sum'] - $sum_angezeigt ) / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $_CHC_LANG['unknown']
					)
				);
			}
		}
	}
	elseif( $_GET['list_all'] == 'countries' )
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_laender'];

		$bedingung = !empty( $liste_typen[$_GET['list_all']]['typ'] ) ? "typ = '". $liste_typen[$_GET['list_all']]['typ'] ."'" : '';
		$result = chC_stats_select_entries( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung, $_CHC_CONFIG['statistiken_anzahl_all_lists'], $monat, $order_by, $sort_mode );

		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung, $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$_CHC_TPL->assign( 'ENTRIES_AVAILABLE', TRUE );

			$divisor = $anzahl['sum'] * ( 1/100 );
			$i = 0;
			$sum_angezeigt = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$sum_angezeigt += $row['anzahl'];
				$_CHC_TPL->add_block( 'COUNTRIES',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'IMG' => is_file( CHC_ROOT .'/images/flags/'.$row['wert'].'.gif' ) ? $row['wert'].'.gif' : 'unknown.png',
						'COUNTRY'	=> chC_str_prepare_for_output(
							isset( $_CHC_LANG['lib_countries'][$row['wert']] )
								? $_CHC_LANG['lib_countries'][$row['wert']]
								: '? ('.strtoupper( $row['wert'] ).')',
							$_CHC_CONFIG['wordwrap_all_lists']
						),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( $row['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $row['timestamp'] )
					)
				);
				$i++;
			}
			if( $anzahl['sum'] > $sum_angezeigt )
			{
				$_CHC_TPL->add_block( 'COUNTRIES',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> '',
						'IMG' => 'blank.png',
						'COUNTRY'	=> chC_str_prepare_for_output( $_CHC_LANG['other'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( ( $anzahl['sum'] - $sum_angezeigt ), 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( ( $anzahl['sum'] - $sum_angezeigt ) / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $_CHC_LANG['unknown']
					)
				);
			}

		}
	}
	elseif( $_GET['list_all'] == 'languages' )
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_sprachen'];

		$bedingung = !empty( $liste_typen[$_GET['list_all']]['typ'] ) ? "typ = '". $liste_typen[$_GET['list_all']]['typ'] ."'" : '';
		$result = chC_stats_select_entries( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung, $_CHC_CONFIG['statistiken_anzahl_all_lists'], $monat, $order_by, $sort_mode );

		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung, $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$_CHC_TPL->assign( 'ENTRIES_AVAILABLE', TRUE );

			$divisor = $anzahl['sum'] * ( 1/100 );
			$i = 0;
			$sum_angezeigt = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$sum_angezeigt += $row['anzahl'];
				$_CHC_TPL->add_block( 'LANGUAGES',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'LANGUAGE'	=> chC_str_prepare_for_output(
							isset( $_CHC_LANG['lib_languages'][$row['wert']] )
								? $_CHC_LANG['lib_languages'][$row['wert']]
								: '? ('.  $row['wert'] .')',
							$_CHC_CONFIG['wordwrap_all_lists']
						),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( $row['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $row['timestamp'] )
					)
				);
				$i++;
			}
			if( $anzahl['sum'] > $sum_angezeigt )
			{
				$_CHC_TPL->add_block( 'LANGUAGES',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> '',
						'LANGUAGE'	=> chC_str_prepare_for_output( $_CHC_LANG['other'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( ( $anzahl['sum'] - $sum_angezeigt ), 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( ( $anzahl['sum'] - $sum_angezeigt ) / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $_CHC_LANG['unknown']
					)
				);
			}
		}
	}
	elseif( $_GET['list_all'] == 'hosts_tlds' )
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_hosts_tlds'];

		$bedingung = !empty( $liste_typen[$_GET['list_all']]['typ'] ) ? "typ = '". $liste_typen[$_GET['list_all']]['typ'] ."'" : '';
		$result = chC_stats_select_entries( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung, $_CHC_CONFIG['statistiken_anzahl_all_lists'], $monat, $order_by, $sort_mode );

		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( $liste_typen[$_GET['list_all']]['tabelle'], $bedingung, $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$_CHC_TPL->assign( 'ENTRIES_AVAILABLE', TRUE );

			$divisor = $anzahl['sum'] * ( 1/100 );
			$i = 0;
			$sum_angezeigt = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$sum_angezeigt += $row['anzahl'];
				if( $row['wert'][0] == '.' )
				{
					$row['wert'] = substr( $row['wert'], 1 );
					$dotted = TRUE;
				}
				else
				{
					unset( $dotted );
				}
				$img = is_file( CHC_ROOT .'/images/flags/'.$row['wert'].'.gif' ) ? $row['wert'] .'.gif' : 'unknown.png';

				if( $row['wert'] == 'unresolved' )
				{
					$row['wert'] = $_CHC_LANG['unresolved'];
				}
				elseif( isset( $_CHC_LANG['lib_countries'][$row['wert']] )  )
				{
					$row['wert'] = $_CHC_LANG['lib_countries'][$row['wert']];
				}
				elseif( isset( $_CHC_LANG['lib_TLDs'][$row['wert']] ) )
				{
					$row['wert'] = $_CHC_LANG['lib_TLDs'][$row['wert']];
				}
				else
				{
					 $row['wert'] = isset( $dotted ) ? '.'. $row['wert'] : $row['wert'];
				}

				$_CHC_TPL->add_block( 'HOSTS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'IMG' => $img,
						'HOST'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( $row['anzahl'] / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['all_lists'], $row['timestamp'] )
					)
				);
				$i++;
			}
			if( $anzahl['sum'] > $sum_angezeigt )
			{
				$_CHC_TPL->add_block( 'HOSTS',
					array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> '',
						'IMG' => 'blank.png',
						'HOST'	=> chC_str_prepare_for_output( $_CHC_LANG['other'], $_CHC_CONFIG['wordwrap_all_lists'] ),
						'QUANTITY'	=> number_format( ( $anzahl['sum'] - $sum_angezeigt ), 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'PERCENTAGE'	=> @number_format( @round( ( $anzahl['sum'] - $sum_angezeigt ) / $divisor, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'LAST_ACTIVITY' => $_CHC_LANG['unknown']
					)
				);
			}
		}
	}


	if( isset( $statistikstart ) )
	{
		$_CHC_TPL->assign(
			'V_START_DATE_STATISTIC',
			sprintf(
				$_CHC_LANG['statistic_running_since:'],
				chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $statistikstart )
			)
		);
	}

	$_CHC_TPL->assign( array(
			'V_TOTAL_INCIDENTS' => isset( $anzahl ) ? number_format( $anzahl['count'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ) : '',
			'V_TOTAL_QUANTITY' => isset( $anzahl ) ? number_format( $anzahl['sum'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ) : '',
			'V_TYPE_SINGULAR' => $liste_typen[$_GET['list_all']]['singular'],
			'V_TYPE_PLURAL' => $liste_typen[$_GET['list_all']]['plural'],
			'V_LIST_ALL' => $_GET['list_all'],

			'L_LIST_ALL:' => $_CHC_LANG['list_all:'],
			'L_TOTAL:' => $_CHC_LANG['total:'],
			'L_SORT:' => $_CHC_LANG['sort:'],
			'L_LAST' => $_CHC_LANG['last'],

			'L_GO_BACK_TO_CAT' => sprintf( $_CHC_LANG['go_back_to_cat'], $liste_kategorien[$_GET['cat']] ),
			'V_URL_BACK' => 'index.php?cat='. $_GET['cat']
		)
	);
}
elseif( $_GET['cat'] == 'access_statistics' )
{

	if( is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index:access_statistics;' ) ) )
	{
		$login = chC_manage_login();
		if( chC_logged_in() == FALSE )
		{
			$output = "</form>\n";
			$output .= chC_get_login_form( $login == -1 ? 1 : 0 );
			$output .= "\n<form method=\"GET\" action=\"\">\n";
			$_CHC_TPL->load_template( $output );
			$_CHC_TPL->load_file( CHC_ROOT .'/templates/stats/index_footer.tpl.html' );
			$_CHC_TPL->print_template();
			exit;
		}
	}

	$_CHC_TPL->load_file( CHC_ROOT .'/templates/stats/index_body_access.tpl.html' );


	$_CHC_TPL->assign(
		'V_START_DATE_ACCESS_STATISTIC',
		sprintf(
			$_CHC_LANG['access_statistic_running_since:'],
			chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $_CHC_CONFIG['timestamp_start_access'] )
		)
	);


	// Rekorde
	$_CHC_TPL->assign( 'L_RECORDS', $_CHC_LANG['records'] );

	$spalten = array( 'max_besucher', 'min_besucher', 'max_seitenaufrufe', 'min_seitenaufrufe' );
	$array = array(
		'rekorde_tage' => 'tag',
		'rekorde_kalenderwochen' => 'kw',
		'rekorde_monate' => 'monat',
		'rekorde_jahre' => 'jahr'
	);
	$aktuelle_timestamps = array(
		'tag' => chC_get_timestamp( 'tag' ),
		'monat' => chC_get_timestamp( 'monat' ),
		'jahr' => chC_get_timestamp( 'jahr' ),
		'kw' => chC_get_timestamp( 'kw' )
	);
	foreach( $array as $var_name => $typ )
	{
		$$var_name = array();

		$result = $_CHC_DB->query(
			'SELECT
				COUNT(timestamp) AS count,
				@max_besucher := MAX(
					besucher_00 + besucher_01 + besucher_02 + besucher_03 + besucher_04 + besucher_05 + besucher_06
					+ besucher_07 + besucher_08 + besucher_09 + besucher_10 + besucher_11 + besucher_12 + besucher_13
					+ besucher_14 + besucher_15 + besucher_16 + besucher_17 + besucher_18 + besucher_19 + besucher_20
					+ besucher_21 + besucher_22 + besucher_23
				) as max_besucher,
				@min_besucher := MIN(
					besucher_00 + besucher_01 + besucher_02 + besucher_03 + besucher_04 + besucher_05 + besucher_06
					+ besucher_07 + besucher_08 + besucher_09 + besucher_10 + besucher_11 + besucher_12 + besucher_13
					+ besucher_14 + besucher_15 + besucher_16 + besucher_17 + besucher_18 + besucher_19 + besucher_20
					+ besucher_21 + besucher_22 + besucher_23
				) as min_besucher,
				@max_seitenaufrufe := MAX(
					seitenaufrufe_00 + seitenaufrufe_01 + seitenaufrufe_02 + seitenaufrufe_03 + seitenaufrufe_04 + seitenaufrufe_05 + seitenaufrufe_06
					+ seitenaufrufe_07 + seitenaufrufe_08 + seitenaufrufe_09 + seitenaufrufe_10 + seitenaufrufe_11 + seitenaufrufe_12 + seitenaufrufe_13
					+ seitenaufrufe_14 + seitenaufrufe_15 + seitenaufrufe_16 + seitenaufrufe_17 + seitenaufrufe_18 + seitenaufrufe_19 + seitenaufrufe_20
					+ seitenaufrufe_21 + seitenaufrufe_22 + seitenaufrufe_23
				) as max_seitenaufrufe,
				@min_seitenaufrufe := MIN(
					seitenaufrufe_00 + seitenaufrufe_01 + seitenaufrufe_02 + seitenaufrufe_03 + seitenaufrufe_04 + seitenaufrufe_05 + seitenaufrufe_06
					+ seitenaufrufe_07 + seitenaufrufe_08 + seitenaufrufe_09 + seitenaufrufe_10 + seitenaufrufe_11 + seitenaufrufe_12 + seitenaufrufe_13
					+ seitenaufrufe_14 + seitenaufrufe_15 + seitenaufrufe_16 + seitenaufrufe_17 + seitenaufrufe_18 + seitenaufrufe_19 + seitenaufrufe_20
					+ seitenaufrufe_21 + seitenaufrufe_22 + seitenaufrufe_23
				) as min_seitenaufrufe
			FROM `'. CHC_TABLE_ACCESS ."`
			WHERE
				typ = '". $typ ."'
				AND erster_eintrag = 0
				AND timestamp < ". $aktuelle_timestamps[$typ] .';'
		);
		$count = $_CHC_DB->fetch_assoc( $result );

		$result = $_CHC_DB->query(
			'SELECT
				@max_besucher as max_besucher,
				@min_besucher as min_besucher,
				@max_seitenaufrufe as max_seitenaufrufe,
				@min_seitenaufrufe as min_seitenaufrufe,
				IF(
					( besucher_00 + besucher_01 + besucher_02 + besucher_03 + besucher_04 + besucher_05 + besucher_06
					+ besucher_07 + besucher_08 + besucher_09 + besucher_10 + besucher_11 + besucher_12 + besucher_13
					+ besucher_14 + besucher_15 + besucher_16 + besucher_17 + besucher_18 + besucher_19 + besucher_20
					+ besucher_21 + besucher_22 + besucher_23 ) = @max_besucher,
					timestamp,
					NULL
				) as max_besucher_timestamp,
				IF(
					( besucher_00 + besucher_01 + besucher_02 + besucher_03 + besucher_04 + besucher_05 + besucher_06
					+ besucher_07 + besucher_08 + besucher_09 + besucher_10 + besucher_11 + besucher_12 + besucher_13
					+ besucher_14 + besucher_15 + besucher_16 + besucher_17 + besucher_18 + besucher_19 + besucher_20
					+ besucher_21 + besucher_22 + besucher_23 ) = @min_besucher,
					timestamp,
					NULL
				) as min_besucher_timestamp,
				IF(
					( seitenaufrufe_00 + seitenaufrufe_01 + seitenaufrufe_02 + seitenaufrufe_03 + seitenaufrufe_04 + seitenaufrufe_05 + seitenaufrufe_06
					+ seitenaufrufe_07 + seitenaufrufe_08 + seitenaufrufe_09 + seitenaufrufe_10 + seitenaufrufe_11 + seitenaufrufe_12 + seitenaufrufe_13
					+ seitenaufrufe_14 + seitenaufrufe_15 + seitenaufrufe_16 + seitenaufrufe_17 + seitenaufrufe_18 + seitenaufrufe_19 + seitenaufrufe_20
					+ seitenaufrufe_21 + seitenaufrufe_22 + seitenaufrufe_23 ) = @max_seitenaufrufe,
					timestamp,
					NULL
				) as max_seitenaufrufe_timestamp,
				IF(
					( seitenaufrufe_00 + seitenaufrufe_01 + seitenaufrufe_02 + seitenaufrufe_03 + seitenaufrufe_04 + seitenaufrufe_05 + seitenaufrufe_06
					+ seitenaufrufe_07 + seitenaufrufe_08 + seitenaufrufe_09 + seitenaufrufe_10 + seitenaufrufe_11 + seitenaufrufe_12 + seitenaufrufe_13
					+ seitenaufrufe_14 + seitenaufrufe_15 + seitenaufrufe_16 + seitenaufrufe_17 + seitenaufrufe_18 + seitenaufrufe_19 + seitenaufrufe_20
					+ seitenaufrufe_21 + seitenaufrufe_22 + seitenaufrufe_23 ) = @min_seitenaufrufe,
					timestamp,
					NULL
				) as min_seitenaufrufe_timestamp
			FROM `'. CHC_TABLE_ACCESS .'`
			WHERE
				(
					( besucher_00 + besucher_01 + besucher_02 + besucher_03 + besucher_04 + besucher_05 + besucher_06
					+ besucher_07 + besucher_08 + besucher_09 + besucher_10 + besucher_11 + besucher_12 + besucher_13
					+ besucher_14 + besucher_15 + besucher_16 + besucher_17 + besucher_18 + besucher_19 + besucher_20
					+ besucher_21 + besucher_22 + besucher_23 ) = @max_besucher
					OR
					( besucher_00 + besucher_01 + besucher_02 + besucher_03 + besucher_04 + besucher_05 + besucher_06
					+ besucher_07 + besucher_08 + besucher_09 + besucher_10 + besucher_11 + besucher_12 + besucher_13
					+ besucher_14 + besucher_15 + besucher_16 + besucher_17 + besucher_18 + besucher_19 + besucher_20
					+ besucher_21 + besucher_22 + besucher_23 ) = @min_besucher
					OR
					( seitenaufrufe_00 + seitenaufrufe_01 + seitenaufrufe_02 + seitenaufrufe_03 + seitenaufrufe_04 + seitenaufrufe_05 + seitenaufrufe_06
					+ seitenaufrufe_07 + seitenaufrufe_08 + seitenaufrufe_09 + seitenaufrufe_10 + seitenaufrufe_11 + seitenaufrufe_12 + seitenaufrufe_13
					+ seitenaufrufe_14 + seitenaufrufe_15 + seitenaufrufe_16 + seitenaufrufe_17 + seitenaufrufe_18 + seitenaufrufe_19 + seitenaufrufe_20
					+ seitenaufrufe_21 + seitenaufrufe_22 + seitenaufrufe_23 ) = @max_seitenaufrufe
					OR
					( seitenaufrufe_00 + seitenaufrufe_01 + seitenaufrufe_02 + seitenaufrufe_03 + seitenaufrufe_04 + seitenaufrufe_05 + seitenaufrufe_06
					+ seitenaufrufe_07 + seitenaufrufe_08 + seitenaufrufe_09 + seitenaufrufe_10 + seitenaufrufe_11 + seitenaufrufe_12 + seitenaufrufe_13
					+ seitenaufrufe_14 + seitenaufrufe_15 + seitenaufrufe_16 + seitenaufrufe_17 + seitenaufrufe_18 + seitenaufrufe_19 + seitenaufrufe_20
					+ seitenaufrufe_21 + seitenaufrufe_22 + seitenaufrufe_23 ) = @min_seitenaufrufe
				)
				AND typ = \''. $typ .'\'
				AND erster_eintrag = 0
				AND timestamp < '. $aktuelle_timestamps[$typ] .';'
		);

		while( $row = $_CHC_DB->fetch_assoc( $result ) )
		{
			foreach( $spalten as $spalte )
			{
				if( !is_null( $row[$spalte .'_timestamp'] ) )
				{
					${$var_name}[$spalte] = $row[$spalte];
					${$var_name}[$spalte .'_timestamp'] = $row[$spalte .'_timestamp'];
				}
			}
		}

		// weniger Einträge in DB als Tage/Wochen/Monate/Jahre vergangen? Dann war mind. einmal _kein_ Besucher da,
		// so dass kein Eintrag in DB erfolgte. In diesem Fall min_besucher/seitenaufrufe = 0, timestamps unbekannt
		if(
			(
				$typ == 'tag'
				&& $count['count'] <  @ceil( ( time() - $_CHC_CONFIG['timestamp_start_access'] ) / 86400 )
			)
			OR
			(
				$typ == 'kw'
				&& $count['count'] <  @ceil( ( time() - $_CHC_CONFIG['timestamp_start_access'] ) / 604800 )
			)
			OR
			(
				$typ == 'monat'
				&& $count['count'] <
				(
					(
						chC_format_date( 'n', time(), TRUE, '0' )
						- chC_format_date( 'n', $_CHC_CONFIG['timestamp_start_access'], TRUE, '0' )
					)
					+
					(
						12 *
						(
							chC_format_date( 'Y', time(), TRUE, '0' )
							-  chC_format_date( 'Y', $_CHC_CONFIG['timestamp_start_access'], TRUE, '0' )
						)
					)
					+1
				)
			)
			OR
			(
				$typ == 'jahr'
				&& $count['count'] <
				(
					chC_format_date( 'Y', time(), TRUE, '0' )
					- chC_format_date( 'Y', $_CHC_CONFIG['timestamp_start_access'], TRUE, '0' )
					+1
				)
			)
		  )
		{ 
			${$var_name}['min_besucher'] = 0;
			${$var_name}['min_besucher_timestamp'] = 0;
			${$var_name}['min_seitenaufrufe'] = 0;
			${$var_name}['min_seitenaufrufe_timestamp'] = 0;
		}

		// Wenn noch keinerlei Daten in der DB stehen, fehlen Werte...
		foreach( $spalten as $feld )
		{
			if( !isset( ${$var_name}[$feld] ) || ${$var_name}[$feld] == 0 )
			{
				$max_oder_min = is_int( strpos( $feld, 'max' ) ) ? 'MAX' : 'MIN';
				$besucher_oder_seitenaufrufe = is_int( strpos( $feld, 'besucher' ) ) ? 'besucher' : 'seitenaufrufe';
				#print $besucher_oder_seitenaufrufe.' '. $typ .' '. $var_name. ' '. $feld .'<br>';
				$result = $_CHC_DB->query(
					'SELECT
						'. $max_oder_min .'(
							'. $besucher_oder_seitenaufrufe .'_00 + '. $besucher_oder_seitenaufrufe .'_01 + '. $besucher_oder_seitenaufrufe .'_02 + '. $besucher_oder_seitenaufrufe .'_03 + '. $besucher_oder_seitenaufrufe .'_04 + '. $besucher_oder_seitenaufrufe .'_05 + '. $besucher_oder_seitenaufrufe .'_06
							+ '. $besucher_oder_seitenaufrufe .'_07 + '. $besucher_oder_seitenaufrufe .'_08 + '. $besucher_oder_seitenaufrufe .'_09 + '. $besucher_oder_seitenaufrufe .'_10 + '. $besucher_oder_seitenaufrufe .'_11 + '. $besucher_oder_seitenaufrufe .'_12 + '. $besucher_oder_seitenaufrufe .'_13
							+ '. $besucher_oder_seitenaufrufe .'_14 + '. $besucher_oder_seitenaufrufe .'_15 + '. $besucher_oder_seitenaufrufe .'_16 + '. $besucher_oder_seitenaufrufe .'_17 + '. $besucher_oder_seitenaufrufe .'_18 + '. $besucher_oder_seitenaufrufe .'_19 + '. $besucher_oder_seitenaufrufe .'_20
							+ '. $besucher_oder_seitenaufrufe .'_21 + '. $besucher_oder_seitenaufrufe .'_22 + '. $besucher_oder_seitenaufrufe .'_23
						) as '. $feld .'
					FROM `'. CHC_TABLE_ACCESS ."`
					WHERE typ = '". $typ ."';"
				);
				$row = $_CHC_DB->fetch_assoc( $result );

				${$var_name}[$feld] = $row[$feld];
				$result = $_CHC_DB->query(
					'SELECT
						timestamp
					FROM `'. CHC_TABLE_ACCESS ."`
					WHERE
						typ = '". $typ ."'
						AND (
							". $besucher_oder_seitenaufrufe ."_00 + ". $besucher_oder_seitenaufrufe ."_01 + ". $besucher_oder_seitenaufrufe ."_02 + ". $besucher_oder_seitenaufrufe ."_03 + ". $besucher_oder_seitenaufrufe ."_04 + ". $besucher_oder_seitenaufrufe ."_05 + ". $besucher_oder_seitenaufrufe ."_06
							+ ". $besucher_oder_seitenaufrufe ."_07 + ". $besucher_oder_seitenaufrufe ."_08 + ". $besucher_oder_seitenaufrufe ."_09 + ". $besucher_oder_seitenaufrufe ."_10 + ". $besucher_oder_seitenaufrufe ."_11 + ". $besucher_oder_seitenaufrufe ."_12 + ". $besucher_oder_seitenaufrufe ."_13
							+ ". $besucher_oder_seitenaufrufe ."_14 + ". $besucher_oder_seitenaufrufe ."_15 + ". $besucher_oder_seitenaufrufe ."_16 + ". $besucher_oder_seitenaufrufe ."_17 + ". $besucher_oder_seitenaufrufe ."_18 + ". $besucher_oder_seitenaufrufe ."_19 + ". $besucher_oder_seitenaufrufe ."_20
							+ ". $besucher_oder_seitenaufrufe ."_21 + ". $besucher_oder_seitenaufrufe ."_22 + ". $besucher_oder_seitenaufrufe ."_23
						) = ". $row[$feld] .'
					ORDER BY timestamp DESC
					LIMIT 0, 1'
				);
				$row = $_CHC_DB->fetch_assoc( $result );
				if( $row['timestamp'] > 0 )
				{
					${$var_name}[$feld .'_timestamp'] = $row['timestamp'];
				}
				else#if( !isset( ${$var_name}[$feld] ) )
				{
					${$var_name}[$feld] = 0;
					${$var_name}[$feld .'_timestamp'] = 0;
				}
			}
		}
	}



	$array = array(
		'rekorde_tage' => 'day',
		'rekorde_kalenderwochen' => 'calendar_week',
		'rekorde_monate' => 'month',
		'rekorde_jahre' => 'year'
	);
	foreach( $array as $var_name => $typ )
	{
		if( $typ == 'day' )
		{
			$datums_format = $_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_day:long'];
		}
		elseif( $typ == 'calendar_week' )
		{
			$datums_format = $_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_day:long'];
		}
		elseif( $typ == 'month' )
		{
			$datums_format = $_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_month:long'];
		}
		elseif( $typ == 'year' )
		{
			$datums_format = $_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_year:long'];
		}


		$tpl_vars = array(
			'L_MAX_A_'. strtoupper( $typ ) => $_CHC_LANG['max_a_'. $typ],
			'V_MAX_VISITORS_A_'. strtoupper( $typ ) => ${$var_name}['max_besucher'],
			'V_MAX_VISITORS_A_'. strtoupper( $typ ) .'_DATE' => ( $typ != 'calendar_week' )
				? chC_format_date( $datums_format, ${$var_name}['max_besucher_timestamp'], TRUE, '0' )
				: sprintf(
					$_CHC_LANG['calendar_week_records'],
					chC_format_date( 'W', ${$var_name}['max_besucher_timestamp'], TRUE, '0' ),
					chC_format_date(
						$_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_calendar_week:beginning,end'],
						${$var_name}['max_besucher_timestamp'],
						TRUE,
						'0'
					),
					chC_format_date(
						$_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_calendar_week:beginning,end'],
						${$var_name}['max_besucher_timestamp'] + 518400, // 6* 86400
						TRUE,
						'0'
					)
				),

			'L_MIN_A_'. strtoupper( $typ ) => $_CHC_LANG['min_a_'. $typ],
			'V_MIN_VISITORS_A_'. strtoupper( $typ ) => ${$var_name}['min_besucher'],
			'V_MIN_VISITORS_A_'. strtoupper( $typ ) .'_DATE' => ( $typ != 'calendar_week' )
				? chC_format_date( $datums_format, ${$var_name}['min_besucher_timestamp'], TRUE, '0' )
				: sprintf(
					$_CHC_LANG['calendar_week_records'],
					chC_format_date( 'W', ${$var_name}['min_besucher_timestamp'], TRUE, '0' ),
					chC_format_date(
						$_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_calendar_week:beginning,end'],
						${$var_name}['min_besucher_timestamp'],
						TRUE,
						'0'
					),
					chC_format_date(
						$_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_calendar_week:beginning,end'],
						${$var_name}['min_besucher_timestamp'] + 518400, // 6* 86400
						TRUE,
						'0'
					)
				),

			'L_MAX_A_'. strtoupper( $typ ) => $_CHC_LANG['max_a_'. $typ],
			'V_MAX_PAGE_VIEWS_A_'. strtoupper( $typ ) => ${$var_name}['max_seitenaufrufe'],
			'V_MAX_PAGE_VIEWS_A_'. strtoupper( $typ ) .'_DATE' => ( $typ != 'calendar_week' )
				? chC_format_date( $datums_format, ${$var_name}['max_seitenaufrufe_timestamp'], TRUE, '0' )
				: sprintf(
					$_CHC_LANG['calendar_week_records'],
					chC_format_date( 'W', ${$var_name}['max_seitenaufrufe_timestamp'], TRUE, '0' ),
					chC_format_date(
						$_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_calendar_week:beginning,end'],
						${$var_name}['max_seitenaufrufe_timestamp'],
						TRUE, '0'
					),
					chC_format_date(
						$_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_calendar_week:beginning,end'],
						${$var_name}['max_seitenaufrufe_timestamp'] + 518400, // 6* 86400
						TRUE,
						'0'
					)
				),

			'L_MIN_A_'. strtoupper( $typ ) => $_CHC_LANG['min_a_'. $typ],
			'V_MIN_PAGE_VIEWS_A_'. strtoupper( $typ ) => ${$var_name}['min_seitenaufrufe'],
			'V_MIN_PAGE_VIEWS_A_'. strtoupper( $typ ) .'_DATE' => ( $typ != 'calendar_week' )
				? chC_format_date( $datums_format, ${$var_name}['min_seitenaufrufe_timestamp'], TRUE, '0' )
				: sprintf(
					$_CHC_LANG['calendar_week_records'],
					chC_format_date( 'W', ${$var_name}['min_seitenaufrufe_timestamp'], TRUE, '0' ),
					chC_format_date(
						$_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_calendar_week:beginning,end'],
						${$var_name}['min_seitenaufrufe_timestamp'],
						TRUE,
						'0'
					),
					chC_format_date(
						$_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_calendar_week:beginning,end'],
						${$var_name}['min_seitenaufrufe_timestamp'] + 518400, // 6* 86400
						TRUE,
						'0'
					)
				)
		);
		if( ${$var_name}['min_besucher_timestamp'] == 0 )
		{
			$tpl_vars['V_MIN_VISITORS_A_'. strtoupper( $typ ) .'_DATE'] = $_CHC_LANG['unknown'];
		}
		if( ${$var_name}['max_besucher_timestamp'] == 0 )
		{
			$tpl_vars['V_MAX_VISITORS_A_'. strtoupper( $typ ) .'_DATE'] = $_CHC_LANG['unknown'];
		}
		if( ${$var_name}['min_seitenaufrufe_timestamp'] == 0 )
		{
			$tpl_vars['V_MIN_PAGE_VIEWS_A_'. strtoupper( $typ ) .'_DATE'] = $_CHC_LANG['unknown'];
		}
		if( ${$var_name}['max_seitenaufrufe_timestamp'] == 0 )
		{
			$tpl_vars['V_MAX_PAGE_VIEWS_A_'. strtoupper( $typ ) .'_DATE'] = $_CHC_LANG['unknown'];
		}
		$_CHC_TPL->assign( $tpl_vars );
	}





	// Tageszeit / Tag
	$_CHC_TPL->assign( 'L_DAILY_WEEKLY_DISTRIBUTION', $_CHC_LANG['daily_weekly_distribution'] );

	if( !isset( $_GET['distr_type'] ) ||  $_GET['distr_type'] != 'weekdays' )
	{
		$_GET['distr_type'] = 'time_of_day';
		$typ = 'tageszeit';
	}
	else
	{
		$typ = 'wochentag';
	}
	$liste = array(
		'time_of_day'	=> $_CHC_LANG['time_of_day'],
		'weekdays'	=> $_CHC_LANG['weekdays']
	);
	chC_send_select_list_to_tpl( 'DISTR_TYPE', $liste, $_GET['distr_type'] );

	if( !isset( $_GET['distr_of'] ) || $_GET['distr_of'] != 'page_views' )
	{
		$_GET['distr_of'] = 'visitors';
		$visitors_or_page_views = 'besucher';
	}
	else
	{
		$visitors_or_page_views = 'seitenaufrufe';
	}
	$liste = array(
		'visitors'	=> $_CHC_LANG['visitors'],
		'page_views'	=> $_CHC_LANG['page_views']
	);
	chC_send_select_list_to_tpl( 'DISTR_OF', $liste, $_GET['distr_of'] );


	$laufzeit = $_CHC_DB->query(
		'SELECT timestamp
		FROM `'. CHC_TABLE_ACCESS ."`
		WHERE typ = 'tageszeit_wochentag_start'"
	);
	$laufzeit = $_CHC_DB->fetch_assoc( $laufzeit );
	$laufzeit = time() - $laufzeit['timestamp'];


	if( $_GET['distr_type'] == 'time_of_day' )
	{
		$daten = $_CHC_DB->query(
			"SELECT
				".$visitors_or_page_views."_00, ".$visitors_or_page_views."_01, ".$visitors_or_page_views."_02, ".$visitors_or_page_views."_03, ".$visitors_or_page_views."_04, ".$visitors_or_page_views."_05, ".$visitors_or_page_views."_06,
				".$visitors_or_page_views."_07, ".$visitors_or_page_views."_08, ".$visitors_or_page_views."_09, ".$visitors_or_page_views."_10, ".$visitors_or_page_views."_11, ".$visitors_or_page_views."_12, ".$visitors_or_page_views."_13,
				".$visitors_or_page_views."_14, ".$visitors_or_page_views."_15, ".$visitors_or_page_views."_16, ".$visitors_or_page_views."_17, ".$visitors_or_page_views."_18, ".$visitors_or_page_views."_19, ".$visitors_or_page_views."_20,
				".$visitors_or_page_views."_21, ".$visitors_or_page_views."_22, ".$visitors_or_page_views."_23
			FROM `".CHC_TABLE_ACCESS."`
			WHERE typ = 'tageszeit'
			LIMIT 0, 1"
		);
		$daten = $_CHC_DB->fetch_row( $daten );
		$tmp = array();
		$i = 0;
		foreach( $daten as $key => $value )
		{
			$tmp[$i] = array(
				$visitors_or_page_views => $value,
				'tageszeit' => str_pad( (string) ( $i ),  2, '0', STR_PAD_LEFT )
			);
			$i++;
		}
		$daten = $tmp;
		unset( $tmp );

		$anzahl = $_CHC_DB->query(
			"SELECT
				GREATEST( ".$visitors_or_page_views."_00, ".$visitors_or_page_views."_01, ".$visitors_or_page_views."_02, ".$visitors_or_page_views."_03, ".$visitors_or_page_views."_04, ".$visitors_or_page_views."_05, ".$visitors_or_page_views."_06,
				".$visitors_or_page_views."_07, ".$visitors_or_page_views."_08, ".$visitors_or_page_views."_09, ".$visitors_or_page_views."_10, ".$visitors_or_page_views."_11, ".$visitors_or_page_views."_12, ".$visitors_or_page_views."_13,
				".$visitors_or_page_views."_14, ".$visitors_or_page_views."_15, ".$visitors_or_page_views."_16, ".$visitors_or_page_views."_17, ".$visitors_or_page_views."_18, ".$visitors_or_page_views."_19, ".$visitors_or_page_views."_20,
				".$visitors_or_page_views."_21, ".$visitors_or_page_views."_22, ".$visitors_or_page_views."_23)
				as max,
				( ".$visitors_or_page_views."_00 + ".$visitors_or_page_views."_01 + ".$visitors_or_page_views."_02 + ".$visitors_or_page_views."_03 + ".$visitors_or_page_views."_04 + ".$visitors_or_page_views."_05 + ".$visitors_or_page_views."_06
				+ ".$visitors_or_page_views."_07 + ".$visitors_or_page_views."_08 + ".$visitors_or_page_views."_09 + ".$visitors_or_page_views."_10 + ".$visitors_or_page_views."_11 + ".$visitors_or_page_views."_12 + ".$visitors_or_page_views."_13
				+ ".$visitors_or_page_views."_14 + ".$visitors_or_page_views."_15 + ".$visitors_or_page_views."_16 + ".$visitors_or_page_views."_17 + ".$visitors_or_page_views."_18 + ".$visitors_or_page_views."_19 + ".$visitors_or_page_views."_20
				+ ".$visitors_or_page_views."_21 + ".$visitors_or_page_views."_22 + ".$visitors_or_page_views."_23)
				as sum
			FROM `".CHC_TABLE_ACCESS."`
			WHERE typ = 'tageszeit'
			LIMIT 0, 1"
		);
		$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

		$quotient = ceil( $laufzeit / 86400 );

		$count = count( $daten );

		$_CHC_TPL->assign( array(
				'L_HOUR' => $_CHC_LANG['hour'],
				'X_ON_THE_AVERAGE' => sprintf(
					$_CHC_LANG['..._on_the_average'],
					( $_GET['distr_of'] == 'visitors'
						? $_CHC_LANG['visitors']
						: $_CHC_LANG['page_views']
					)
				)
			)
		);
		for( $i = 0; $i < $count; $i++ )
		{
			$percent = @round( $daten[$i][$visitors_or_page_views] / $anzahl['sum'] * 100, 2 );
			$durchschnitt = number_format( @round( $daten[$i][$visitors_or_page_views] / $quotient, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] );
			$_CHC_TPL->add_block( 'TIME_OF_DAY', array(
					'ROW_CLASS_No.'		=> !( $i % 2 ) ? 1 : 2,
					'AVERAGE_LONG'	=> sprintf(
						( $_GET['distr_of'] == 'visitors'
							? $_CHC_LANG['..._visitors_on_the_average']
							: $_CHC_LANG['..._page_views_on_the_average']
						),
						$durchschnitt
					),
					'AVERAGE' => $durchschnitt,
					'TIME_SPAN' => sprintf(
						$_CHC_LANG['...-..._o_clock'],
						$daten[$i]['tageszeit'],
						str_pad( (string) ( $daten[$i]['tageszeit'] + 1 ),  2, '0', STR_PAD_LEFT )
					),
					'GRAPH_PERCENTAGE' => ( $_CHC_CONFIG['darstellungsart_balkendiagramme_zugriffsstatistiken'] == 'absolut' )
						? (int) $percent
						: @round( $daten[$i][$visitors_or_page_views] / $anzahl['max'] * 100 ),
					'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'BAR_No.' => ( $daten[$i][$visitors_or_page_views] == $anzahl['max'] ) ? 2 : 1,
				)
			);
		}
	}
	else
	{
		$daten = $_CHC_DB->query(
			"SELECT
				( ".$visitors_or_page_views."_00 + ".$visitors_or_page_views."_01 + ".$visitors_or_page_views."_02 + ".$visitors_or_page_views."_03 + ".$visitors_or_page_views."_04 + ".$visitors_or_page_views."_05 + ".$visitors_or_page_views."_06
				+ ".$visitors_or_page_views."_07 + ".$visitors_or_page_views."_08 + ".$visitors_or_page_views."_09 + ".$visitors_or_page_views."_10 + ".$visitors_or_page_views."_11 + ".$visitors_or_page_views."_12 + ".$visitors_or_page_views."_13
				+ ".$visitors_or_page_views."_14 + ".$visitors_or_page_views."_15 + ".$visitors_or_page_views."_16 + ".$visitors_or_page_views."_17 + ".$visitors_or_page_views."_18 + ".$visitors_or_page_views."_19 + ".$visitors_or_page_views."_20
				+ ".$visitors_or_page_views."_21 + ".$visitors_or_page_views."_22 + ".$visitors_or_page_views."_23)
				as ".$visitors_or_page_views.", typ
			FROM `". CHC_TABLE_ACCESS ."`
			WHERE typ LIKE 'wochentag\_%'
			ORDER BY typ ASC"
		);
		$daten = $_CHC_DB->fetch_assoc( $daten, 'all' );

		$anzahl = $_CHC_DB->query(
			"SELECT
				MAX( ".$visitors_or_page_views."_00 + ".$visitors_or_page_views."_01 + ".$visitors_or_page_views."_02 + ".$visitors_or_page_views."_03 + ".$visitors_or_page_views."_04 + ".$visitors_or_page_views."_05 + ".$visitors_or_page_views."_06
				+ ".$visitors_or_page_views."_07 + ".$visitors_or_page_views."_08 + ".$visitors_or_page_views."_09 + ".$visitors_or_page_views."_10 + ".$visitors_or_page_views."_11 + ".$visitors_or_page_views."_12 + ".$visitors_or_page_views."_13
				+ ".$visitors_or_page_views."_14 + ".$visitors_or_page_views."_15 + ".$visitors_or_page_views."_16 + ".$visitors_or_page_views."_17 + ".$visitors_or_page_views."_18 + ".$visitors_or_page_views."_19 + ".$visitors_or_page_views."_20
				+ ".$visitors_or_page_views."_21 + ".$visitors_or_page_views."_22 + ".$visitors_or_page_views."_23)
				as max,
				SUM( ".$visitors_or_page_views."_00 + ".$visitors_or_page_views."_01 + ".$visitors_or_page_views."_02 + ".$visitors_or_page_views."_03 + ".$visitors_or_page_views."_04 + ".$visitors_or_page_views."_05 + ".$visitors_or_page_views."_06
				+ ".$visitors_or_page_views."_07 + ".$visitors_or_page_views."_08 + ".$visitors_or_page_views."_09 + ".$visitors_or_page_views."_10 + ".$visitors_or_page_views."_11 + ".$visitors_or_page_views."_12 + ".$visitors_or_page_views."_13
				+ ".$visitors_or_page_views."_14 + ".$visitors_or_page_views."_15 + ".$visitors_or_page_views."_16 + ".$visitors_or_page_views."_17 + ".$visitors_or_page_views."_18 + ".$visitors_or_page_views."_19 + ".$visitors_or_page_views."_20
				+ ".$visitors_or_page_views."_21 + ".$visitors_or_page_views."_22 + ".$visitors_or_page_views."_23)
				as sum
			FROM `". CHC_TABLE_ACCESS ."`
			WHERE typ LIKE 'wochentag\_%'"
		);
		$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

		$quotient = ceil( $laufzeit / 604800 );
		$count = count( $daten );

		$_CHC_TPL->assign( array(
				'L_WEEKDAY' => $_CHC_LANG['weekday'],
				'X_ON_THE_AVERAGE' => sprintf(
					$_CHC_LANG['..._on_the_average'],
					( $_GET['distr_of'] == 'visitors'
						? $_CHC_LANG['visitors']
						: $_CHC_LANG['page_views']
					)
				)
			)
		);
		for( $i = 0; $i < $count; $i++ )
		{
			$wochentag = explode( '_', $daten[$i]['typ'] );
			$wochentag = $wochentag[2];

			$percent = @round( $daten[$i][$visitors_or_page_views] / $anzahl['sum'] * 100, 2 );
			$durchschnitt = @number_format( @round( $daten[$i][$visitors_or_page_views] / $quotient, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] );
			$_CHC_TPL->add_block( 'WEEKDAYS', array(
					'ROW_CLASS_No.'		=> !( $i % 2 ) ? 1 : 2,
					'AVERAGE_LONG'	=> sprintf(
						( $_GET['distr_of'] == 'visitors'
							? $_CHC_LANG['..._visitors_on_the_average']
							: $_CHC_LANG['..._page_views_on_the_average']
						),
						$durchschnitt
					),
					'AVERAGE' =>  $durchschnitt,
					'WEEKDAY_SHORT'		=> chC_localize_date( $wochentag ),
					'WEEKDAY_LONG'		=> chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_weekday:long'], strtotime( $wochentag .' 00:00:00 +0000' ), TRUE, '0' ),
					'GRAPH_PERCENTAGE' => ( $_CHC_CONFIG['darstellungsart_balkendiagramme_zugriffsstatistiken'] == 'absolut' )
						? (int) $percent
						: @round( $daten[$i][$visitors_or_page_views] / $anzahl['max'] * 100 ),
					'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'BAR_No.' => ( $daten[$i][$visitors_or_page_views] == $anzahl['max'] ) ? 2 : 1,
				)
			);
		}
	}





	// DAY XY
	$_CHC_TPL->assign( 'L_DAY_STATS', $_CHC_LANG['day_statistic'] );

	if( isset( $_GET['d_type'] ) && $_GET['d_type'] == 'page_views' )
	{
		$typ = 'seitenaufrufe';
	}
	else
	{
		$_GET['d_type'] = 'visitors';
		$typ = 'besucher';
	}
	$liste = array(
		'visitors'	=> $_CHC_LANG['visitors'],
		'page_views'	=> $_CHC_LANG['page_views']
	);
	chC_send_select_list_to_tpl( 'D_TYPE', $liste, $_GET['d_type'] );


	$day = isset( $_GET['d_day'] ) ? $_GET['d_day'] : chC_format_date( 'd', time(), FALSE );
	$month = isset( $_GET['d_month'] ) ? $_GET['d_month'] : chC_format_date( 'm', time(), FALSE );
	$year = isset( $_GET['d_year'] ) ? $_GET['d_year'] : chC_format_date( 'Y', time(), FALSE );


	$timestamp = gmmktime(
		0,
		0,
		0,
		$month,
		$day,
		$year
	);
	if( $timestamp == -1 )
	{
		$day = chC_format_date( 'd', time(), FALSE );
		$month = chC_format_date( 'm', time(), FALSE );
		$year = chC_format_date( 'Y', time(), FALSE );
		$timestamp = gmmktime(
			0,
			0,
			0,
			$month,
			$day,
			$year
		);
	}

	$liste = array();
	for( $i = 1; $i < 32; $i++ )
	{
		$liste[str_pad( (string) ( $i ),  2, '0', STR_PAD_LEFT )] = $i.'.';
	}
	chC_send_select_list_to_tpl( 'D_DAY', $liste, $day );

	chC_send_select_list_to_tpl( 'D_MONTH', $liste_monate, $month );

	$jahre = $_CHC_DB->query(
		"SELECT timestamp
		FROM `".CHC_TABLE_ACCESS."`
		WHERE typ = 'jahr'
		ORDER BY timestamp DESC"
	);
	$liste_jahre = array();
	while( $row = $_CHC_DB->fetch_array( $jahre ) )
	{
		$jahr = chC_format_date( 'Y', $row['timestamp'], FALSE, '0' );
		$liste_jahre[(string) $jahr] = $jahr;
	}
	chC_send_select_list_to_tpl( 'D_YEAR', $liste_jahre, $year );

	$stunden = $_CHC_DB->query(
		"SELECT
			besucher_00, besucher_01, besucher_02, besucher_03, besucher_04, besucher_05, besucher_06,
			besucher_07, besucher_08, besucher_09, besucher_10, besucher_11, besucher_12, besucher_13,
			besucher_14, besucher_15, besucher_16, besucher_17, besucher_18, besucher_19, besucher_20,
			besucher_21, besucher_22, besucher_23,
			seitenaufrufe_00, seitenaufrufe_01, seitenaufrufe_02, seitenaufrufe_03, seitenaufrufe_04, seitenaufrufe_05, seitenaufrufe_06,
			seitenaufrufe_07, seitenaufrufe_08, seitenaufrufe_09, seitenaufrufe_10, seitenaufrufe_11, seitenaufrufe_12, seitenaufrufe_13,
			seitenaufrufe_14, seitenaufrufe_15, seitenaufrufe_16, seitenaufrufe_17, seitenaufrufe_18, seitenaufrufe_19, seitenaufrufe_20,
			seitenaufrufe_21, seitenaufrufe_22, seitenaufrufe_23
		FROM `".CHC_TABLE_ACCESS."`
		WHERE
			typ = 'tag'
			AND timestamp = ".$timestamp."
		LIMIT 0, 1"
	);

	if( $_CHC_DB->num_rows( $stunden ) == 0 )
	{
		$stunden = array();
		for( $i = 0; $i <= 23; $i++ )
		{
			$stunden['besucher_'. str_pad( (string) ( $i ),  2, '0', STR_PAD_LEFT ) ] = 0;
			$stunden['seitenaufrufe_'. str_pad( (string) ( $i ),  2, '0', STR_PAD_LEFT ) ] = 0;
		}
	}
	else
	{
		$stunden = $_CHC_DB->fetch_assoc( $stunden );
	}

	$anzahl = array(
		'sum' => 0,
		'max' => 0
	);
	$stunden_neu = array();
	# Array mit Feldern durchlaufen. Wenn Typ ungleich dem gewünschten -> weiterspringen. Dadurch wird dann auch max richtig ermittelt.
	# Neues Array bilden $array[std] = array( besucher =>, seitenaufrufe => )
	foreach( $stunden as $field => $value )
	{
		if( !is_int( strpos( $field, $typ ) ) )
		{
			continue;
		}
		$anzahl['sum'] += $value;
		if( $value > $anzahl['max'] )
		{
			$anzahl['max'] = $value;
		}
		$std = substr(
			$field,
			strpos( $field, '_' ) + 1
		);
		$stunden_neu[$std] = array(
			'besucher'	=> $stunden['besucher_'.$std],
			'seitenaufrufe'		=> $stunden['seitenaufrufe_'.$std],
			'std2'	=> str_pad( (string) ( $std + 1 ),  2, '0', STR_PAD_LEFT )
		);
	}
	$stunden = $stunden_neu;
	unset( $stunden_neu );

	$i = 0;
	foreach( $stunden as $std => $array )
	{
		$percent = @round( $array[$typ] / $anzahl['sum'] * 100, 2 );
		$_CHC_TPL->add_block( 'DAY_STATS', array(
				'ROW_CLASS_No.' => !( $i % 2 ) ? 1 : 2,
				'GRAPH_PERCENTAGE' => ( $_CHC_CONFIG['darstellungsart_balkendiagramme_zugriffsstatistiken'] == 'absolut' )
						? (int) $percent
						: @round( $array[$typ] / $anzahl['max'] * 100 ),
				'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
				'BAR_No.' => ( $array[$typ] == $anzahl['max'] ) ? 2 : 1,
				'TIME_SPAN' => sprintf( $_CHC_LANG['...-..._o_clock'], $std, $array['std2'] ),
				'VISITORS' => $array['besucher'],
				'VISITORS_LONG'	=> sprintf( $_CHC_LANG['..._visitors'], $array['besucher'] ),
				'PAGE_VIEWS' => $array['seitenaufrufe'],
				'PAGE_VIEWS_LONG'	=> sprintf( $_CHC_LANG['..._page_views'], $array['seitenaufrufe'] ),
				'VISITORS_FONT_CLASS' => ( $typ == 'besucher' ) ? 'selected' : 'unselected',
				'PAGE_VIEWS_FONT_CLASS' => ( $typ == 'seitenaufrufe' ) ? 'selected' : 'unselected'
			)
		);
		$i++;
	}



	// Kalenderwoche XY
	$_CHC_TPL->assign( 'L_CALENDAR_WEEK_STATS', $_CHC_LANG['calendar_week_statistic'] );

	if( !isset( $_GET['w_type'] ) )
	{
		$_GET['w_type'] = 'visitors';
	}
	switch( $_GET['w_type'] )
	{
		case 'page_views':	$typ = 'seitenaufrufe';
					break;
		default:		$typ = 'besucher';
	}
	$liste = array(
		'visitors'	=> $_CHC_LANG['visitors'],
		'page_views'	=> $_CHC_LANG['page_views']
	);
	chC_send_select_list_to_tpl( 'W_TYPE', $liste, $_GET['w_type'] );

	$month = isset( $_GET['w_month'] ) ? $_GET['w_month'] : chC_format_date( 'm', time(), FALSE );
	$year = isset( $_GET['w_year'] ) ? $_GET['w_year'] : chC_format_date( 'Y', time(), FALSE );

	$timestamp_monatsbeginn = gmmktime(
		0,
		0,
		0,
		$month,
		1,
		$year
	);
	if( $timestamp_monatsbeginn == -1 )
	{
		$month = chC_format_date( 'M', time(), FALSE );
		$year = chC_format_date( 'Y', time(), FALSE );
		$timestamp_monatsbeginn = gmmktime(
			0,
			0,
			0,
			$month,
			1,
			$year
		);
	}
	$timestamp_monatsende = gmmktime(
		0,
		0,
		0,
		gmdate( 'm', $timestamp_monatsbeginn ) +1,
		0,
		gmdate( 'Y', $timestamp_monatsbeginn )
	);

	$erste_kw_des_monats = chC_format_date( 'W', $timestamp_monatsbeginn, FALSE );
	$timestamp_erste_kw_des_monats = chC_get_timestamp_of_cw( $erste_kw_des_monats, $year );
	$wochentag = chC_format_date( 'w', $timestamp_monatsbeginn, FALSE );
	if( $wochentag >= 4 ) // -> Wochentag = Freitag, Samstag oder Sonntag, Woche liegt mit dem Schwerpunkt auf letztem Monat
	{
		$erste_kw_des_monats = chC_format_date( 'W', $timestamp_monatsbeginn + 345600, FALSE ); // 345600 : 4 * 86500 => 4.Tag des Monats = in jedem Fall in erster Woche
		$timestamp_erste_kw_des_monats = chC_get_timestamp_of_cw( $erste_kw_des_monats, $year );
	}

	$anzahl_kws = 4;
	if( (int) chC_format_date( 'W', $timestamp_monatsende, FALSE ) == $erste_kw_des_monats + 4 // 4 : 5 - 1
		&& chC_format_date( 'w', $timestamp_monatsende, FALSE ) >= 4 )
	{
		$anzahl_kws++;
	}


	chC_send_select_list_to_tpl( 'W_MONTH', $liste_monate, $month );
	chC_send_select_list_to_tpl( 'W_YEAR', $liste_jahre, $year );

	$wochen = $_CHC_DB->query(
		"SELECT
			timestamp,
			( besucher_00 + besucher_01 + besucher_02 + besucher_03 + besucher_04 + besucher_05 + besucher_06
			+ besucher_07 + besucher_08 + besucher_09 + besucher_10 + besucher_11 + besucher_12 + besucher_13
			+ besucher_14 + besucher_15 + besucher_16 + besucher_17 + besucher_18 + besucher_19 + besucher_20
			+ besucher_21 + besucher_22 + besucher_23 ) as besucher,
			( seitenaufrufe_00 + seitenaufrufe_01 + seitenaufrufe_02 + seitenaufrufe_03 + seitenaufrufe_04 + seitenaufrufe_05 + seitenaufrufe_06
			+ seitenaufrufe_07 + seitenaufrufe_08 + seitenaufrufe_09 + seitenaufrufe_10 + seitenaufrufe_11 + seitenaufrufe_12 + seitenaufrufe_13
			+ seitenaufrufe_14 + seitenaufrufe_15 + seitenaufrufe_16 + seitenaufrufe_17 + seitenaufrufe_18 + seitenaufrufe_19 + seitenaufrufe_20
			+ seitenaufrufe_21 + seitenaufrufe_22 + seitenaufrufe_23 ) as seitenaufrufe
		FROM `".CHC_TABLE_ACCESS."`
		WHERE
			typ = 'kw'
			AND timestamp >= ". $timestamp_erste_kw_des_monats ."
			AND timestamp <= ". ( $timestamp_erste_kw_des_monats + ($anzahl_kws * 604800) )."
		ORDER BY timestamp ASC
		LIMIT 0, 5"
	);
	$wochen = $_CHC_DB->fetch_assoc( $wochen, 'all' );


	if( count( $wochen ) < $anzahl_kws )
	{
		$tmp_timestamp = $timestamp_erste_kw_des_monats;
		$wochen_neu = array();
		reset( $wochen );
		for( $i = 0; $i < $anzahl_kws; $i++ )
		{
			$array = current( $wochen );
			if( $array['timestamp'] == $tmp_timestamp )
			{
				$wochen_neu[$i] = $array;
				next( $wochen );
			}
			else
			{
				$wochen_neu[$i] = array(
					'timestamp' => $tmp_timestamp,
					'besucher' => 0,
					'seitenaufrufe' => 0
				);
			}
			$tmp_timestamp += 604800; // 604800 = 7 * 86400
		}
		$wochen = $wochen_neu;
		unset( $wochen_neu );
	}

	$anzahl = $_CHC_DB->query(
		"SELECT
			SUM( ".$typ."_00 + ".$typ."_01 + ".$typ."_02 + ".$typ."_03 + ".$typ."_04 + ".$typ."_05 + ".$typ."_06
			+ ".$typ."_07 + ".$typ."_08 + ".$typ."_09 + ".$typ."_10 + ".$typ."_11 + ".$typ."_12 + ".$typ."_13
			+ ".$typ."_14 + ".$typ."_15 + ".$typ."_16 + ".$typ."_17 + ".$typ."_18 + ".$typ."_19 + ".$typ."_20
			+ ".$typ."_21 + ".$typ."_22 + ".$typ."_23 ) as sum,
			MAX( ".$typ."_00 + ".$typ."_01 + ".$typ."_02 + ".$typ."_03 + ".$typ."_04 + ".$typ."_05 + ".$typ."_06
			+ ".$typ."_07 + ".$typ."_08 + ".$typ."_09 + ".$typ."_10 + ".$typ."_11 + ".$typ."_12 + ".$typ."_13
			+ ".$typ."_14 + ".$typ."_15 + ".$typ."_16 + ".$typ."_17 + ".$typ."_18 + ".$typ."_19 + ".$typ."_20
			+ ".$typ."_21 + ".$typ."_22 + ".$typ."_23 ) as max
		FROM `".CHC_TABLE_ACCESS."`
		WHERE
			typ = 'kw'
			AND timestamp >= ". $timestamp_erste_kw_des_monats ."
			AND timestamp <= ". ( $timestamp_erste_kw_des_monats + ($anzahl_kws * 604800) )
	);
	$anzahl = $_CHC_DB->fetch_assoc( $anzahl );



	for( $i = 0; $i < count( $wochen ); $i++ )
	{
		$percent = @round( $wochen[$i][$typ] / $anzahl['sum'] * 100, 2 );
		$_CHC_TPL->add_block( 'WEEK_STATS', array(
				'ROW_CLASS_No.'	=> !( $i % 2 ) ? 1 : 2,
				'GRAPH_PERCENTAGE' => ( $_CHC_CONFIG['darstellungsart_balkendiagramme_zugriffsstatistiken'] == 'absolut' )
						? (int) $percent
						: @round( $wochen[$i][$typ] / $anzahl['max'] * 100 ),
				'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
				'BAR_No.'		=> ( $wochen[$i][$typ] == $anzahl['max'] ) ? 2 : 1,
				'VISITORS' => $wochen[$i]['besucher'],
				'VISITORS_LONG'	=> sprintf( $_CHC_LANG['..._visitors'], $wochen[$i]['besucher'] ),
				'PAGE_VIEWS' => $wochen[$i]['seitenaufrufe'],
				'PAGE_VIEWS_LONG'	=> sprintf( $_CHC_LANG['..._page_views'], $wochen[$i]['seitenaufrufe'] ),
				'VISITORS_FONT_CLASS' => ( $typ == 'besucher' ) ? 'selected' : 'unselected',
				'PAGE_VIEWS_FONT_CLASS' => ( $typ == 'seitenaufrufe' ) ? 'selected' : 'unselected',
				'CALENDAR_WEEK_LONG'		=> sprintf(
					$_CHC_LANG['calendar_week_long'],
					chC_format_date( 'W', $wochen[$i]['timestamp'], TRUE, '0' ),
					chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_calendar_week:beginning,end'], $wochen[$i]['timestamp'], TRUE, '0' ),
					chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_calendar_week:beginning,end'], $wochen[$i]['timestamp'] + 518400, TRUE, '0' )
				),
				'CALENDAR_WEEK_SHORT'		=> sprintf(
					$_CHC_LANG['calendar_week_short'],
					chC_format_date( 'W', $wochen[$i]['timestamp'], FALSE, '0'  )
				),
			)
		);
	}





	// Monat XY
	$_CHC_TPL->assign( 'L_MONTH_STATS', $_CHC_LANG['month_statistic'] );

	if( !isset( $_GET['m_type'] ) )
	{
		$_GET['m_type'] = 'visitors';
	}
	switch( $_GET['m_type'] )
	{
		case 'page_views':	$typ = 'seitenaufrufe';
					break;
		default:		$typ = 'besucher';
	}
	$liste = array(
		'visitors'	=> $_CHC_LANG['visitors'],
		'page_views'	=> $_CHC_LANG['page_views']
	);
	chC_send_select_list_to_tpl( 'M_TYPE', $liste, $_GET['m_type'] );

	$month = isset( $_GET['m_month'] ) ? $_GET['m_month'] : chC_format_date( 'm', time(), FALSE );
	$year = isset( $_GET['m_year'] ) ? $_GET['m_year'] : chC_format_date( 'Y', time(), FALSE );

	$timestamp_start = gmmktime(
		0,
		0,
		0,
		$month,
		1,
		$year
	);
	if( $timestamp_start == -1 )
	{
		$month = chC_format_date( 'm', time(), FALSE );
		$year = chC_format_date( 'Y', time(), FALSE );
		$timestamp_start = gmmktime(
			0,
			0,
			0,
			$month,
			1,
			$year
		);
	}
	$timestamp_stop = gmmktime(
		0,
		0,
		0,
		gmdate( 'm', $timestamp_start ) +1,
		0,
		gmdate( 'Y', $timestamp_start )
	);


	chC_send_select_list_to_tpl( 'M_MONTH', $liste_monate, $month );
	chC_send_select_list_to_tpl( 'M_YEAR', $liste_jahre, $year );


	$tage = $_CHC_DB->query(
		"SELECT
			timestamp,
			( besucher_00 + besucher_01 + besucher_02 + besucher_03 + besucher_04 + besucher_05 + besucher_06
			+ besucher_07 + besucher_08 + besucher_09 + besucher_10 + besucher_11 + besucher_12 + besucher_13
			+ besucher_14 + besucher_15 + besucher_16 + besucher_17 + besucher_18 + besucher_19 + besucher_20
			+ besucher_21 + besucher_22 + besucher_23 ) as besucher,
			( seitenaufrufe_00 + seitenaufrufe_01 + seitenaufrufe_02 + seitenaufrufe_03 + seitenaufrufe_04 + seitenaufrufe_05 + seitenaufrufe_06
			+ seitenaufrufe_07 + seitenaufrufe_08 + seitenaufrufe_09 + seitenaufrufe_10 + seitenaufrufe_11 + seitenaufrufe_12 + seitenaufrufe_13
			+ seitenaufrufe_14 + seitenaufrufe_15 + seitenaufrufe_16 + seitenaufrufe_17 + seitenaufrufe_18 + seitenaufrufe_19 + seitenaufrufe_20
			+ seitenaufrufe_21 + seitenaufrufe_22 + seitenaufrufe_23 ) as seitenaufrufe
		FROM `".CHC_TABLE_ACCESS."`
		WHERE
			typ = 'tag'
			AND timestamp >= ".$timestamp_start."
			AND timestamp <= ".$timestamp_stop."
		ORDER BY timestamp ASC
		LIMIT 0, 31"
	);
	$tage = $_CHC_DB->fetch_assoc( $tage, 'all' );

	$anzahl_tage_des_monats = chC_format_date( 't', $timestamp_start, FALSE, '0' );
	if( count( $tage ) < $anzahl_tage_des_monats )
	{
		$tmp_timestamp = $timestamp_start;
		$tage_neu = array();
		reset( $tage );
		for( $i = 0; $i < $anzahl_tage_des_monats; $i++ )
		{
			$array = current( $tage );
			if( $array['timestamp'] == $tmp_timestamp )
			{
				$tage_neu[$i] = $array;
				next( $tage );
			}
			else
			{
				$tage_neu[$i] = array(
					'timestamp' => $tmp_timestamp,
					'besucher' => 0,
					'seitenaufrufe' => 0
				);
			}
			$tmp_timestamp = $tmp_timestamp + 86400;
		}
		$tage = $tage_neu;
		unset( $tage_neu );
	}

	$anzahl = $_CHC_DB->query(
		"SELECT
			SUM( ".$typ."_00 + ".$typ."_01 + ".$typ."_02 + ".$typ."_03 + ".$typ."_04 + ".$typ."_05 + ".$typ."_06
			+ ".$typ."_07 + ".$typ."_08 + ".$typ."_09 + ".$typ."_10 + ".$typ."_11 + ".$typ."_12 + ".$typ."_13
			+ ".$typ."_14 + ".$typ."_15 + ".$typ."_16 + ".$typ."_17 + ".$typ."_18 + ".$typ."_19 + ".$typ."_20
			+ ".$typ."_21 + ".$typ."_22 + ".$typ."_23 ) as sum,
			MAX( ".$typ."_00 + ".$typ."_01 + ".$typ."_02 + ".$typ."_03 + ".$typ."_04 + ".$typ."_05 + ".$typ."_06
			+ ".$typ."_07 + ".$typ."_08 + ".$typ."_09 + ".$typ."_10 + ".$typ."_11 + ".$typ."_12 + ".$typ."_13
			+ ".$typ."_14 + ".$typ."_15 + ".$typ."_16 + ".$typ."_17 + ".$typ."_18 + ".$typ."_19 + ".$typ."_20
			+ ".$typ."_21 + ".$typ."_22 + ".$typ."_23 ) as max
		FROM `".CHC_TABLE_ACCESS."`
		WHERE
			typ = 'tag'
			AND timestamp >= ".$timestamp_start."
			AND timestamp <= ".$timestamp_stop
	);
	 $anzahl = $_CHC_DB->fetch_assoc(  $anzahl );



	for( $i = 0; $i < count( $tage ); $i++ )
	{
		$percent = @round( $tage[$i][$typ] / $anzahl['sum'] * 100, 2 );
		$_CHC_TPL->add_block( 'MONTH_STATS', array(
				'ROW_CLASS_No.'	=> !( $i % 2 ) ? 1 : 2,
				'GRAPH_PERCENTAGE' => ( $_CHC_CONFIG['darstellungsart_balkendiagramme_zugriffsstatistiken'] == 'absolut' )
						? (int) $percent
						: @round( $tage[$i][$typ] / $anzahl['max'] * 100 ),
				'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
				'BAR_No.'		=> ( $tage[$i][$typ] ==  $anzahl['max'] ) ? 2 : 1,
				'VISITORS' => $tage[$i]['besucher'],
				'VISITORS_LONG'	=> sprintf( $_CHC_LANG['..._visitors'], $tage[$i]['besucher'] ),
				'PAGE_VIEWS' => $tage[$i]['seitenaufrufe'],
				'PAGE_VIEWS_LONG'	=> sprintf( $_CHC_LANG['..._page_views'], $tage[$i]['seitenaufrufe'] ),
				'DAY_SHORT'		=> chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_day:short'],  $tage[$i]['timestamp'], TRUE, '0' ),
				'DAY_LONG'		=> chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_day:long'], $tage[$i]['timestamp'], TRUE, '0' ),
				'VISITORS_FONT_CLASS' => ( $typ == 'besucher' ) ? 'selected' : 'unselected',
				'PAGE_VIEWS_FONT_CLASS' => ( $typ == 'seitenaufrufe' ) ? 'selected' : 'unselected'
			)
		);
	}





	// YEAR XY
	$_CHC_TPL->assign( 'L_YEAR_STATS', $_CHC_LANG['year_statistic'] );

	if( !( isset( $_GET['y_type'] ) && $_GET['y_type'] == 'page_views' ) )
	{
		$_GET['y_type'] = 'visitors';
	}
	$typ = ( $_GET['y_type'] == 'page_views' ) ? 'seitenaufrufe' : 'besucher';
	$liste = array(
		'visitors'	=> $_CHC_LANG['visitors'],
		'page_views'	=> $_CHC_LANG['page_views']
	);
	chC_send_select_list_to_tpl( 'Y_TYPE', $liste, $_GET['y_type'] );

	$year = isset( $_GET['y_year'] ) ? $_GET['y_year'] : chC_format_date( 'Y', time(), FALSE );

	$timestamp_start = gmmktime(
		0,
		0,
		0,
		1,
		1,
		$year
	);
	if( $timestamp_start == -1 )
	{
		$year = chC_format_date( 'Y', time(), FALSE );
		$timestamp_start = gmmktime(
			0,
			0,
			0,
			1,
			1,
			$year
		);
	}
	$timestamp_stop = gmmktime(
		0,
		0,
		0,
		0,
		1,
		gmdate( 'Y', $timestamp_start ) +1
	);

	chC_send_select_list_to_tpl( 'Y_YEAR', $liste_jahre, $year );


	$monate = $_CHC_DB->query(
		"SELECT
			timestamp,
			( besucher_00 + besucher_01 + besucher_02 + besucher_03 + besucher_04 + besucher_05 + besucher_06
			+ besucher_07 + besucher_08 + besucher_09 + besucher_10 + besucher_11 + besucher_12 + besucher_13
			+ besucher_14 + besucher_15 + besucher_16 + besucher_17 + besucher_18 + besucher_19 + besucher_20
			+ besucher_21 + besucher_22 + besucher_23 ) as besucher,
			( seitenaufrufe_00 + seitenaufrufe_01 + seitenaufrufe_02 + seitenaufrufe_03 + seitenaufrufe_04 + seitenaufrufe_05 + seitenaufrufe_06
			+ seitenaufrufe_07 + seitenaufrufe_08 + seitenaufrufe_09 + seitenaufrufe_10 + seitenaufrufe_11 + seitenaufrufe_12 + seitenaufrufe_13
			+ seitenaufrufe_14 + seitenaufrufe_15 + seitenaufrufe_16 + seitenaufrufe_17 + seitenaufrufe_18 + seitenaufrufe_19 + seitenaufrufe_20
			+ seitenaufrufe_21 + seitenaufrufe_22 + seitenaufrufe_23 ) as seitenaufrufe
		FROM `".CHC_TABLE_ACCESS."`
		WHERE
			typ = 'monat'
			AND timestamp >= ".$timestamp_start."
			AND timestamp <= ".$timestamp_stop."
		ORDER BY timestamp ASC"
	);
	$monate = $_CHC_DB->fetch_assoc( $monate, 'all' );

	if( count( $monate ) < 12 )
	{
		$tmp_timestamp = $timestamp_start;
		$monate_neu = array();
		reset( $monate );
		for( $i = 0; $i < 12; $i++ )
		{
			$array = current( $monate );
			if( $array['timestamp'] == $tmp_timestamp )
			{
				$monate_neu[$i] = $array;
				next( $monate );
			}
			else
			{
				$monate_neu[$i] = array(
					'timestamp' => $tmp_timestamp,
					'besucher' => 0,
					'seitenaufrufe' => 0
				);
			}
			$tmp_timestamp = gmmktime(
				0,
				0,
				0,
				gmdate( 'm', $tmp_timestamp ) +1,
				1,
				gmdate( 'Y', $tmp_timestamp )
			);
			#$next_month = strtotime( '+1 month', $tmp_timestamp ); print '|'.$next_month.' '.gmdate('M', $next_month).'|';
			#$tmp_timestamp = strtotime( '1 '. gmdate( 'M', $next_month ) .' '. gmdate( 'Y', $tmp_timestamp ) .' 00:00:00 +0000' );
		}
		$monate = $monate_neu;
		unset( $monate_neu );
	}


	$anzahl = $_CHC_DB->query(
		'SELECT
			SUM( '.$typ."_00 + ".$typ."_01 + ".$typ."_02 + ".$typ."_03 + ".$typ."_04 + ".$typ."_05 + ".$typ."_06
			+ ".$typ."_07 + ".$typ."_08 + ".$typ."_09 + ".$typ."_10 + ".$typ."_11 + ".$typ."_12 + ".$typ."_13
			+ ".$typ."_14 + ".$typ."_15 + ".$typ."_16 + ".$typ."_17 + ".$typ."_18 + ".$typ."_19 + ".$typ."_20
			+ ".$typ."_21 + ".$typ."_22 + ".$typ."_23 ) as sum,
			MAX( ".$typ."_00 + ".$typ."_01 + ".$typ."_02 + ".$typ."_03 + ".$typ."_04 + ".$typ."_05 + ".$typ."_06
			+ ".$typ."_07 + ".$typ."_08 + ".$typ."_09 + ".$typ."_10 + ".$typ."_11 + ".$typ."_12 + ".$typ."_13
			+ ".$typ."_14 + ".$typ."_15 + ".$typ."_16 + ".$typ."_17 + ".$typ."_18 + ".$typ."_19 + ".$typ."_20
			+ ".$typ."_21 + ".$typ."_22 + ".$typ."_23 ) as max
		FROM `".CHC_TABLE_ACCESS."`
		WHERE
			typ = 'monat'
			AND timestamp >= ".$timestamp_start."
			AND timestamp <= ".$timestamp_stop
	);
	$anzahl = $_CHC_DB->fetch_assoc(  $anzahl );


	for( $i = 0; $i < count( $monate ); $i++ )
	{
		$percent = @round( $monate[$i][$typ] / $anzahl['sum'] * 100, 2 );
		$_CHC_TPL->add_block( 'YEAR_STATS', array(
				'ROW_CLASS_No.'	=> !( $i % 2 ) ? 1 : 2,
				'GRAPH_PERCENTAGE' => ( $_CHC_CONFIG['darstellungsart_balkendiagramme_zugriffsstatistiken'] == 'absolut' )
						? (int) $percent
						: @round( $monate[$i][$typ] / $anzahl['max'] * 100 ),
				'BAR_No.'		=> ( $monate[$i][$typ] == $anzahl['max'] ) ? 2 : 1,
				'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
				'VISITORS' => $monate[$i]['besucher'],
				'VISITORS_LONG'	=> sprintf( $_CHC_LANG['..._visitors'], $monate[$i]['besucher'] ),
				'PAGE_VIEWS' => $monate[$i]['seitenaufrufe'],
				'PAGE_VIEWS_LONG'	=> sprintf( $_CHC_LANG['..._page_views'], $monate[$i]['seitenaufrufe'] ),
				'MONTH_SHORT'	=> chC_format_date(
					$_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_month:short'],
					$monate[$i]['timestamp'],
					TRUE,
					'0'
				),
				'MONTH_LONG'	=> chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_month:long'], $monate[$i]['timestamp'], TRUE, '0' ),
				'VISITORS_FONT_CLASS' => ( $typ == 'besucher' ) ? 'selected' : 'unselected',
				'PAGE_VIEWS_FONT_CLASS' => ( $typ == 'seitenaufrufe' ) ? 'selected' : 'unselected'
			)
		);
	}


	// letzten 28 Tage / 12 Monate / Jahre
	$_CHC_TPL->assign( 'L_LAST', $_CHC_LANG['The_last:'] );

	if( !isset( $_GET['l_last'] ) )
	{
		$_GET['l_last'] = '28_days';
	}
	$liste = array(
		'28_days'	=> $_CHC_LANG['28_days'],
		'12_months'	=> $_CHC_LANG['12_months'],
		'years'	=> $_CHC_LANG['years']
	);
	chC_send_select_list_to_tpl( 'L_LAST', $liste, $_GET['l_last'] );

	if( !isset( $_GET['l_type'] ) )
	{
		$_GET['l_type'] = 'visitors';
	}
	switch( $_GET['l_type'] )
	{
		case 'page_views':	$typ = 'seitenaufrufe';
					break;
		default:		$typ = 'besucher';
	}
	$liste = array(
		'visitors'	=> $_CHC_LANG['visitors'],
		'page_views'	=> $_CHC_LANG['page_views']
	);
	chC_send_select_list_to_tpl( 'L_TYPE', $liste, $_GET['l_type'] );

	if( $_GET['l_last'] == '28_days' )
	{
		$_CHC_TPL->assign( 'SHOW_LAST_28_DAYS', TRUE );

		$result = $_CHC_DB->query(
			"SELECT
				timestamp,
				( besucher_00 + besucher_01 + besucher_02 + besucher_03 + besucher_04 + besucher_05 + besucher_06
				+ besucher_07 + besucher_08 + besucher_09 + besucher_10 + besucher_11 + besucher_12 + besucher_13
				+ besucher_14 + besucher_15 + besucher_16 + besucher_17 + besucher_18 + besucher_19 + besucher_20
				+ besucher_21 + besucher_22 + besucher_23 ) as besucher,
				( seitenaufrufe_00 + seitenaufrufe_01 + seitenaufrufe_02 + seitenaufrufe_03 + seitenaufrufe_04 + seitenaufrufe_05 + seitenaufrufe_06
				+ seitenaufrufe_07 + seitenaufrufe_08 + seitenaufrufe_09 + seitenaufrufe_10 + seitenaufrufe_11 + seitenaufrufe_12 + seitenaufrufe_13
				+ seitenaufrufe_14 + seitenaufrufe_15 + seitenaufrufe_16 + seitenaufrufe_17 + seitenaufrufe_18 + seitenaufrufe_19 + seitenaufrufe_20
				+ seitenaufrufe_21 + seitenaufrufe_22 + seitenaufrufe_23 ) as seitenaufrufe
			FROM `".CHC_TABLE_ACCESS."`
			WHERE
				typ = 'tag'
				AND timestamp >= ". ( time() - 2419200 ) .'
			ORDER BY timestamp ASC'
		); // 2419200 = 28 * 86499
		$tage = $_CHC_DB->fetch_assoc( $result, 'all' );


		if( count( $tage ) < 28 )
		{
			$tmp_timestamp = chC_get_timestamp( 'tag' ) - 2332800;
			$tage_neu = array();
			reset( $tage );
			for( $i = 0; $i < 28; $i++ )
			{
				$array = current( $tage );
				if( $array['timestamp'] == $tmp_timestamp )
				{
					$tage_neu[$i] = $array;
					next( $tage );
				}
				else
				{
					$tage_neu[$i] = array(
						'timestamp' => $tmp_timestamp,
						'besucher' => 0,
						'seitenaufrufe' => 0
					);
				}
				$tmp_timestamp += 86400;
			}
			$tage = $tage_neu;
			unset( $tage_neu );
		}

		$result = $_CHC_DB->query(
			"SELECT
				SUM( ".$typ."_00 + ".$typ."_01 + ".$typ."_02 + ".$typ."_03 + ".$typ."_04 + ".$typ."_05 + ".$typ."_06
				+ ".$typ."_07 + ".$typ."_08 + ".$typ."_09 + ".$typ."_10 + ".$typ."_11 + ".$typ."_12 + ".$typ."_13
				+ ".$typ."_14 + ".$typ."_15 + ".$typ."_16 + ".$typ."_17 + ".$typ."_18 + ".$typ."_19 + ".$typ."_20
				+ ".$typ."_21 + ".$typ."_22 + ".$typ."_23 ) as sum,
				MAX( ".$typ."_00 + ".$typ."_01 + ".$typ."_02 + ".$typ."_03 + ".$typ."_04 + ".$typ."_05 + ".$typ."_06
				+ ".$typ."_07 + ".$typ."_08 + ".$typ."_09 + ".$typ."_10 + ".$typ."_11 + ".$typ."_12 + ".$typ."_13
				+ ".$typ."_14 + ".$typ."_15 + ".$typ."_16 + ".$typ."_17 + ".$typ."_18 + ".$typ."_19 + ".$typ."_20
				+ ".$typ."_21 + ".$typ."_22 + ".$typ."_23 ) as max
			FROM `".CHC_TABLE_ACCESS."`
			WHERE
				typ = 'tag'
				AND timestamp >= ". ( time() - 2419200 )
		);
		$anzahl = $_CHC_DB->fetch_assoc( $result );



		for( $i = 0; $i < count( $tage ); $i++ )
		{
			$percent = @round( $tage[$i][$typ] / $anzahl['sum'] * 100, 2 );
			$_CHC_TPL->add_block( 'LAST_28_DAYS', array(
					'ROW_CLASS_No.'	=> !( $i % 2 ) ? 1 : 2,
					'GRAPH_PERCENTAGE' => ( $_CHC_CONFIG['darstellungsart_balkendiagramme_zugriffsstatistiken'] == 'absolut' )
						? (int) $percent
						: @round( $tage[$i][$typ] / $anzahl['max'] * 100 ),
					'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'BAR_No.'		=> ( $tage[$i][$typ] ==  $anzahl['max'] ) ? 2 : 1,
					'VISITORS' => $tage[$i]['besucher'],
					'VISITORS_LONG'	=> sprintf( $_CHC_LANG['..._visitors'], $tage[$i]['besucher'] ),
					'PAGE_VIEWS' => $tage[$i]['seitenaufrufe'],
					'PAGE_VIEWS_LONG'	=> sprintf( $_CHC_LANG['..._page_views'], $tage[$i]['seitenaufrufe'] ),
					'DAY_SHORT'		=> chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_day:short'] ,  $tage[$i]['timestamp'], TRUE, '0' ),
					'DAY_LONG'		=> chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_day:long'] , $tage[$i]['timestamp'], TRUE, '0' ),
					'VISITORS_FONT_CLASS' => ( $typ == 'besucher' ) ? 'selected' : 'unselected',
					'PAGE_VIEWS_FONT_CLASS' => ( $typ == 'seitenaufrufe' ) ? 'selected' : 'unselected'
				)
			);
		}
	}
	elseif( $_GET['l_last'] == '12_months' )
	{
		$_CHC_TPL->assign( 'SHOW_LAST_12_MONTHS', TRUE );

		$timestamp = gmmktime(
			0,
			0,
			0,
			chC_format_date( 'n', time(), FALSE ) -11,
			1,
			chC_format_date( 'y', time(), FALSE )
		);

		$result = $_CHC_DB->query(
			"SELECT
				timestamp,
				( besucher_00 + besucher_01 + besucher_02 + besucher_03 + besucher_04 + besucher_05 + besucher_06
				+ besucher_07 + besucher_08 + besucher_09 + besucher_10 + besucher_11 + besucher_12 + besucher_13
				+ besucher_14 + besucher_15 + besucher_16 + besucher_17 + besucher_18 + besucher_19 + besucher_20
				+ besucher_21 + besucher_22 + besucher_23 ) as besucher,
				( seitenaufrufe_00 + seitenaufrufe_01 + seitenaufrufe_02 + seitenaufrufe_03 + seitenaufrufe_04 + seitenaufrufe_05 + seitenaufrufe_06
				+ seitenaufrufe_07 + seitenaufrufe_08 + seitenaufrufe_09 + seitenaufrufe_10 + seitenaufrufe_11 + seitenaufrufe_12 + seitenaufrufe_13
				+ seitenaufrufe_14 + seitenaufrufe_15 + seitenaufrufe_16 + seitenaufrufe_17 + seitenaufrufe_18 + seitenaufrufe_19 + seitenaufrufe_20
				+ seitenaufrufe_21 + seitenaufrufe_22 + seitenaufrufe_23 ) as seitenaufrufe
			FROM `".CHC_TABLE_ACCESS."`
			WHERE
				typ = 'monat'
				AND timestamp >= ". $timestamp .'
			ORDER BY timestamp ASC'
		);
		$monate = $_CHC_DB->fetch_assoc( $result, 'all' );


		if( count( $monate ) < 12 )
		{
			$monate_neu = array();
			$tmp_timestamp = $timestamp;
			reset( $monate );
			for( $i = 0; $i < 12; $i++ )
			{
				$array = current( $monate );
				if( $array['timestamp'] == $tmp_timestamp )
				{
					$monate_neu[$i] = $array;
					next( $monate );
				}
				else
				{
					$monate_neu[$i] = array(
						'timestamp' => $tmp_timestamp,
						'besucher' => 0,
						'seitenaufrufe' => 0
					);
				}
				$tmp_timestamp = gmmktime(
					0,
					0,
					0,
					gmdate( 'm', $tmp_timestamp ) +1,
					1,
					gmdate( 'Y', $tmp_timestamp )
				);
			}
			$monate = $monate_neu;
			unset( $monate_neu );
		}

		$result = $_CHC_DB->query(
			"SELECT
				SUM( ".$typ."_00 + ".$typ."_01 + ".$typ."_02 + ".$typ."_03 + ".$typ."_04 + ".$typ."_05 + ".$typ."_06
				+ ".$typ."_07 + ".$typ."_08 + ".$typ."_09 + ".$typ."_10 + ".$typ."_11 + ".$typ."_12 + ".$typ."_13
				+ ".$typ."_14 + ".$typ."_15 + ".$typ."_16 + ".$typ."_17 + ".$typ."_18 + ".$typ."_19 + ".$typ."_20
				+ ".$typ."_21 + ".$typ."_22 + ".$typ."_23 ) as sum,
				MAX( ".$typ."_00 + ".$typ."_01 + ".$typ."_02 + ".$typ."_03 + ".$typ."_04 + ".$typ."_05 + ".$typ."_06
				+ ".$typ."_07 + ".$typ."_08 + ".$typ."_09 + ".$typ."_10 + ".$typ."_11 + ".$typ."_12 + ".$typ."_13
				+ ".$typ."_14 + ".$typ."_15 + ".$typ."_16 + ".$typ."_17 + ".$typ."_18 + ".$typ."_19 + ".$typ."_20
				+ ".$typ."_21 + ".$typ."_22 + ".$typ."_23 ) as max
			FROM `".CHC_TABLE_ACCESS."`
			WHERE
				typ = 'monat'
				AND timestamp >= ". $timestamp
		);
		$anzahl = $_CHC_DB->fetch_assoc( $result );



		for( $i = 0; $i < count( $monate ); $i++ )
		{
			$percent = @round( $monate[$i][$typ] / $anzahl['sum'] * 100, 2 );
			$_CHC_TPL->add_block( 'LAST_12_MONTHS', array(
					'ROW_CLASS_No.'	=> !( $i % 2 ) ? 1 : 2,
					'GRAPH_PERCENTAGE' => ( $_CHC_CONFIG['darstellungsart_balkendiagramme_zugriffsstatistiken'] == 'absolut' )
						? (int) $percent
						: @round( $monate[$i][$typ] / $anzahl['max'] * 100 ),
					'BAR_No.'		=> ( $monate[$i][$typ] == $anzahl['max'] ) ? 2 : 1,
					'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'VISITORS' => $monate[$i]['besucher'],
					'VISITORS_LONG'	=> sprintf( $_CHC_LANG['..._visitors'], $monate[$i]['besucher'] ),
					'PAGE_VIEWS' => $monate[$i]['seitenaufrufe'],
					'PAGE_VIEWS_LONG'	=> sprintf( $_CHC_LANG['..._page_views'], $monate[$i]['seitenaufrufe'] ),
					'MONTH_SHORT'	=> chC_format_date(
						$_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_month:short'],
						$monate[$i]['timestamp'],
						TRUE,
						'0'
					),
					'MONTH_LONG'	=> chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_month:long'], $monate[$i]['timestamp'], TRUE, '0' ),
					'VISITORS_FONT_CLASS' => ( $typ == 'besucher' ) ? 'selected' : 'unselected',
					'PAGE_VIEWS_FONT_CLASS' => ( $typ == 'seitenaufrufe' ) ? 'selected' : 'unselected'
				)
			);
		}
	}
	else
	{
		$_CHC_TPL->assign( 'SHOW_LAST_YEARS', TRUE );

		$jahre = $_CHC_DB->query(
			"SELECT
				timestamp,
				( besucher_00 + besucher_01 + besucher_02 + besucher_03 + besucher_04 + besucher_05 + besucher_06
				+ besucher_07 + besucher_08 + besucher_09 + besucher_10 + besucher_11 + besucher_12 + besucher_13
				+ besucher_14 + besucher_15 + besucher_16 + besucher_17 + besucher_18 + besucher_19 + besucher_20
				+ besucher_21 + besucher_22 + besucher_23 ) as besucher,
				( seitenaufrufe_00 + seitenaufrufe_01 + seitenaufrufe_02 + seitenaufrufe_03 + seitenaufrufe_04 + seitenaufrufe_05 + seitenaufrufe_06
				+ seitenaufrufe_07 + seitenaufrufe_08 + seitenaufrufe_09 + seitenaufrufe_10 + seitenaufrufe_11 + seitenaufrufe_12 + seitenaufrufe_13
				+ seitenaufrufe_14 + seitenaufrufe_15 + seitenaufrufe_16 + seitenaufrufe_17 + seitenaufrufe_18 + seitenaufrufe_19 + seitenaufrufe_20
				+ seitenaufrufe_21 + seitenaufrufe_22 + seitenaufrufe_23 ) as seitenaufrufe
			FROM `".CHC_TABLE_ACCESS."`
			WHERE typ = 'jahr'
			ORDER BY timestamp ASC"
		);
		$jahre = $_CHC_DB->fetch_assoc( $jahre, 'all' );


		$anzahl_jahre = (int) chC_format_date( 'Y', $jahre[count( $jahre )-1]['timestamp'], FALSE, '0' )
				- (int) chC_format_date( 'Y', $jahre[0]['timestamp'], FALSE, '0' )
				+1;
		if( count( $jahre ) < $anzahl_jahre )
		{
			#$jahr = chC_format_date( 'Y', $jahre[0]['timestamp'], FALSE, '0' );
			$tmp_timestamp = $jahre[0]['timestamp'];
			$jahre_neu = array();
			reset( $jahre );
			for( $i = 0; $i < $anzahl_jahre; $i++ )
			{
				$array = current( $jahre );
				if( $array['timestamp'] == $tmp_timestamp )
				{
					$jahre_neu[$i] = $array;
					next( $jahre );
				}
				else
				{
					$jahre_neu[$i] = array(
						'timestamp' => $tmp_timestamp,
						'besucher' => 0,
						'seitenaufrufe' => 0
					);
				}
				$tmp_timestamp = gmmktime(
					0,
					0,
					0,
					1,
					1,
					gmdate( 'Y', $tmp_timestamp ) +1
				);
			}
			$jahre = $jahre_neu;
			unset( $jahre_neu );
		}

		$anzahl = $_CHC_DB->query(
			"SELECT
				SUM( ".$typ."_00 + ".$typ."_01 + ".$typ."_02 + ".$typ."_03 + ".$typ."_04 + ".$typ."_05 + ".$typ."_06
				+ ".$typ."_07 + ".$typ."_08 + ".$typ."_09 + ".$typ."_10 + ".$typ."_11 + ".$typ."_12 + ".$typ."_13
				+ ".$typ."_14 + ".$typ."_15 + ".$typ."_16 + ".$typ."_17 + ".$typ."_18 + ".$typ."_19 + ".$typ."_20
				+ ".$typ."_21 + ".$typ."_22 + ".$typ."_23 ) as sum,
				MAX( ".$typ."_00 + ".$typ."_01 + ".$typ."_02 + ".$typ."_03 + ".$typ."_04 + ".$typ."_05 + ".$typ."_06
				+ ".$typ."_07 + ".$typ."_08 + ".$typ."_09 + ".$typ."_10 + ".$typ."_11 + ".$typ."_12 + ".$typ."_13
				+ ".$typ."_14 + ".$typ."_15 + ".$typ."_16 + ".$typ."_17 + ".$typ."_18 + ".$typ."_19 + ".$typ."_20
				+ ".$typ."_21 + ".$typ."_22 + ".$typ."_23 ) as max
			FROM `".CHC_TABLE_ACCESS."`
			WHERE typ = 'jahr'"
		);
		$anzahl = $_CHC_DB->fetch_assoc( $anzahl );



		for( $i = 0; $i < count( $jahre ); $i++ )
		{
			$percent = @round( $jahre[$i][$typ] / $anzahl['sum'] * 100, 2 );
			$_CHC_TPL->add_block( 'LAST_YEARS', array(
					'ROW_CLASS_No.'	=> !( $i % 2 ) ? 1 : 2,
					'GRAPH_PERCENTAGE' => ( $_CHC_CONFIG['darstellungsart_balkendiagramme_zugriffsstatistiken'] == 'absolut' )
						? (int) $percent
						: @round( $jahre[$i][$typ] / $anzahl['max'] * 100 ),
					'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'BAR_No.'		=> ( $jahre[$i][$typ] ==  $anzahl['max'] ) ? 2 : 1,
					'VISITORS' => $jahre[$i]['besucher'],
					'VISITORS_LONG'	=> sprintf( $_CHC_LANG['..._visitors'], $jahre[$i]['besucher'] ),
					'PAGE_VIEWS' => $jahre[$i]['seitenaufrufe'],
					'PAGE_VIEWS_LONG'	=> sprintf( $_CHC_LANG['..._page_views'], $jahre[$i]['seitenaufrufe'] ),
					'YEAR_SHORT'		=> chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_year:short'],  $jahre[$i]['timestamp'], TRUE, '0' ),
					'YEAR_LONG'		=> chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['access_statistics_year:long'], $jahre[$i]['timestamp'], TRUE, '0' ),
					'VISITORS_FONT_CLASS' => ( $typ == 'besucher' ) ? 'selected' : 'unselected',
					'PAGE_VIEWS_FONT_CLASS' => ( $typ == 'seitenaufrufe' ) ? 'selected' : 'unselected'
				)
			);
		}
	}







	$_CHC_TPL->assign( array(
			'L_TIME_OF_DAY' => $_CHC_LANG['time_of_day'],
			'L_DAY_OF_WEEK' => $_CHC_LANG['day_of_week'],
			'L_ACCESS_STATISTICS' => $_CHC_LANG['statistics_access_stats'],
			'L_HOUR' => $_CHC_LANG['hour'],
			'L_DAY' => $_CHC_LANG['day'],
			'L_WEEK' => $_CHC_LANG['week'],
			'L_MONTH' => $_CHC_LANG['month'],
			'L_YEAR' => $_CHC_LANG['year'],
			'L_VISITORS' => $_CHC_LANG['visitors'],
			'L_PAGE_VIEWS' => $_CHC_LANG['page_views']
		)
	);

}
elseif( $_GET['cat'] == 'visitors_details' )
{

	if( is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index:visitors_details;' ) ) )
	{
		$login = chC_manage_login();
		if( chC_logged_in() == FALSE )
		{
			$output = "</form>\n";
			$output .= chC_get_login_form( $login == -1 ? 1 : 0 );
			$output .= "\n<form method=\"GET\" action=\"\">\n";
			$_CHC_TPL->load_template( $output );
			$_CHC_TPL->load_file( CHC_ROOT .'/templates/stats/index_footer.tpl.html' );
			$_CHC_TPL->print_template();
			exit;
		}
	}

	$_CHC_TPL->load_file( CHC_ROOT .'/templates/stats/index_body_visitors_details.tpl.html' );

	$_CHC_TPL->assign( array(
			'L_TOP_BROWSERS'	=> $_CHC_LANG['top_browsers'],
			'L_BROWSER'	=> $_CHC_LANG['browser'],
			'L_TOP_OPERATING_SYSTEMS'	=> $_CHC_LANG['top_operating_systems'],
			'L_OS'	=> $_CHC_LANG['os'],
			'L_TOP_ROBOTS'	=> $_CHC_LANG['top_robots'],
			'L_ROBOT'	=> $_CHC_LANG['robot'],
			'L_TOP_USER_AGENTS'	=> $_CHC_LANG['top_user_agents'],
			'L_USER_AGENT'	=> $_CHC_LANG['user_agent'],
			'L_TOP_COUNTRIES_LANGUAGES_HOSTS'	=> $_CHC_LANG['top_countries_languages_hosts'],
			'L_COUNTRY'	=> $_CHC_LANG['country'],
			'L_LANGUAGE'	=> $_CHC_LANG['language'],
			'L_HOST_TLD'	=> $_CHC_LANG['host_tld'],
			'L_TOP_SCREEN_RESOLUTIONS'	=> $_CHC_LANG['top_screen_resolutions'],
			'L_RESOLUTION'	=> $_CHC_LANG['resolution'],
			'L_SHOW:'	=> $_CHC_LANG['show:']
		)
	);


	// vorhandene Versionen-Aufschlüssungen ermitteln. Werden gebraucht, um bei Browsern/OS beim jeweiligen Eintrag eventuell zu versions.php zu setzen
	$vorhandene_versionen = chC_user_agents_get_available_versions();


	require_once( CHC_ROOT .'/includes/user_agents.lib.php' );







	# Browser
	$_CHC_TPL->assign(
		'V_START_DATE_BROWSERS_STATISTIC',
		sprintf(
			$_CHC_LANG['statistic_running_since:'],
			chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $_CHC_CONFIG['timestamp_start_browser'] )
		)
	);


	$liste = chC_stats_create_list_of_available_months( CHC_TABLE_USER_AGENTS, "typ = 'browser' and monat != 0" );
	$monat = ( isset( $_GET['b_month'] ) && !empty( $_GET['b_month'] ) && isset( $liste[$_GET['b_month']] ) ) ?  $_GET['b_month'] : $aktueller_monat;
	chC_send_select_list_to_tpl( 'B_MONTHS', $liste, $monat );
	$_CHC_TPL->assign( 'B_MONTH', $monat );


	$where_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_browsers'] );
	$where_condition = !empty( $where_condition ) ? 'AND ' . $where_condition : $where_condition;

	$result = chC_stats_select_entries( CHC_TABLE_USER_AGENTS, "typ = 'browser' ". $where_condition, $_CHC_CONFIG['statistiken_anzahl_browser'], $monat );
	if( $_CHC_DB->num_rows( $result ) > 0 )
	{
		$anzahl = chC_stats_select_sum_count_max( CHC_TABLE_USER_AGENTS, "typ = 'browser' ". $where_condition, $monat );
		$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

		$i = 0;
		while( $row = $_CHC_DB->fetch_assoc( $result ) )
		{
			$percent = @round( $row['anzahl'] / $anzahl['sum'] * 100, 2 );
			$blockarray = array(
				'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
				'No.'		=> $i + 1,
				'BROWSER_ICON'	=> isset( $chC_ualib_browsers[$row['wert']]['icon'] ) ? $chC_ualib_browsers[$row['wert']]['icon'] : 'blank.png',
				'BROWSER'	=> chC_str_prepare_for_output( ( $row['wert'] == 'unknown' ? $_CHC_LANG['unknown'] : $row['wert'] ), $_CHC_CONFIG['wordwrap_browser'] ),
				'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
				'GRAPH_PERCENTAGE' => (int) $percent,
				'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
				'BAR_No.'		=> ( $row['anzahl'] == $anzahl['max'] ) ? 2 : 1
			);

			// Wenn dazugehörige Versionen-Aufschlüsselung vorhanden
			if( is_int( strpos( $vorhandene_versionen, $row['wert'] ) ) )
			{
				$blockarray['DETAILS'] = urlencode( $row['wert'] );
			}

			$_CHC_TPL->add_block( 'BROWSERS', $blockarray );
			$i++;
		}
		$_CHC_TPL->assign( array(
				'V_TOTAL_BROWSERS' => $anzahl['count'],
				'V_TOTAL_BROWSERS_INCIDENTS' => $anzahl['sum']
			)
		);
	}




	# Betriebssysteme
	$_CHC_TPL->assign(
		'V_START_DATE_OPERATING_SYSTEMS_STATISTIC',
		sprintf(
			$_CHC_LANG['statistic_running_since:'],
			chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $_CHC_CONFIG['timestamp_start_os'] )
		)
	);

	$liste = chC_stats_create_list_of_available_months( CHC_TABLE_USER_AGENTS, "typ = 'os' and monat != 0" );
	$monat = ( isset( $_GET['os_month'] ) && !empty( $_GET['os_month'] ) && isset( $liste[$_GET['os_month']] ) ) ?  $_GET['os_month'] : $aktueller_monat;
	chC_send_select_list_to_tpl( 'OS_MONTHS', $liste, $monat );
	$_CHC_TPL->assign( 'OS_MONTH', $monat );


	$where_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_os'] );
	$where_condition = !empty( $where_condition ) ? 'AND ' . $where_condition : $where_condition;

	$result = chC_stats_select_entries( CHC_TABLE_USER_AGENTS, "typ = 'os' ". $where_condition, $_CHC_CONFIG['statistiken_anzahl_os'], $monat );
	if( $_CHC_DB->num_rows( $result ) > 0 )
	{
		$anzahl = chC_stats_select_sum_count_max( CHC_TABLE_USER_AGENTS, "typ = 'os' ". $where_condition, $monat );
		$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

		$i = 0;
		while( $row = $_CHC_DB->fetch_assoc( $result ) )
		{
			$percent = @round( $row['anzahl'] / $anzahl['sum'] * 100, 2 );
			$blockarray = array(
				'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
				'No.'		=> $i + 1,
				'OS_ICON'	=> isset( $chC_ualib_os[$row['wert']]['icon'] ) ? $chC_ualib_os[$row['wert']]['icon'] : 'blank.png',
				'OS'		=> chC_str_prepare_for_output( ( $row['wert'] == 'unknown' ? $_CHC_LANG['unknown'] : $row['wert'] ), $_CHC_CONFIG['wordwrap_browser'] ),
				'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
				'GRAPH_PERCENTAGE' => (int) $percent,
				'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
				'BAR_No.'		=> ( $row['anzahl'] == $anzahl['max'] ) ? 2 : 1
			);

			// Wenn dazugehörige Versionen-Aufschlüsselung vorhanden
			if( is_int( strpos( $vorhandene_versionen, $row['wert'] ) ) )
			{
				$blockarray['DETAILS'] = urlencode( $row['wert'] );
			}

			$_CHC_TPL->add_block( 'OS', $blockarray );
			$i++;
		}
		$_CHC_TPL->assign( array(
				'V_TOTAL_OS' => $anzahl['count'],
				'V_TOTAL_OS_INCIDENTS' => $anzahl['sum']
			)
		);
	}


	# Robots
	$_CHC_TPL->assign(
		'V_START_DATE_ROBOTS_STATISTIC',
		sprintf(
			$_CHC_LANG['statistic_running_since:'],
			chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $_CHC_CONFIG['timestamp_start_robots'] )
		)
	);

	$liste = chC_stats_create_list_of_available_months( CHC_TABLE_USER_AGENTS, "typ = 'robot' and monat != 0" );
	$monat = ( isset( $_GET['r_month'] ) && !empty( $_GET['r_month'] ) && isset( $liste[$_GET['r_month']] ) ) ?  $_GET['r_month'] : $aktueller_monat;
	chC_send_select_list_to_tpl( 'R_MONTHS', $liste, $monat );
	$_CHC_TPL->assign( 'R_MONTH', $monat );


	$where_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_robots'] );
	$where_condition = !empty( $where_condition ) ? 'AND ' . $where_condition : $where_condition;

	$result = chC_stats_select_entries( CHC_TABLE_USER_AGENTS, "typ = 'robot' ". $where_condition, $_CHC_CONFIG['statistiken_anzahl_robots'], $monat );
	if( $_CHC_DB->num_rows( $result ) > 0 )
	{
		$anzahl = chC_stats_select_sum_count_max( CHC_TABLE_USER_AGENTS, "typ = 'robot' ". $where_condition, $monat );
		$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

		$i = 0;
		while( $row = $_CHC_DB->fetch_assoc( $result ) )
		{
			$icon = isset( $chC_ualib_robots[$row['wert']]['icon'] ) ? $chC_ualib_robots[$row['wert']]['icon'] : 'robot.png';

			$percent = @round( $row['anzahl'] / $anzahl['sum'] * 100, 2 );
			$blockarray = array(
				'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
				'No.'		=> $i + 1,
				'ROBOT_ICON'	=> $icon,
				'ROBOT'		=> ( $row['wert'] == 'other' ) ? $_CHC_LANG['others'] : $row['wert'],
				'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
				'GRAPH_PERCENTAGE' => (int) $percent,
				'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
				'BAR_No.'		=> ( $row['anzahl'] == $anzahl['max'] ) ? 2 : 1
			);

			// Wenn dazugehörige Versionen-Aufschlüsselung vorhanden
			if( is_int( strpos( $vorhandene_versionen, $row['wert'] ) ) )
			{
				$blockarray['DETAILS'] = ( $row['wert'] == 'other' ) ? 'other_robots' : urlencode( $row['wert'] );
			}

			$_CHC_TPL->add_block( 'ROBOTS', $blockarray );
			$i++;
		}
		$_CHC_TPL->assign( array(
				'V_TOTAL_ROBOTS' => $anzahl['count'],
				'V_TOTAL_ROBOTS_INCIDENTS' => $anzahl['sum']
			)
		);
	}



	# User-Agents
	$_CHC_TPL->assign(
		'V_START_DATE_USER_AGENTS_STATISTIC',
		sprintf(
			$_CHC_LANG['statistic_running_since:'],
			chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $_CHC_CONFIG['timestamp_start_user_agents'] )
		)
	);

	$where_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_user_agents'] );
	$where_condition = !empty( $where_condition ) ? 'AND ' . $where_condition : $where_condition;

	$result = $_CHC_DB->query(
		"SELECT wert, anzahl
		FROM `".CHC_TABLE_USER_AGENTS."`
		WHERE typ = 'user_agent' ". $where_condition ." AND wert != '__chC:more__'
		ORDER BY anzahl DESC
		LIMIT 0, ".$_CHC_CONFIG['statistiken_anzahl_user_agents']
	);
	if( $_CHC_DB->num_rows( $result ) > 0 )
	{
		$i = 0;
		$anzahl = $_CHC_DB->query(
			"SELECT
				SUM(anzahl) as sum,
				COUNT(typ) as count,
				MAX(anzahl) as max
			FROM `".CHC_TABLE_USER_AGENTS."`
			WHERE typ = 'user_agent' ". $where_condition ." AND wert != '__chC:more__'"
		);
		$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

		while( $row = $_CHC_DB->fetch_assoc( $result ) )
		{
			$percent = @round( $row['anzahl'] / $anzahl['sum'] * 100, 2 );

			$row['wert'] = ( $_CHC_CONFIG['user_agents_kuerzen_nach'] > 0 && strlen( $row['wert'] ) > $_CHC_CONFIG['user_agents_kuerzen_nach'] )
				? substr( $row['wert'], 0, $_CHC_CONFIG['user_agents_kuerzen_nach'] ) . $_CHC_CONFIG['user_agents_kuerzungszeichen']
				: $row['wert'];

			$_CHC_TPL->add_block( 'USER_AGENTS', array(
					'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
					'No.'		=> $i + 1,
					'USER_AGENT'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_user_agents'] ),
					'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'GRAPH_PERCENTAGE' => (int) $percent,
					'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'BAR_No.'		=> ( $row['anzahl'] == $anzahl['max'] ) ? 2 : 1
			      )
			);
			$i++;
		}
		$_CHC_TPL->assign( array(
				'V_TOTAL_USER_AGENTS' => $anzahl['count'],
				'V_TOTAL_USER_AGENTS_INCIDENTS' => $anzahl['sum']
			)
		);
	}




	# Länder o. Sprachen
	if( !isset( $_GET['clh'] ) )
	{
		$_GET['clh'] = 'c';
	}

	$liste = array(
			'c' =>	$_CHC_LANG['countries'],
			'l' =>	$_CHC_LANG['languages'],
			'h' =>	$_CHC_LANG['hosts_tlds']
		);
	chC_send_select_list_to_tpl( 'COUNTRIES_LANGUAGES_HOSTS_SELECT', $liste, $_GET['clh'] );


	switch( $_GET['clh'] )
	{
		case 'l':	$typ = 'language'; break;
		case 'h':	$typ = 'host'; break;
		default:	$typ = 'country';
	}
	$liste = chC_stats_create_list_of_available_months( CHC_TABLE_LOCALE_INFORMATION, "typ = '". $typ ."'" );
	$monat = ( isset( $_GET['clh_month'] ) && !empty( $_GET['clh_month'] ) && isset( $liste[$_GET['clh_month']] ) ) ?  $_GET['clh_month'] : $aktueller_monat;
	chC_send_select_list_to_tpl( 'CLH_MONTHS', $liste, $monat );
	$_CHC_TPL->assign( 'CLH_MONTH', $monat );


	if( $_GET['clh'] == 'l' ) # languages
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_sprachen'];

		$locale_information = 'languages';
		$_CHC_TPL->assign( 'LANGUAGES_STATISTIC', '_' );

		$result = chC_stats_select_entries( CHC_TABLE_LOCALE_INFORMATION, "typ = 'language'", $_CHC_CONFIG['statistiken_anzahl_sprachen'], $monat );
		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( CHC_TABLE_LOCALE_INFORMATION, "typ = 'language'", $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$i = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$row['wert'] = isset( $_CHC_LANG['lib_languages'][$row['wert']] ) ? $_CHC_LANG['lib_languages'][$row['wert']] : '? ('.$row['wert'].')';

				$percent = @round( $row['anzahl'] / $anzahl['sum'] * 100, 2 );
				$_CHC_TPL->add_block( 'LANGUAGES', array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'LANGUAGE'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_sprachen'] ),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'GRAPH_PERCENTAGE' => (int) $percent,
						'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'BAR_No.'		=> ( $row['anzahl'] == $anzahl['max'] ) ? 2 : 1
					)
				);
				$i++;
			}
			$_CHC_TPL->assign( array(
					'V_TOTAL_LANGUAGES' => $anzahl['count'],
					'V_TOTAL_LANGUAGES_INCIDENTS' => $anzahl['sum']
				)
			);
		}
	}
	elseif( $_GET['clh'] == 'h' )
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_hosts_tlds'];

		$_CHC_TPL->assign( 'HOSTS_TLDS_STATISTIC', '_' );

		$result = chC_stats_select_entries( CHC_TABLE_LOCALE_INFORMATION, "typ = 'host_tld'", $_CHC_CONFIG['statistiken_anzahl_hosts_tlds'], $monat );
		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( CHC_TABLE_LOCALE_INFORMATION, "typ = 'host_tld'", $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$i = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				if( $row['wert'][0] == '.' )
				{
					$row['wert'] = substr( $row['wert'], 1 );
					$dotted = TRUE;
				}
				else
				{
					unset( $dotted );
				}
				$img = is_file( CHC_ROOT .'/images/flags/'.$row['wert'].'.gif' ) ? $row['wert'] .'.gif' : 'unknown.png';

				if( $row['wert'] == 'unresolved' )
				{
					$row['wert'] = $_CHC_LANG['unresolved'];
				}
				elseif( isset( $_CHC_LANG['lib_countries'][$row['wert']] )  )
				{
					$row['wert'] = $_CHC_LANG['lib_countries'][$row['wert']];
				}
				elseif( isset( $_CHC_LANG['lib_TLDs'][$row['wert']] ) )
				{
					$row['wert'] = $_CHC_LANG['lib_TLDs'][$row['wert']];
				}
				else
				{
					 $row['wert'] = isset( $dotted ) ? '.'. $row['wert'] : $row['wert'];
				}

				$percent = @round( $row['anzahl'] / $anzahl['sum'] * 100, 2 );
				$_CHC_TPL->add_block( 'HOSTS_TLDS', array(
						'ROW_CLASS_NR'        => !( $i % 2 ) ? 1 : 2,
						'No.'                => $i + 1,
						'FLAG'                => $img,
						'TLD'        => chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_hosts_tlds'] ),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'GRAPH_PERCENTAGE' => (int) $percent,
						'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'BAR_No.'		=> ( $row['anzahl'] == $anzahl['max'] ) ? 2 : 1
				      )
				);
				$i++;
			}
			$_CHC_TPL->assign( array(
					'V_TOTAL_TLDS' => $anzahl['count'],
					'V_TOTAL_TLDS_INCIDENTS' => $anzahl['sum']
				)
			);
		}
	}
	else
	{
		$statistikstart = $_CHC_CONFIG['timestamp_start_laender'];

		$_CHC_TPL->assign( 'COUNTRIES_STATISTIC', '' );

		$result = chC_stats_select_entries( CHC_TABLE_LOCALE_INFORMATION, "typ = 'country'", $_CHC_CONFIG['statistiken_anzahl_laender'], $monat );
		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( CHC_TABLE_LOCALE_INFORMATION, "typ = 'country'", $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );
				
			$i = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$percent = @round( $row['anzahl'] / $anzahl['sum'] * 100, 2 );
				$_CHC_TPL->add_block( 'COUNTRIES', array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'FLAG'		=> is_file( CHC_ROOT .'/images/flags/'.$row['wert'].'.gif' ) ? $row['wert'].'.gif' : 'unknown.png',
						'COUNTRY'	=> chC_str_prepare_for_output(
									isset( $_CHC_LANG['lib_countries'][$row['wert']] )
										? $_CHC_LANG['lib_countries'][$row['wert']]
										: '? ('.strtoupper( $row['wert'] ).')' ,
									$_CHC_CONFIG['wordwrap_laender'] ),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'GRAPH_PERCENTAGE' => (int) $percent,
						'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'BAR_No.'		=> ( $row['anzahl'] == $anzahl['max'] ) ? 2 : 1
					)
				);
				$i++;
			}
			$_CHC_TPL->assign( array(
					'V_TOTAL_COUNTRIES' => $anzahl['count'],
					'V_TOTAL_COUNTRIES_INCIDENTS' => $anzahl['sum']
				)
			);
		}
	}
	$_CHC_TPL->assign(
		'V_START_DATE_COUNTRIES_OR_LANGUAGES_OR_HOSTS_STATISTIC',
		sprintf(
			$_CHC_LANG['statistic_running_since:'],
			chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $statistikstart )
		)
	);




	# Auflösungen
	$_CHC_TPL->assign(
		'V_START_DATE_RESOLUTIONS_STATISTIC',
		sprintf(
			$_CHC_LANG['statistic_running_since:'],
			chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $_CHC_CONFIG['timestamp_start_aufloesungen'] )
		)
	);


	$liste = chC_stats_create_list_of_available_months( CHC_TABLE_SCREEN_RESOLUTIONS );
	$monat = ( isset( $_GET['res_month'] ) && !empty( $_GET['res_month'] ) && isset( $liste[$_GET['res_month']] ) ) ?  $_GET['res_month'] : $aktueller_monat;
	chC_send_select_list_to_tpl( 'RES_MONTHS', $liste, $monat );
	$_CHC_TPL->assign( 'RES_MONTH', $monat );

	$where_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_screen_resolutions'] );
	$where_condition = !empty( $where_condition ) ? 'WHERE ' . $where_condition : $where_condition;

	$result = chC_stats_select_entries( CHC_TABLE_SCREEN_RESOLUTIONS, $where_condition, $_CHC_CONFIG['statistiken_anzahl_aufloesungen'], $monat );
	if( $_CHC_DB->num_rows( $result ) > 0 )
	{
		$anzahl = chC_stats_select_sum_count_max( CHC_TABLE_SCREEN_RESOLUTIONS, $where_condition, $monat );
		$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

		$i = 0;
		while( $row = $_CHC_DB->fetch_assoc( $result ) )
		{
			$percent = @round( $row['anzahl'] / $anzahl['sum'] * 100, 2 );
			$_CHC_TPL->add_block( 'RESOLUTIONS', array(
					'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
					'No.'		=> $i + 1,
					'RESOLUTION'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_aufloesungen'] ),
					'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'GRAPH_PERCENTAGE' => (int) $percent,
					'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'BAR_No.'		=> ( $row['anzahl'] == $anzahl['max'] ) ? 2 : 1
			      )
			);
			$i++;
		}
		$_CHC_TPL->assign( array(
				'V_TOTAL_RESOLUTIONS' => $anzahl['count'],
				'V_TOTAL_RESOLUTIONS_INCIDENTS' => $anzahl['sum']
			)
		);
	}

}
elseif( $_GET['cat'] == 'referrers' )
{

	if( is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index:referrers;' ) ) )
	{
		$login = chC_manage_login();
		if( chC_logged_in() == FALSE )
		{
			$output = "</form>\n";
			$output .= chC_get_login_form( $login == -1 ? 1 : 0 );
			$output .= "\n<form method=\"GET\" action=\"\">\n";
			$_CHC_TPL->load_template( $output );
			$_CHC_TPL->load_file( CHC_ROOT .'/templates/stats/index_footer.tpl.html' );
			$_CHC_TPL->print_template();
			exit;
		}
	}

	$_CHC_TPL->load_file( CHC_ROOT .'/templates/stats/index_body_referrers.tpl.html' );

	if( $_CHC_CONFIG['fremde_URLs_verlinken'] == "1" )
	{
		$_CHC_TPL->assign( 'LINK_URLs' , '1' );
	}




	# referrer
	$_CHC_TPL->assign(
		'V_START_DATE_REFERRERS_STATISTIC',
		sprintf(
			$_CHC_LANG['statistic_running_since:'],
			chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $_CHC_CONFIG['timestamp_start_referrer'] )
		)
	);

	$liste = chC_stats_create_list_of_available_months( CHC_TABLE_REFERRERS, "typ = 'referrer'" );
	$monat = ( isset( $_GET['ref_month'] ) && !empty( $_GET['ref_month'] ) && isset( $liste[$_GET['ref_month']] ) ) ?  $_GET['ref_month'] : $aktueller_monat;
	chC_send_select_list_to_tpl( 'REF_MONTHS', $liste, $monat );
	$_CHC_TPL->assign( 'REF_MONTH', $monat );

	$where_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_referrers'] );
	$where_condition = !empty( $where_condition ) ? 'AND ' . $where_condition : $where_condition;

	$result = chC_stats_select_entries( CHC_TABLE_REFERRERS, "typ = 'referrer' ". $where_condition, $_CHC_CONFIG['statistiken_anzahl_referrer'], $monat );
	if( $_CHC_DB->num_rows( $result ) > 0 )
	{
		$anzahl = chC_stats_select_sum_count_max( CHC_TABLE_REFERRERS, "typ = 'referrer' AND wert != '__chC:more__'". $where_condition, $monat );
		$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

		$i = 0;
		while( $row = $_CHC_DB->fetch_assoc( $result ) )
		{
			$percent = @round( $row['anzahl'] / $anzahl['sum'] * 100, 2 );

			$referrer_kurz = ( $_CHC_CONFIG['referrer_kuerzen_nach'] > 0 && strlen( $row['wert'] ) > $_CHC_CONFIG['referrer_kuerzen_nach'] )
				? substr( $row['wert'], 0, $_CHC_CONFIG['referrer_kuerzen_nach'] ) . $_CHC_CONFIG['referrer_kuerzungszeichen']
				: $row['wert'];

			$_CHC_TPL->add_block( 'REFERRERS', array(
					'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
					'No.'		=> $i + 1,
					'URL'		=> htmlentities( $row['wert'] ),
					'REFERRER'	=> chC_str_prepare_for_output( $referrer_kurz, $_CHC_CONFIG['wordwrap_referrer'] ),
					'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'GRAPH_PERCENTAGE' => (int) $percent,
					'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'BAR_No.'		=> ( $row['anzahl'] == $anzahl['max'] ) ? 2 : 1
				)
			);
			$i++;
		}
		$_CHC_TPL->assign( array(
				'V_TOTAL_REFERRERS' => $anzahl['count'],
				'V_TOTAL_REFERRERS_INCIDENTS' => $anzahl['sum']
			)
		);
	}



	# referrer-domains
	$_CHC_TPL->assign(
		'V_START_DATE_REFERRING_DOMAINS_STATISTIC',
		sprintf(
			$_CHC_LANG['statistic_running_since:'],
			chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $_CHC_CONFIG['timestamp_start_verweisende_domains'] )
		)
	);

	$liste = chC_stats_create_list_of_available_months( CHC_TABLE_REFERRERS, "typ = 'domain'" );
	$monat = ( isset( $_GET['refdom_month'] ) && !empty( $_GET['refdom_month'] ) && isset( $liste[$_GET['refdom_month']] ) ) ?  $_GET['refdom_month'] : $aktueller_monat;
	chC_send_select_list_to_tpl( 'REFDOM_MONTHS', $liste, $monat );
	$_CHC_TPL->assign( 'REFDOM_MONTH', $monat );

	$where_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_referring_domains'] );
	$where_condition = !empty( $where_condition ) ? 'AND ' . $where_condition : $where_condition;

	$result = chC_stats_select_entries( CHC_TABLE_REFERRERS, "typ = 'domain' AND wert != '__chC:more__'". $where_condition, $_CHC_CONFIG['statistiken_anzahl_refdomains'], $monat );
	if( $_CHC_DB->num_rows( $result ) > 0 )
	{
		$anzahl = chC_stats_select_sum_count_max( CHC_TABLE_REFERRERS, "typ = 'domain' AND wert != '__chC:more__'". $where_condition, $monat );
		$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

		$i = 0;
		while( $row = $_CHC_DB->fetch_assoc( $result ) )
		{
			$percent = @round( $row['anzahl'] / $anzahl['sum'] * 100, 2 );

			$refdomain_kurz = ( $_CHC_CONFIG['referrer_kuerzen_nach'] > 0 && strlen( $row['wert'] ) > $_CHC_CONFIG['referrer_kuerzen_nach'] )
				? substr( $row['wert'], 0, $_CHC_CONFIG['referrer_kuerzen_nach'] ) . $_CHC_CONFIG['referrer_kuerzungszeichen']
				: $row['wert'];

			if( substr( $row['wert'], 0, 9 ) == 'localhost' )
			{
				$row['wert'] = 'http://'. $row['wert'];
			}

			$_CHC_TPL->add_block( 'REFERRERING_DOMAINS', array(
					'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
					'No.'		=> $i + 1,
					'URL'		=> 'http://'. htmlentities( $row['wert'] ),
					'REFERRING_DOMAIN'	=> chC_str_prepare_for_output( $refdomain_kurz, $_CHC_CONFIG['wordwrap_refdomains'] ),
					'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'GRAPH_PERCENTAGE' => (int) $percent,
					'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'BAR_No.'		=> ( $row['anzahl'] == $anzahl['max'] ) ? 2 : 1
				)
			);
			$i++;
		}
		$_CHC_TPL->assign( array(
				'V_TOTAL_REFERRERING_DOMAINS' => $anzahl['count'],
				'V_TOTAL_REFERRERING_DOMAINS_INCIDENTS' => $anzahl['sum']
			)
		);
	}


	# Suchmaschinen
	$_CHC_TPL->assign(
		'V_START_DATE_SEARCH_ENGINES_STATISTIC',
		sprintf(
			$_CHC_LANG['statistic_running_since:'],
			chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $_CHC_CONFIG['timestamp_start_suchmaschinen'] )
		)
	);

	$liste = chC_stats_create_list_of_available_months( CHC_TABLE_SEARCH_ENGINES, "typ = 'suchmaschine'" );
	$monat = ( isset( $_GET['se_month'] ) && !empty( $_GET['se_month'] ) && isset( $liste[$_GET['se_month']] ) ) ?  $_GET['se_month'] : $aktueller_monat;
	chC_send_select_list_to_tpl( 'SE_MONTHS', $liste, $monat );
	$_CHC_TPL->assign( 'SE_MONTH', $monat );

	$where_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_search_engines'] );
	$where_condition = !empty( $where_condition ) ? 'AND ' . $where_condition : $where_condition;

	$result = chC_stats_select_entries( CHC_TABLE_SEARCH_ENGINES, "typ = 'suchmaschine' ". $where_condition, $_CHC_CONFIG['statistiken_anzahl_suchmaschinen'], $monat );
	if( $_CHC_DB->num_rows( $result ) > 0 )
	{
		require_once( CHC_ROOT .'/includes/search_engines.lib.php' );

		$anzahl = chC_stats_select_sum_count_max( CHC_TABLE_SEARCH_ENGINES, "typ = 'suchmaschine' ". $where_condition, $monat );
		$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

		$i = 0;
		while( $row = $_CHC_DB->fetch_assoc( $result ) )
		{
			$percent = @round( $row['anzahl'] / $anzahl['sum'] * 100, 2 );
			$_CHC_TPL->add_block( 'SEARCH_ENGINES', array(
					'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
					'No.'		=> $i + 1,
					'IMG' => isset( $chC_search_engines[$row['wert']] ) ? $chC_search_engines[$row['wert']]['icon'] : 'search_engine.png',
					'SEARCH_ENGINE'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_suchmaschinen'] ),
					'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'GRAPH_PERCENTAGE' => (int) $percent,
					'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'BAR_No.'		=> ( $row['anzahl'] == $anzahl['max'] ) ? 2 : 1
				  )
			);
			$i++;
		}
		$_CHC_TPL->assign( array(
				'V_TOTAL_SEARCH_ENGINES' => $anzahl['count'],
				'V_TOTAL_SEARCH_ENGINES_INCIDENTS' => $anzahl['sum']
			)
		);
	}




	# Suchwörter / Suchphrasen
	$_CHC_TPL->assign(
		'V_START_DATE_SEARCH_KEYWORDS_PHRASES_STATISTIC',
		sprintf(
			$_CHC_LANG['statistic_running_since:'],
			chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $_CHC_CONFIG['timestamp_start_suchwoerter_suchphrasen'] )
		)
	);

	if( !isset( $_GET['kp'] ) )
	{
		$_GET['kp'] = 'keywords';
	}

	$liste = array(
			'keywords' =>	$_CHC_LANG['search_keywords'],
			'search_phrases' =>	$_CHC_LANG['search_phrases']
		);
	chC_send_select_list_to_tpl( 'SEARCH_KEYWORDS_PHRASES_SELECT', $liste, $_GET['kp'] );

	$typ = ( $_GET['kp'] == 'search_phrases' ) ? 'suchphrase' : 'suchwort';
	$liste = chC_stats_create_list_of_available_months( CHC_TABLE_SEARCH_ENGINES, "typ = '". $typ ."'" );
	$monat = ( isset( $_GET['kp_month'] ) && !empty( $_GET['kp_month'] ) && isset( $liste[$_GET['kp_month']] ) ) ?  $_GET['kp_month'] : $aktueller_monat;
	chC_send_select_list_to_tpl( 'KP_MONTHS', $liste, $monat );
	$_CHC_TPL->assign( 'KP_MONTH', $monat );

	if( $_GET['kp'] == 'keywords' )
	{
		$_CHC_TPL->assign( 'KEYWORDS_STATISTIC', TRUE );

		$where_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_keywords'] );
		$where_condition = !empty( $where_condition ) ? 'AND ' . $where_condition : $where_condition;

		$result = chC_stats_select_entries( CHC_TABLE_SEARCH_ENGINES, "typ = 'suchwort' ". $where_condition, $_CHC_CONFIG['statistiken_anzahl_suchwoerter'], $monat );
		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( CHC_TABLE_SEARCH_ENGINES, "typ = 'suchwort' ". $where_condition, $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$i = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$percent = @round( $row['anzahl'] / $anzahl['sum'] * 100, 2 );
				$_CHC_TPL->add_block( 'KEYWORDS', array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'KEYWORD'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_suchwoerter'] ),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'GRAPH_PERCENTAGE' => (int) $percent,
						'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'BAR_No.'		=> ( $row['anzahl'] == $anzahl['max'] ) ? 2 : 1
					)
				);
				$i++;
			}
			$_CHC_TPL->assign( array(
					'V_TOTAL_KEYWORDS' => $anzahl['count'],
					'V_TOTAL_KEYWORDS_INCIDENTS' => $anzahl['sum']
				)
			);
		}
	}
	else
	{
		$_CHC_TPL->assign( 'SEARCH_PHRASES_STATISTIC', TRUE );

		$where_condition = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_search_phrases'] );
		$where_condition = !empty( $where_condition ) ? 'AND ' . $where_condition : $where_condition;

		$result = chC_stats_select_entries( CHC_TABLE_SEARCH_ENGINES, "typ = 'suchphrase' ". $where_condition, $_CHC_CONFIG['statistiken_anzahl_suchphrasen'], $monat );
		if( $_CHC_DB->num_rows( $result ) > 0 )
		{
			$anzahl = chC_stats_select_sum_count_max( CHC_TABLE_SEARCH_ENGINES, "typ = 'suchphrase' ". $where_condition, $monat );
			$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

			$i = 0;
			while( $row = $_CHC_DB->fetch_assoc( $result ) )
			{
				$percent = @round( $row['anzahl'] / $anzahl['sum'] * 100, 2 );
				$_CHC_TPL->add_block( 'SEARCH_PHRASES', array(
						'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
						'No.'		=> $i + 1,
						'SEARCH_PHRASE'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_suchphrasen'] ),
						'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'GRAPH_PERCENTAGE' => (int) $percent,
						'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
						'BAR_No.'		=> ( $row['anzahl'] == $anzahl['max'] ) ? 2 : 1
					)
				);
				$i++;
			}
			$_CHC_TPL->assign( array(
					'V_TOTAL_SEARCH_PHRASES' => $anzahl['count'],
					'V_TOTAL_SEARCH_PHRASES_INCIDENTS' => $anzahl['sum']
				)
			);
		}
	}


	$_CHC_TPL->assign( array(
			'L_MORE'                => $_CHC_LANG['more'],
			'L_TOP_REFERRERS'                => $_CHC_LANG['top_referrers'],
			'L_REFERRER'                => $_CHC_LANG['referrer'],
			'L_TOP_REFERRING_DOMAINS'                => $_CHC_LANG['top_referring_domains'],
			'L_DOMAIN'                => $_CHC_LANG['domain'],
			'L_TOP_SEARCH_KEYWORDS_PHRASES'                => $_CHC_LANG['top_search_keywords_phrases'],
			'L_SHOW:'	=> $_CHC_LANG['show:'],
			'L_KEYWORD'                => $_CHC_LANG['search_keyword'],
			'L_SEARCH_PHRASE' => $_CHC_LANG['search_phrase'],
			'L_TOP_SEARCH_ENGINES' => $_CHC_LANG['top_search_engines'],
			'L_SEARCH_ENGINE' => $_CHC_LANG['search_engine'],
		)
	);

}
elseif( $_GET['cat'] == 'pages' )
{
	$login = chC_manage_login();
	if( is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index:pages;' ) ) )
	{
		if( chC_logged_in() == FALSE )
		{
			$output = "</form>\n";
			$output .= chC_get_login_form( $login == -1 ? 1 : 0 );
			$output .= "\n<form method=\"GET\" action=\"\">\n";
			$_CHC_TPL->load_template( $output );
			$_CHC_TPL->load_file( CHC_ROOT .'/templates/stats/index_footer.tpl.html' );
			$_CHC_TPL->print_template();
			exit;
		}
	}

	$_CHC_TPL->load_file( CHC_ROOT .'/templates/stats/index_body_pages.tpl.html' );


	if( chC_logged_in() == 'admin' )
	{
		$_CHC_TPL->assign( 'IS_ADMIN', '' );
	}


	// online users
         /*
	$result = $_CHC_DB->query(
		'SELECT DISTINCT o.nr, o.ip, o.seite, o.homepage_id, o.timestamp_erster_aufruf, o.timestamp_letzter_aufruf, o.seitenaufrufe, o.user_agent, s.titel, s.counter_verzeichnis
		FROM `'. CHC_TABLE_PAGES .'` as s , `'. CHC_TABLE_ONLINE_USERS .'` as o
		WHERE
			o.seite = s.wert AND o.homepage_id = s.homepage_id
			AND o.timestamp_letzter_aufruf >= '. ( CHC_TIMESTAMP - $_CHC_CONFIG['user_online_fuer'] ) .'
		ORDER BY s.wert, o.timestamp_letzter_aufruf DESC'
	);

       $result = $_CHC_DB->query(
		'SELECT o.nr, o.ip, o.seite, o.homepage_id, o.timestamp_erster_aufruf, o.timestamp_letzter_aufruf, o.seitenaufrufe, o.user_agent, s.titel, s.counter_verzeichnis, @max_monat = MAX(s.monat)
		FROM `'. CHC_TABLE_ONLINE_USERS .'` as o
		LEFT JOIN `'. CHC_TABLE_PAGES .'` as s
			ON o.seite = s.wert AND o.homepage_id = s.homepage_id
		WHERE o.timestamp_letzter_aufruf >= '. ( CHC_TIMESTAMP - $_CHC_CONFIG['user_online_fuer'] ) .'
		GROUP by @max_monat
		ORDER BY s.monat, timestamp DESC'
	);
        */
        $result = $_CHC_DB->query(
		'SELECT o.nr, o.ip, o.seite, o.homepage_id, o.timestamp_erster_aufruf, o.timestamp_letzter_aufruf, o.seitenaufrufe, o.user_agent, s.titel, s.counter_verzeichnis
		FROM `'. CHC_TABLE_ONLINE_USERS .'` as o
		LEFT JOIN `'. CHC_TABLE_PAGES .'` as s
			ON o.seite = s.wert AND o.homepage_id = s.homepage_id AND s.monat = '. $aktueller_monat .'
		WHERE o.timestamp_letzter_aufruf >= '. ( CHC_TIMESTAMP - $_CHC_CONFIG['user_online_fuer'] ) .'
		GROUP BY o.nr
		ORDER BY timestamp DESC'
	);

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
			'USER_AGENT' => $row['user_agent'],
			'PAGE_URL'	=> !empty( $row['seite'] ) ? htmlentities( chC_get_url( ( $row['counter_verzeichnis'] == 1 ) ? 'counter' : 'homepage', $row['homepage_id'] ) . $row['seite'] ) : '',
			'PAGE_TITLE'	=> !empty( $row['titel'] ) ? chC_str_prepare_for_output( $row['titel'], $_CHC_CONFIG['wordwrap_seite_online_users'], TRUE, TRUE ) : '',
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


	$_CHC_TPL->assign( array(
			'L_FIRST_ACTIVITY' => $_CHC_LANG['first_activity'],
			'L_LAST_ACTIVITY' => $_CHC_LANG['last_activity'],
			'L_NO_VISITORS_ONLINE' => $_CHC_LANG['no_visitors_online'],
			'L_CURRENTLY_ONLINE' => $_CHC_LANG['Currently_online:'],
			'V_TOTAL' => sprintf( $_CHC_LANG['total_visitors_online'], $_CHC_DB->num_rows( $result ) ),
			'L_PAGE' => $_CHC_LANG['page'],
			'L_PAGE_VIEWS' => $_CHC_LANG['page_views'],
			'L_TOP_PAGES' => $_CHC_LANG['top_pages'],
			'L_IP' => $_CHC_LANG['IP'],
			'L_USER_AGENT' => $_CHC_LANG['user_agent']
		)
	);


	# Seiten
	$_CHC_TPL->assign(
		'V_START_DATE_PAGES_STATISTIC',
		sprintf(
			$_CHC_LANG['statistic_running_since:'],
			chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $_CHC_CONFIG['timestamp_start_seiten'] )
		)
	);

	if( !isset( $_GET['p'] ) )
	{
		$_GET['p'] = 'complete_list';
	}

	$liste = array(
		'full_list' =>	$_CHC_LANG['complete_list'],
		'entry' =>	$_CHC_LANG['entry_pages'],
		'exit' =>	$_CHC_LANG['exit_pages']
	);
	chC_send_select_list_to_tpl( 'PAGES_LIST_SELECT', $liste, $_GET['p'] );

	$liste = chC_stats_create_list_of_available_months( CHC_TABLE_PAGES );
	$monat = ( isset( $_GET['p_month'] ) && !empty( $_GET['p_month'] ) && isset( $liste[$_GET['p_month']] ) ) ?  $_GET['p_month'] : $aktueller_monat;
	chC_send_select_list_to_tpl( 'P_MONTHS', $liste, $monat );
	$_CHC_TPL->assign( 'P_MONTH', $monat );

	$hideout_bedingung = chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_pages'] );
	$ganze_bedingung = !empty( $hideout_bedingung ) ? 'WHERE ' . $hideout_bedingung : $hideout_bedingung;
	if( $_GET['p'] == 'entry' )
	{
		$_CHC_TPL->assign( 'PAGE_TYPE', 'entry_pages' );
		$ganze_bedingung .= !empty( $ganze_bedingung ) ? ' AND anzahl_einstiegsseite > 0' : ' WHERE anzahl_einstiegsseite > 0' ;
		$anzahl_feld = 'anzahl_einstiegsseite';
	}
	elseif( $_GET['p'] == 'exit' )
	{
		$_CHC_TPL->assign( 'PAGE_TYPE', 'exit_pages' );
		$ganze_bedingung .= !empty( $ganze_bedingung ) ? ' AND anzahl_ausgangsseite > 0' : ' WHERE anzahl_ausgangsseite > 0' ;#
		$anzahl_feld = 'anzahl_ausgangsseite';
	}
	else
	{
		$_CHC_TPL->assign( 'PAGE_TYPE', 'pages' );
		$anzahl_feld = 'anzahl';
	}

	if( $_CHC_CONFIG['aktiviere_seitenverwaltung_von_mehreren_domains'] == '1' )
	{
		//
		// es sollen nur Seiten angezeigt werden, deren Homepage in der Einstellung `homepages_urls` vorhanden ist:
		//

		$liste_homepages = chC_get_ids_and_urls( 'homepages' );

		$ids = implode( '; ', array_keys( $liste_homepages ) );
		$homepage_id_condition = "( homepage_id = "
			.str_replace(
				'; ',
				" OR homepage_id = ",
				$ids
			)
			.' )';
		$ganze_bedingung .= !empty( $ganze_bedingung ) ? ' AND ' . $homepage_id_condition : 'WHERE '. $homepage_id_condition;

		if( $_CHC_CONFIG['seitenstatistik:_zeige_homepages_getrennt'] == '1' )
		{
			// wenn mehr als 1 Homepage mit Seiteneinträgen vorhanden, <select>-Liste erstellen
			// und nur die Einträge _einer_ Homepage anzeigen

			$sql = 'SELECT DISTINCT(homepage_id) as id
				FROM `'. CHC_TABLE_PAGES .'`
				'. $ganze_bedingung;
			$sql .= !empty( $ganze_bedingung ) ? ' AND ' : ' WHERE ';
			if( $monat != 'all_months')
			{
				$sql .= ' monat = '. $aktueller_monat .' ';
			}
			$sql .= 'ORDER BY homepage_id ASC;';

			$result = $_CHC_DB->query( $sql );
			if( $_CHC_DB->num_rows( $result ) > 1 )
			{
				// Einträge mit verschiedenen (gültigen) homepage_ids vorhanden
				$verschiedene_homepages = array();
				while( $row = $_CHC_DB->fetch_assoc( $result ) )
				{
					$verschiedene_homepages[$row['id']] = $liste_homepages[$row['id']];
				}

				if( !isset( $_GET['homepage_id'] ) || !isset( $liste_homepages[$_GET['homepage_id']] ) )
				{
					chC_evaluate( 'homepage', $_GET['homepage_id'], $homepage_url );
				}
				
				
				if( count( $verschiedene_homepages ) > 1 )
				{
					chC_send_select_list_to_tpl( 'DIFFERENT_HOMEPAGES', $verschiedene_homepages, $_GET['homepage_id'] );
				}


				if( $monat == 'all_months' )
				{
					$result = $_CHC_DB->query(
						'SELECT DISTINCT( wert ) as wert, homepage_id, counter_verzeichnis, titel, SUM( '. $anzahl_feld .' ) AS anzahl
						FROM `'. CHC_TABLE_PAGES .'`
						WHERE homepage_id = '. $_GET['homepage_id']
						. ( !empty( $hideout_bedingung ) ? ' AND '. $hideout_bedingung : '' ).'
						'. ( $_GET['p'] == 'entry' ? ' AND anzahl_einstiegsseite > 0' : '' ) .'
						'. ( $_GET['p'] == 'exit' ? ' AND anzahl_ausgangsseite > 0' : '' ) .'
						GROUP BY wert
						ORDER BY '. $anzahl_feld .' DESC
						LIMIT 0, '. $_CHC_CONFIG['statistiken_anzahl_seiten']
					);
				}
				else
				{
					$result = $_CHC_DB->query(
						'SELECT wert, homepage_id, counter_verzeichnis, titel '. $anzahl_feld .' AS anzahl
						FROM `'. CHC_TABLE_PAGES .'`
						WHERE
							monat = '. $monat .'
							AND homepage_id = '. $_GET['homepage_id']
						. ( !empty( $hideout_bedingung ) ? ' AND '. $hideout_bedingung : '' ).'
						'. ( $_GET['p'] == 'entry' ? ' AND anzahl_einstiegsseite > 0' : '' ) .'
						'. ( $_GET['p'] == 'exit' ? ' AND anzahl_ausgangsseite > 0' : '' ) .'
						ORDER BY '. $anzahl_feld .' DESC
						LIMIT 0, '. $_CHC_CONFIG['statistiken_anzahl_seiten']
					);
				}

				// es sollen max(), sum(), ... nachher nur von der anzuzeigenden homepage ermittelt werden, alle anderen IDs aus bedingung heraus
				$ganze_bedingung = str_replace( $homepage_id_condition, 'homepage_id = '. $_GET['homepage_id'], $ganze_bedingung );

			}
		}
		if( ! (
			$_CHC_CONFIG['seitenstatistik:_zeige_homepages_getrennt'] == '1'
			&& isset( $verschiedene_homepages )
			)
		  )
		{
			// es wurde keine <select>-Liste erstellt und noch keine Daten aus der Datenbank geholt
			$seiten_noch_abzufragen = TRUE;
		}
	}
	else
	{
		$seiten_noch_abzufragen = TRUE;
	}

	if( $seiten_noch_abzufragen == TRUE )
	{
		if( $monat == 'all_months' )
		{
			$result = $_CHC_DB->query (
				'SELECT DISTINCT wert as seite, homepage_id, counter_verzeichnis, titel, SUM( '. $anzahl_feld .' ) AS anzahl
				FROM `'. CHC_TABLE_PAGES .'`
				'. $ganze_bedingung .'
				GROUP BY seite
				ORDER BY '. $anzahl_feld .' DESC
				LIMIT 0, '. $_CHC_CONFIG['statistiken_anzahl_seiten']
			);
		}
		else
		{
			$result = $_CHC_DB->query (
				'SELECT wert as seite, homepage_id, counter_verzeichnis, titel, '. $anzahl_feld .' AS anzahl
				FROM `'. CHC_TABLE_PAGES .'`
				'. $ganze_bedingung .'
				'. ( !empty( $ganze_bedingung ) ? ' AND monat = '. $monat : ' WHERE monat = '. $monat  ) .'
				ORDER BY '. $anzahl_feld .' DESC
				LIMIT 0, '. $_CHC_CONFIG['statistiken_anzahl_seiten']
			);
		}
	}


	if( $_CHC_DB->num_rows( $result ) > 0 )
	{
		$i = 0;
		if( $monat == 'all_months' )
		{
			$anzahl = $_CHC_DB->query(
				'SELECT
					SUM('. $anzahl_feld .') as sum,
					COUNT( DISTINCT wert ) AS count,
					MAX('. $anzahl_feld .') as max
				FROM `'. CHC_TABLE_PAGES .'`'
				. $ganze_bedingung
			);
		}
		else
		{
			$anzahl = $_CHC_DB->query(
				'SELECT
					SUM('. $anzahl_feld .') as sum,
					COUNT( wert ) AS count,
					MAX('. $anzahl_feld .') as max
				FROM `'. CHC_TABLE_PAGES .'`
				'. $ganze_bedingung .'
				'. ( !empty( $ganze_bedingung ) ? ' AND monat = '. $monat : ' WHERE monat = '. $monat  )
			);
		}
		$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

		while( $row = $_CHC_DB->fetch_assoc( $result ) )
		{
			if( empty( $row['titel'] ) || $_CHC_CONFIG['zeige_seitentitel'] == '0' )
			{
				$row['titel'] = $row['seite'];
			}
			$percent = @round( $row['anzahl'] / $anzahl['sum'] * 100, 2 );

			$_CHC_TPL->add_block( 'PAGES', array(
					'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
					'No.'		=> $i + 1,
					'URL'		=> htmlentities( chC_get_url( ( $row['counter_verzeichnis'] == 1 ) ? 'counter' : 'homepage', $row['homepage_id'] ) . $row['seite'] ),
					'PAGE_TITLE'		=> chC_str_prepare_for_output( $row['titel'], $_CHC_CONFIG['wordwrap_seiten'], TRUE, TRUE ),
					'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'GRAPH_PERCENTAGE' => (int) $percent,
					'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'BAR_No.'		=> ( $row['anzahl'] == $anzahl['max'] ) ? 2 : 1
				)
			);
			$i++;
		}
		$_CHC_TPL->assign( array(
				'V_TOTAL_PAGES' => $anzahl['count'],
				'V_TOTAL_PAGEVIEWS' => $anzahl['sum']
			)
		);
	}
}
elseif( $_GET['cat'] == 'downloads_and_hyperlinks' )
{

	if( is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index:downloads_and_hyperlinks;' ) ) )
	{
		$login = chC_manage_login();
		if( chC_logged_in() == FALSE )
		{
			$output = "</form>\n";
			$output .= chC_get_login_form( $login == -1 ? 1 : 0 );
			$output .= "\n<form method=\"GET\" action=\"\">\n";
			$_CHC_TPL->load_template( $output );
			$_CHC_TPL->load_file( CHC_ROOT .'/templates/stats/index_footer.tpl.html' );
			$_CHC_TPL->print_template();
			exit;
		}
	}

	$_CHC_TPL->load_file( CHC_ROOT .'/templates/stats/index_body_downloads_and_hyperlinks.tpl.html' );


	// Downloads
	$_CHC_TPL->assign( array(
			'DOWNLOAD_COUNTER_ACTIVATED' => TRUE,
			'L_DOWNLOAD' => $_CHC_LANG['download'],
			'L_TOP_DOWNLOADS' => $_CHC_LANG['top_downloads'],
		)
	);


	$liste = chC_stats_create_list_of_available_months( CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS, "typ = 'download'" );
	$monat = ( isset( $_GET['d_month'] ) && !empty( $_GET['d_month'] ) && isset( $liste[$_GET['d_month']] ) ) ?  $_GET['d_month'] : $aktueller_monat;
	chC_send_select_list_to_tpl( 'D_MONTHS', $liste, $monat );
	$_CHC_TPL->assign( 'D_MONTH', $monat );



	if( $monat == 'all_months' )
	{
		$result = $_CHC_DB->query(
			'SELECT id, wert, anzahl
			FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."`
			WHERE typ = 'download' AND `in_statistik_verbergen` = 0
			ORDER BY anzahl DESC
			LIMIT 0, ". $_CHC_CONFIG['statistiken_anzahl_downloads']
		);
	}
	else
	{
		$result = $_CHC_DB->query(
			'SELECT b.id, b.wert, a.anzahl
			FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS ."` AS a
			LEFT JOIN `". CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."` AS b
				ON a.id = b.id
			WHERE a.typ = 'download' AND a.monat = ". $monat .' AND b.in_statistik_verbergen = 0 AND b.id IS NOT NULL
			ORDER BY anzahl DESC
			LIMIT 0, '. $_CHC_CONFIG['statistiken_anzahl_downloads']
		);
	}

	if( $_CHC_DB->num_rows( $result ) > 0 )
	{
		if( $monat == 'all_months' )
		{
			$anzahl = $_CHC_DB->query(
				'SELECT
					SUM(anzahl) as sum,
					COUNT(id) as count,
					MAX(anzahl) as max
				FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."`
				WHERE typ = 'download' AND anzahl > 0 AND `in_statistik_verbergen` = 0;"
			);
		}
		else
		{
			$anzahl = $_CHC_DB->query(
				'SELECT
					SUM( a.anzahl ) as sum,
					COUNT( a.id ) as count,
					MAX( a.anzahl ) as max
				FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS .'` as a
				LEFT JOIN `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."` AS b
						ON a.id = b.id
				WHERE a.typ = 'download' AND a.monat = ". $monat .' AND a.anzahl > 0 AND b.in_statistik_verbergen = 0 AND b.id IS NOT NULL;'
			);
		}
		$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

		$i = 0;
		while( $row = $_CHC_DB->fetch_assoc( $result ) )
		{
			$percent = @round( $row['anzahl'] / $anzahl['sum'] * 100, 2 );

			$_CHC_TPL->add_block( 'DOWNLOADS', array(
					'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
					'No.'		=> $i + 1,
					'DOWNLOAD_NAME'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_downloads'] ),
					'DOWNLOAD_URL' => htmlentities( $_CHC_CONFIG['aktuelle_counter_url'] .'/getfile.php?id='. $row['id'] ),
					'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'GRAPH_PERCENTAGE' => (int) $percent,
					'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'BAR_No.'		=> ( $row['anzahl'] == $anzahl['max'] ) ? 2 : 1
				)
			);
			$i++;
		}
		$_CHC_TPL->assign( array(
				'V_TOTAL_DOWNLOAD_FILES' => $anzahl['count'],
				'V_TOTAL_DOWNLOADS' => $anzahl['sum']
			)
		);
	}



	 // Hyperlinks
	 $_CHC_TPL->assign( array(
			'LINK_COUNTER_ACTIVATED' => 'f',

			'L_HYPERLINK' => $_CHC_LANG['hyperlink'],
			'L_TOP_HYPERLINKS' => $_CHC_LANG['top_hyperlinks'],
		)
	);

	$liste = chC_stats_create_list_of_available_months( CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS, "typ = 'hyperlink'" );
	$monat = ( isset( $_GET['h_month'] ) && !empty( $_GET['h_month'] ) && isset( $liste[$_GET['h_month']] ) ) ?  $_GET['h_month'] : $aktueller_monat;
	chC_send_select_list_to_tpl( 'H_MONTHS', $liste, $monat );
	$_CHC_TPL->assign( 'H_MONTH', $monat );

	if( $monat == 'all_months' )
	{
		$result = $_CHC_DB->query(
			'SELECT id, wert, anzahl
			FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."`
			WHERE typ = 'hyperlink' AND in_statistik_verbergen = 0
			ORDER BY anzahl DESC
			LIMIT 0, ". $_CHC_CONFIG['statistiken_anzahl_hyperlinks']
		);
	}
	else
	{
		$result = $_CHC_DB->query(
			'SELECT b.id, b.wert, a.anzahl
			FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS ."` AS a
			LEFT JOIN `". CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."` AS b
				ON a.id = b.id
			WHERE a.typ = 'hyperlink' AND a.monat = ". $monat .' AND b.in_statistik_verbergen = 0 AND b.id IS NOT NULL
			ORDER BY anzahl DESC
			LIMIT 0, '. $_CHC_CONFIG['statistiken_anzahl_hyperlinks']
		);
	}

	if( $_CHC_DB->num_rows( $result ) > 0 )
	{
		if( $monat == 'all_months' )
		{
			$anzahl = $_CHC_DB->query(
				'SELECT
					SUM(anzahl) as sum,
					COUNT(id) as count,
					MAX(anzahl) as max
				FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."`
				WHERE typ = 'hyperlink' AND anzahl > 0 AND in_statistik_verbergen = 0;"
			);
		}
		else
		{
			$anzahl = $_CHC_DB->query(
				'SELECT
					SUM( a.anzahl ) as sum,
					COUNT( a.id ) as count,
					MAX( a.anzahl ) as max
				FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS .'` as a
				LEFT JOIN `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."` AS b
						ON a.id = b.id
				WHERE a.typ = 'hyperlink' AND a.monat = ". $monat .' AND a.anzahl > 0 AND b.in_statistik_verbergen = 0 AND b.id IS NOT NULL;'
			);
		}
		$anzahl = $_CHC_DB->fetch_assoc( $anzahl );

		$i = 0;
		while( $row = $_CHC_DB->fetch_assoc( $result ) )
		{
			$percent = @round( $row['anzahl'] / $anzahl['sum'] * 100, 2 );

			$_CHC_TPL->add_block( 'HYPERLINKS', array(
					'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
					'No.'		=> $i + 1,
					'LINK_NAME'	=> chC_str_prepare_for_output( $row['wert'], $_CHC_CONFIG['wordwrap_downloads'] ),
					'LINK_URL' => htmlentities( $_CHC_CONFIG['aktuelle_counter_url'] .'/refer.php?id='. $row['id'] ),
					'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'GRAPH_PERCENTAGE' => (int) $percent,
					'PERCENTAGE' => number_format( $percent , 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),
					'BAR_No.'		=> ( $row['anzahl'] == $anzahl['max'] ) ? 2 : 1
				)
			);
				$i++;
		}
		$_CHC_TPL->assign( array(
				'V_TOTAL_LINKS' => $anzahl['count'],
				'V_TOTAL_REFERRED_VISITORS' => $anzahl['sum']
			)
		);
	}

}
else
{

	if( is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index:main;' ) ) )
	{
		$login = chC_manage_login();
		if( chC_logged_in() == FALSE )
		{
			$output = "</form>\n";
			$output .= chC_get_login_form( $login == -1 ? 1 : 0 );
			$output .= "\n<form method=\"GET\" action=\"\">\n";
			$_CHC_TPL->load_template( $output );
			$_CHC_TPL->load_file( CHC_ROOT .'/templates/stats/index_footer.tpl.html' );
			$_CHC_TPL->print_template();
			exit;
		}
	}

	$_CHC_TPL->load_file( CHC_ROOT .'/templates/stats/index_body_main.tpl.html' );



	# Zählerstand + Rekorde
	$counterstand = $_CHC_DB->query(
		'SELECT
			d.besucher_gesamt, d.besucher_heute, d.heute_timestamp, d.besucher_gestern,
			d.`max_online:anzahl`, d.`max_online:timestamp`,
			d.`max_besucher_pro_tag:anzahl`, d.`max_besucher_pro_tag:timestamp`,
			d.`max_seitenaufrufe_pro_tag:anzahl`, d.`max_seitenaufrufe_pro_tag:timestamp`,
			d.seitenaufrufe_gesamt, d.seitenaufrufe_heute, d.seitenaufrufe_gestern,
			d.`durchschnittlich_pro_tag:timestamp`, d.`durchschnittlich_pro_tag:besucher`, d.`durchschnittlich_pro_tag:seitenaufrufe`,
			d.`seitenaufrufe_pro_besucher:besucher`, d.`seitenaufrufe_pro_besucher:seitenaufrufe`,
			d.js_alle, d.js_aktiv,
			IF(p.anzahl, p.anzahl, 0) AS diese_seite_seitenaufrufe
		FROM `'. CHC_DATABASE .'`.`'. CHC_TABLE_DATA .'` AS d
		LEFT JOIN `'. CHC_DATABASE .'`.`'. CHC_TABLE_PAGES ."`  AS p
			ON p.wert =  '".$chC_seite ."';"
	);              /* Variable $chC_seite: noch von counter.php stammend */
	$counterstand = $_CHC_DB->fetch_assoc( $counterstand );

	$result = $_CHC_DB->query(
		'SELECT COUNT(*) as anzahl_online_users
		FROM `'. CHC_DATABASE .'`.`'. CHC_TABLE_ONLINE_USERS .'`
		WHERE timestamp_letzter_aufruf >= '. ( CHC_TIMESTAMP - $_CHC_CONFIG['user_online_fuer'] ) .';'
	);
	$counterstand = array_merge( $counterstand, $_CHC_DB->fetch_assoc( $result ) );
	

	$chC_laufzeit = ceil(
		( CHC_TIMESTAMP - mktime(
				0,
				0,
				0,
				chC_format_date( 'n', $counterstand['durchschnittlich_pro_tag:timestamp'], FALSE ),
				chC_format_date( 'j', $counterstand['durchschnittlich_pro_tag:timestamp'], FALSE ),
				chC_format_date( 'y', $counterstand['durchschnittlich_pro_tag:timestamp'], FALSE )
			)
		)
		/ 86400
	);


	$_CHC_TPL->assign( array(
			'L_DATA_AND_RECORDS' => $_CHC_LANG['data_and_records'],

			'V_START_DATE_COUNTER' => $_CHC_CONFIG['timestamp_start_pseudo'] != '0'
				? sprintf( $_CHC_LANG['counter_running_since:'], chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $_CHC_CONFIG['timestamp_start_pseudo'] ) )
				: '',

			'L_VISITORS' => $_CHC_LANG['visitors'],
			'L_PAGE_VIEWS' => $_CHC_LANG['page_views'],

			'L_TOTAL' => $_CHC_LANG['total:'],
			'V_TOTAL_VISITORS' => $counterstand['besucher_gesamt'],

			'L_TODAY' => $_CHC_LANG['today:'],
			'V_VISITORS_TODAY' => $counterstand['besucher_heute'],

			'L_YESTERDAY' => $_CHC_LANG['yesterday:'],
			'V_VISITORS_YESTERDAY' => $counterstand['besucher_gestern'],

			'L_PER_DAY' => $_CHC_LANG['per_day:'],
			'V_VISITORS_PER_DAY' => number_format( @round( $counterstand['durchschnittlich_pro_tag:besucher'] / $chC_laufzeit, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'L_CURRENTLY_ONLINE' => $_CHC_LANG['currently_online:'],
			'V_VISITORS_CURRENTLY_ONLINE' => $counterstand['anzahl_online_users'],

			'L_MAX_ONLINE' => $_CHC_LANG['max_online:'],
			'V_MAX_VISITORS_ONLINE' => $counterstand['max_online:anzahl'],

			'L_MAX_ONLINE_DATE' => $_CHC_LANG['max_online_date:'],
			'V_MAX_VISITORS_ONLINE_DATE' => $counterstand['max_online:timestamp'] != '0'
				? chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:complete'], $counterstand['max_online:timestamp'] )
				: $_CHC_LANG['unknown'],

			'L_MAX_PER_DAY' => $_CHC_LANG['max_per_day:'],
			'V_MAX_VISITORS_PER_DAY' => $counterstand['max_besucher_pro_tag:anzahl'],

			'L_MAX_DAY_DATE' => $_CHC_LANG['max_per_day_date:'],
			'V_MAX_VISITORS_PER_DAY_DATE' => $counterstand['max_besucher_pro_tag:timestamp'] != '0'
				? chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $counterstand['max_besucher_pro_tag:timestamp'] )
				: $_CHC_LANG['unknown'],

			'V_TOTAL_PAGE_VIEWS' => $counterstand['seitenaufrufe_gesamt'],

			'V_PAGE_VIEWS_TODAY' => $counterstand['seitenaufrufe_heute'],

			'V_PAGE_VIEWS_YESTERDAY' => $counterstand['seitenaufrufe_gestern'],

			'V_PAGE_VIEWS_PER_DAY' => number_format( @round( $counterstand['durchschnittlich_pro_tag:seitenaufrufe'] / $chC_laufzeit, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'V_MAX_PAGE_VIEWS_PER_DAY' => $counterstand['max_seitenaufrufe_pro_tag:anzahl'],

			'V_MAX_PAGE_VIEWS_PER_DAY_DATE' => $counterstand['max_seitenaufrufe_pro_tag:timestamp'] != '0'
				? chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $counterstand['max_seitenaufrufe_pro_tag:timestamp'] )
				: $_CHC_LANG['unknown'],

			'L_PER_VISITOR' => $_CHC_LANG['per_visitor:'],
			'V_PAGE_VIEWS_PER_VISITOR' => number_format( @round( $counterstand['seitenaufrufe_pro_besucher:seitenaufrufe'] / $counterstand['seitenaufrufe_pro_besucher:besucher'], 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'L_THIS_PAGE' => $_CHC_LANG['this_page:'],
			'V_PAGE_VIEWS_THIS_PAGE' => $counterstand['diese_seite_seitenaufrufe'],

			'L_JAVASCRIPT_ACTIVATED' => $_CHC_LANG['javascript_activated:'],
			'V_JS_PERCENTAGE' => $_CHC_CONFIG['status_js'] == '1'
				? @round(
					$_CHC_VALUES['js_aktiv'] / ( ( $_CHC_CONFIG['robots_von_js_stats_ausschliessen'] == '0' ) ? $_CHC_VALUES['js_alle'] : $_CHC_VALUES['js_alle'] - $_CHC_VALUES['js_robots'] ) * 100,
					2
				) .'%'
				: $_CHC_LANG['deactivated'],

			'L_LATEST_X' => $_CHC_LANG['latest_x'],
			'L_TOP_X' => $_CHC_LANG['top_x']

		)
	);




	// LATEST & TOP
	$liste = array(
		'user_agents'	=> $_CHC_LANG['user_agents'],
		'browsers'	=> $_CHC_LANG['browsers'],
		'os'	=> $_CHC_LANG['operating_systems'],
		'robots'	=> $_CHC_LANG['robots'],
		'referrers'	=> $_CHC_LANG['referrers'],
		'referring_domains'	=> $_CHC_LANG['referring_domains'],
		'pages'	=> $_CHC_LANG['pages'],
		'entry_pages'	=> $_CHC_LANG['entry_pages'],
		'exit_pages'	=> $_CHC_LANG['exit_pages'],
		'keywords'	=> $_CHC_LANG['search_keywords'],
		'search_phrases'	=> $_CHC_LANG['search_phrases'],
		'search_engines'	=> $_CHC_LANG['search_engines'],
		'screen_resolutions'	=> $_CHC_LANG['screen_resolutions'],
		'countries'	=> $_CHC_LANG['countries'],
		'languages'	=> $_CHC_LANG['languages'],
		'hosts_tlds'	=> $_CHC_LANG['hosts_tlds']
	);
	if( CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED == TRUE )
	{
		$liste['downloads'] = $_CHC_LANG['downloads'];
		$liste['hyperlinks'] = $_CHC_LANG['hyperlinks'];
	}

	if( !isset( $_GET['latest'] ) || !isset( $liste[$_GET['latest']] ) )
	{
		$_GET['latest'] = 'user_agents';
	}
	if( !isset( $_GET['top'] ) || !isset( $liste[$_GET['top']] ) )
	{
		$_GET['top'] = 'user_agents';
	}

	$typen =  array(
		'user_agents' => array(
			'tabelle' => CHC_TABLE_USER_AGENTS,
			'weitere_felder' => '',
			'where_cond' => "WHERE typ = 'user_agent' AND wert != '__chC:more__'",
			'typ' => $_CHC_LANG['user_agent']
		),
		'browsers' => array(
			'tabelle' => CHC_TABLE_USER_AGENTS,
			'weitere_felder' => '',
			'where_cond' => "WHERE typ = 'browser'",
			'typ' => $_CHC_LANG['browser']
		),
		'os' => array(
			'tabelle' => CHC_TABLE_USER_AGENTS,
			'weitere_felder' => '',
			'where_cond' => "WHERE typ = 'os'",
			'typ' => $_CHC_LANG['os']
		),
		'robots' => array(
			'tabelle' => CHC_TABLE_USER_AGENTS,
			'weitere_felder' => '',
			'where_cond' => "WHERE typ = 'robot'",
			'typ' => $_CHC_LANG['robot']
		),
		'referrers' => array(
			'tabelle' => CHC_TABLE_REFERRERS,
			'weitere_felder' => '',
			'where_cond' => "WHERE typ = 'referrer' AND wert != '__chC:more__'",
			'typ' => $_CHC_LANG['referrer']
		),
		'referring_domains' => array(
			'tabelle' => CHC_TABLE_REFERRERS,
			'weitere_felder' => '',
			'where_cond' => "WHERE typ = 'domain' AND wert != '__chC:more__'",
			'typ' => $_CHC_LANG['referring_domain']
		),
		'pages' => array(
			'tabelle' => CHC_TABLE_PAGES,
			'weitere_felder' => ' ,titel, homepage_id, counter_verzeichnis',
			'where_cond' => '',
			'typ' => $_CHC_LANG['page']
		),
		'entry_pages' => array(
			'tabelle' => CHC_TABLE_PAGES,
			'weitere_felder' => ' ,titel, homepage_id, counter_verzeichnis',
			'where_cond' => 'WHERE `anzahl_einstiegsseite` > 0',
			'typ' => $_CHC_LANG['entry_page']
		),
		'exit_pages' => array(
			'tabelle' => CHC_TABLE_PAGES,
			'weitere_felder' => ' ,titel, homepage_id, counter_verzeichnis',
			'where_cond' => 'WHERE `anzahl_ausgangsseite` > 0',
			'typ' => $_CHC_LANG['exit_page']
		),
		'keywords' => array(
			'tabelle' => CHC_TABLE_SEARCH_ENGINES,
			'weitere_felder' => '',
			'typ' => $_CHC_LANG['search_keyword'],
			'where_cond' => "WHERE typ = 'suchwort'"
		),
		'search_phrases' => array(
			'tabelle' => CHC_TABLE_SEARCH_ENGINES,
			'weitere_felder' => '',
			'typ' => $_CHC_LANG['search_phrases'],
			'where_cond' => "WHERE typ = 'suchphrase'"
		),
		'search_engines' => array(
			'tabelle' => CHC_TABLE_SEARCH_ENGINES,
			'weitere_felder' => '',
			'typ' => $_CHC_LANG['search_engine'],
			'where_cond' => "WHERE typ = 'suchmaschine'"
		),
		'screen_resolutions' => array(
			'tabelle' => CHC_TABLE_SCREEN_RESOLUTIONS,
			'weitere_felder' => '',
			'typ' => $_CHC_LANG['screen_resolution'],
			'where_cond' => ''
		),
		'countries' => array(
			'tabelle' => CHC_TABLE_LOCALE_INFORMATION,
			'weitere_felder' => '',
			'where_cond' => "WHERE typ = 'country'",
			'typ' => $_CHC_LANG['country']
		),
		'languages' => array(
			'tabelle' => CHC_TABLE_LOCALE_INFORMATION,
			'weitere_felder' => '',
			'where_cond' => "WHERE typ = 'language'",
			'typ' => $_CHC_LANG['language']
		),
		'hosts_tlds' => array(
			'tabelle' => CHC_TABLE_LOCALE_INFORMATION,
			'weitere_felder' => '',
			'where_cond' => "WHERE typ = 'host_tld'",
			'typ' => $_CHC_LANG['hosts_tlds']
		),
		'downloads' => array(
			'tabelle' => CHC_TABLE_DOWNLOADS_AND_HYPERLINKS,
			'weitere_felder' => ', id',
			'where_cond' => "WHERE typ = 'download'",
			'typ' => $_CHC_LANG['download']
		),
		'hyperlinks' => array(
			'tabelle' => CHC_TABLE_DOWNLOADS_AND_HYPERLINKS,
			'weitere_felder' => ', id',
			'where_cond' => "WHERE typ = 'hyperlink'",
			'typ' => $_CHC_LANG['hyperlink']
		)
	);

	foreach(
		array_unique( array( $_GET['latest'], $_GET['top'] ) ) // den beiden anzuzeigenden Typen von TOP und LATEST; doppelte werden entfernt
		as $typen_key
	  )
	// hideout_list Bedingung an $typen['...']['where_cond'] anhängen
	{
		$tmp_key = ( $typen_key == 'referring_domains' ) ? 'referrers' : $typen_key;
		if( isset( $_CHC_CONFIG['hideout_list_'.$tmp_key] ) && !empty( $_CHC_CONFIG['hideout_list_'.$tmp_key] ) )
		{
			$typen[$typen_key]['where_cond'] .= !empty( $typen[$typen_key]['where_cond'] ) ? ' AND ' : 'WHERE ';
			$typen[$typen_key]['where_cond'] .= chC_convert_hideout_list_to_condition( $_CHC_CONFIG['hideout_list_'.$tmp_key] );
		}
	}




	// LATEST X
	chC_send_select_list_to_tpl( 'SELECT_LIST_LATEST', $liste, $_GET['latest'] );

	$_CHC_TPL->assign(
		array(
			'L_TYPE_LATEST' => $typen[$_GET['latest']]['typ'],
			'L_LAST' => $_CHC_LANG['last']
		)
	);

	$result = $_CHC_DB->query(
		'SELECT DISTINCT wert, MAX(timestamp) as timestamp, MAX(monat) '. $typen[$_GET['latest']]['weitere_felder'] .'
		FROM `'. $typen[$_GET['latest']]['tabelle'] .'`
		'. $typen[$_GET['latest']]['where_cond'] .'
		GROUP BY wert
		ORDER BY timestamp DESC
		LIMIT 0, '. $_CHC_CONFIG['statistiken_anzahl_latest']
	);

	$i = 0;
	while( $row = $_CHC_DB->fetch_assoc( $result ) )
	{
		$block = array(
			'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
			'RANK'	=> $i + 1,
			'NAME'	=> $row['wert'],
			'DATE'	=> $row['timestamp'] != '0'
				? chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:complete'], $row['timestamp'] )
				: $_CHC_LANG['unknown']    // bei Versionen < 3.0.0 wurde bei den Auflösungen kein Datum gespeichert
		);

		if( $_GET['latest'] == 'pages' || $_GET['latest'] == 'exit_pages' || $_GET['latest'] == 'entry_pages' )
		{
			if( $_CHC_CONFIG['zeige_seitentitel'] == '1' && !empty( $row['titel'] ) )
			{
				$block['NAME'] = $row['titel'];
			}
			$block['URL'] =  htmlentities( chC_get_url( ( $row['counter_verzeichnis'] == 1 ) ? 'counter' : 'homepage', $row['homepage_id'] ) . $row['wert'] );
		}
		elseif( $_GET['latest'] == 'referrers' )
		{
			$block['URL'] = htmlentities( $row['wert'] );
		}
		elseif( $_GET['latest'] == 'referring_domains' )
		{
			$block['URL'] = 'http://'. htmlentities( $row['wert'] );
		}
		elseif( $_GET['latest'] == 'browsers' )
		{
			if( $block['NAME'] == 'unknown' )
			{
				$block['NAME'] = $_CHC_LANG['unknown'];
			}
			require_once( '../includes/user_agents.lib.php' );
			$block['IMG'] = isset( $chC_ualib_browsers[$row['wert']]['icon'] ) ? 'browsers/'. $chC_ualib_browsers[$row['wert']]['icon'] : 'browsers/blank.png';
		}
		elseif( $_GET['latest'] == 'os' )
		{
			if( $block['NAME'] == 'unknown' )
			{
				$block['NAME'] = $_CHC_LANG['unknown'];
			}
			require_once( '../includes/user_agents.lib.php' );
			$block['IMG'] = isset( $chC_ualib_os[$row['wert']]['icon'] ) ? 'os/'. $chC_ualib_os[$row['wert']]['icon'] : 'os/blank.png';
		}
		elseif( $_GET['latest'] == 'robots' )
		{
			if( $row['wert'] == 'other' )
			{
				$row['wert'] = $_CHC_LANG['others'];
			}
			require_once( '../includes/user_agents.lib.php' );
			$block['IMG'] = isset( $chC_ualib_robots[$row['wert']]['icon'] ) ? 'robots/'. $chC_ualib_robots[$row['wert']]['icon'] : 'robots/robot.png';
		}
		elseif( $_GET['latest'] == 'search_engines' )
		{
			require_once( '../includes/search_engines.lib.php' );
			if( isset( $chC_search_engines[$row['wert']]['icon'] ) )
			{
				$block['IMG'] = 'search_engines/'. $chC_search_engines[$row['wert']]['icon'];
			}
		}
		elseif( $_GET['latest'] == 'countries' )
		{
			$block['NAME'] = isset( $_CHC_LANG['lib_countries'][$row['wert']] )
				? $_CHC_LANG['lib_countries'][$row['wert']]
				: $row['wert'];

			if( is_file( CHC_ROOT .'/images/flags/'. $row['wert'] .'.gif' ) )
			{
				$block['IMG'] = 'flags/'. $row['wert'] .'.gif';
			}
		}
		elseif( $_GET['latest'] == 'languages' )
		{
			$block['NAME'] = isset( $_CHC_LANG['lib_languages'][$row['wert']] )
				? $_CHC_LANG['lib_languages'][$row['wert']]
				: $row['wert'];
		}
		elseif( $_GET['latest'] == 'hosts_tlds' )
		{
			if( $row['wert'][0] == '.' )
			{
				$row['wert'] = substr( $row['wert'], 1 );
			}

			if( is_file( CHC_ROOT .'/images/flags/'. $row['wert'] .'.gif' ) )
			{
				$block['IMG'] = 'flags/'. $row['wert'] .'.gif';
			}

			if( $row['wert'] == 'unresolved' )
			{
				$block['NAME'] = $_CHC_LANG['unresolved'];
			}
			elseif( isset( $_CHC_LANG['lib_countries'][$row['wert']] )  )
			{
				$block['NAME'] = $_CHC_LANG['lib_countries'][$row['wert']];
			}
			elseif( isset( $_CHC_LANG['lib_TLDs'][$row['wert']] ) )
			{
				$block['NAME'] = $_CHC_LANG['lib_TLDs'][$row['wert']];
			}
		}
		elseif( $_GET['latest'] == 'downloads' )
		{
			$block['URL'] = $_CHC_CONFIG['aktuelle_counter_url'] .'/getfile.php?id='. $row['id'];
		}
		elseif( $_GET['latest'] == 'hyperlinks' )
		{
			$block['URL'] = $_CHC_CONFIG['aktuelle_counter_url'] .'/refer.php?id='. $row['id'];
		}

		$block['NAME'] = chC_str_prepare_for_output( $block['NAME'], $_CHC_CONFIG['wordwrap_latest_x'], TRUE, TRUE );

		$_CHC_TPL->add_block( 'LATEST', $block );
		$i++;
	}



	// TOP X
	chC_send_select_list_to_tpl( 'SELECT_LIST_TOP', $liste, $_GET['top'] );

	$_CHC_TPL->assign( 'L_TYPE_TOP', $typen[$_GET['top']]['typ'] );

	$result = $_CHC_DB->query(
		'SELECT DISTINCT wert, SUM(anzahl) as anzahl '. $typen[$_GET['top']]['weitere_felder'] .'
		FROM `'. $typen[$_GET['top']]['tabelle'] .'`
		'. $typen[$_GET['top']]['where_cond'] .'
		GROUP BY wert
		ORDER BY anzahl DESC
		LIMIT 0, '. $_CHC_CONFIG['statistiken_anzahl_top']
	);

	$i = 0;
	while( $row = $_CHC_DB->fetch_assoc( $result ) )
	{
		$block = array(
			'ROW_CLASS_NR'	=> !( $i % 2 ) ? 1 : 2,
			'RANK'	=> $i + 1,
			'NAME'	=> $row['wert'],
			'QUANTITY'	=> number_format( $row['anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] )
		);

		if( $_GET['top'] == 'pages' || $_GET['top'] == 'exit_pages' || $_GET['top'] == 'entry_pages' )
		{
			if( $_CHC_CONFIG['zeige_seitentitel'] == '1' && !empty( $row['titel'] ) )
			{
				$block['NAME'] = $row['titel'];
			}
			$block['URL'] =  htmlentities( chC_get_url( ( $row['counter_verzeichnis'] == 1 ) ? 'counter' : 'homepage', $row['homepage_id'] ) . $row['wert'] );
		}
		elseif( $_GET['top'] == 'referrers' )
		{
			$block['URL'] = htmlentities( $row['wert'] );
		}
		elseif( $_GET['top'] == 'referring_domains' )
		{
			$block['URL'] = 'http://'. htmlentities( $row['wert'] );
		}
		elseif( $_GET['top'] == 'browsers' )
		{
			if( $block['NAME'] == 'unknown' )
			{
				$block['NAME'] = $_CHC_LANG['unknown'];
			}
			require_once( '../includes/user_agents.lib.php' );
			$block['IMG'] = isset( $chC_ualib_browsers[$row['wert']]['icon'] ) ? 'browsers/'. $chC_ualib_browsers[$row['wert']]['icon'] : 'browsers/blank.png';
		}
		elseif( $_GET['top'] == 'os' )
		{
			if( $block['NAME'] == 'unknown' )
			{
				$block['NAME'] = $_CHC_LANG['unknown'];
			}
			require_once( '../includes/user_agents.lib.php' );
			$block['IMG'] = isset( $chC_ualib_os[$row['wert']]['icon'] ) ? 'os/'. $chC_ualib_os[$row['wert']]['icon'] : 'os/blank.png';
		}
		elseif( $_GET['top'] == 'robots' )
		{
			if( $row['wert'] == 'other' )
			{
				$row['wert'] = $_CHC_LANG['others'];
			}
			require_once( '../includes/user_agents.lib.php' );
			$block['IMG'] = isset( $chC_ualib_robots[$row['wert']]['icon'] ) ? 'robots/'. $chC_ualib_robots[$row['wert']]['icon'] : 'robots/robot.png';
		}
		elseif( $_GET['top'] == 'search_engines' )
		{
			require_once( '../includes/search_engines.lib.php' );
			if( isset( $chC_search_engines[$row['wert']]['icon'] ) )
			{
				$block['IMG'] = 'search_engines/'. $chC_search_engines[$row['wert']]['icon'];
			}
		}
		elseif( $_GET['top'] == 'countries' )
		{
			$block['NAME'] = isset( $_CHC_LANG['lib_countries'][$row['wert']] )
				? $_CHC_LANG['lib_countries'][$row['wert']]
				: '? ('.strtoupper( $row['wert'] ).')';

			if( is_file( CHC_ROOT .'/images/flags/'. $row['wert'] .'.gif' ) )
			{
				$block['IMG'] = 'flags/'. $row['wert'] .'.gif';
			}
		}
		elseif( $_GET['top'] == 'languages' )
		{
			$block['NAME'] = isset( $_CHC_LANG['lib_languages'][$row['wert']] )
				? $_CHC_LANG['lib_languages'][$row['wert']]
				: $row['wert'];
		}
		elseif( $_GET['top'] == 'hosts_tlds' )
		{
			if( $row['wert'][0] == '.' )
			{
				$row['wert'] = substr( $row['wert'], 1 );
			}

			if( is_file( CHC_ROOT .'/images/flags/'. $row['wert'] .'.gif' ) )
			{
				$block['IMG'] = 'flags/'. $row['wert'] .'.gif';
			}

			if( $row['wert'] == 'unresolved' )
			{
				$block['NAME'] = $_CHC_LANG['unresolved'];
			}
			elseif( isset( $_CHC_LANG['lib_countries'][$row['wert']] )  )
			{
				$block['NAME'] = $_CHC_LANG['lib_countries'][$row['wert']];
			}
			elseif( isset( $_CHC_LANG['lib_TLDs'][$row['wert']] ) )
			{
				$block['NAME'] = $_CHC_LANG['lib_TLDs'][$row['wert']];
			}
		}
		elseif( $_GET['top'] == 'downloads' )
		{
			$block['URL'] = $_CHC_CONFIG['aktuelle_counter_url'] .'/getfile.php?id='. $row['id'];
		}
		elseif( $_GET['top'] == 'hyperlinks' )
		{
			$block['URL'] = $_CHC_CONFIG['aktuelle_counter_url'] .'/refer.php?id='. $row['id'];
		}

		$block['NAME'] = chC_str_prepare_for_output( $block['NAME'], $_CHC_CONFIG['wordwrap_top_x'], TRUE, TRUE );

		$_CHC_TPL->add_block( 'TOP', $block );

		$i++;
	}


}   

$_CHC_DB->close();

$_CHC_TPL->load_file( CHC_ROOT .'/templates/stats/index_footer.tpl.html' );
$_CHC_TPL->print_template();

?>
