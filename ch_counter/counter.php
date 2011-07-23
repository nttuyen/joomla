<?php


/*
 **************************************
 *
 * counter.php
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


//require( dirname( __FILE__ ) .'/timer.php' ) ;
//timer();



if( isset( $chCounter_no_output ) && $chCounter_no_output == TRUE )
{
	ob_start();
	$chCounter_visible = 0;
	$chCounter_debug = 'DEBUG_OFF';
}
elseif( !isset( $chCounter_debug ) )
{
	$chCounter_debug = 'DEBUG_ON';
}

if( $chCounter_debug == 'DEBUG_ON' )
{
	$chC_old_error_reporting = error_reporting( E_ALL );
}
else
{
	$chC_old_error_reporting = error_reporting( 0 );
}

$chCounter_force_new_db_connection = ( isset( $chCounter_force_new_db_connection ) && $chCounter_force_new_db_connection === FALSE )
	? FALSE
	: TRUE;


$chCounter_show_page_views_of_the_current_page = ( isset( $chCounter_show_page_views_of_the_current_page ) && $chCounter_show_page_views_of_the_current_page === FALSE )
	? FALSE
	: TRUE;



// magic_quotes_runtime: alte Konfiguration speichern, Neue setzen
$chC_old_magic_quotes_runtime = get_magic_quotes_runtime();
set_magic_quotes_runtime( 0 );




// chCounter root path
if( !defined( 'CHC_ROOT' ) )
{
	define( 'CHC_ROOT', dirname( __FILE__ ) );
}

$chC_script_filename = isset( $_SERVER['SCRIPT_FILENAME'] ) ? $_SERVER['SCRIPT_FILENAME'] : $_SERVER['PATH_TRANSLATED'];


// common Includes...
require_once( CHC_ROOT .'/includes/config.inc.php' );
//timer( 'config.inc');
require_once( CHC_ROOT .'/includes/common.inc.php' );
//timer( 'common.inc');
require_once( CHC_ROOT .'/includes/functions.inc.php' );
//timer( 'functions.inc');
require_once( CHC_ROOT .'/includes/mysql.class.php' );
//timer( 'mysql.class');
require_once( CHC_ROOT .'/includes/template.class.php' );
//timer( 'template.class');
require_once( CHC_ROOT. '/includes/user_agents.lib.php' );
//timer( 'user_agents.lib');





/************** Datenbank **************/
if( !isset( $_CHC_DB ) )
{
	$_CHC_DB = new chC_mysql( $_CHC_DBCONFIG['server'], $_CHC_DBCONFIG['user'], $_CHC_DBCONFIG['password'], FALSE, $chCounter_debug, $chCounter_force_new_db_connection );
	if( $chCounter_debug == 'DEBUG_OFF' && $_CHC_DB->is_connected() == FALSE )
	{
		return;
	}
}
$_CHC_DB->set_accepted_errors( '1062, 1044' );	// 1062: Duplicate entry
						// 1044: Access denied for user:... (falls ein User keine LOCK-Rechte besitzt)

//timer( 'DB steht');


/************** Konfiguratiuon aus DB **************/
$_CHC_CONFIG = chC_get_config();

if( isset( $chCounter_language ) )
{
	$_CHC_CONFIG['lang'] = $chCounter_language;
}

if( isset( $chCounter_do_not_search_for_page_title ) )
{
	$_CHC_CONFIG['seitenstatistik_titel_suche'] = '0';
}

//timer( '$_CHC_CONFIG' );


/* *** IP *** */
$chC_REMOTE_ADDR = chC_get_ip();
$chC_host = '';


//timer( 'IP_ERMITTLUNG' );


/**************  **************/

if( isset( $_GET['chCounter_mode'] ) && $_GET['chCounter_mode'] == 'info' )
{
	die(
		"Script: chCounter<br />\n"
		.'Version: '. $_CHC_CONFIG['script_version'] ."<br />\n"
		#.'Root directory: '. CHC_ROOT
	);
}
else
{
	$_CHC_CONFIG['mode'] = isset( $_GET['chCounter_mode'] ) ? $_GET['chCounter_mode'] : 'php';
}

$_CHC_CONFIG['aktuelle_homepage_id'] = 1;
$_CHC_CONFIG['aktuelle_homepage_url'] = $_CHC_CONFIG['default_homepage_url'];
$_CHC_CONFIG['aktuelle_counter_url'] = $_CHC_CONFIG['default_counter_url'];

#$chC_html_translation_table = array_flip( get_html_translation_table( HTML_ENTITIES ) );

if( $_CHC_CONFIG['mode'] == 'noscript' )
{
	$_CHC_CONFIG['status'] = 'active';
	$_CHC_CONFIG['visibility'] = $_CHC_CONFIG['default_counter_visibility'];

	$_CHC_CONFIG['status_referrer'] = 0;
	$_CHC_CONFIG['status_aufloesungen'] = 0;
	$_CHC_CONFIG['status_suchmaschinen_und_suchwoerter'] = 0;
	$_CHC_CONFIG['status_suchphrasen'] = 0;


	$chCounter_page_title = '';
	unset( $chC_seite );
	if( isset( $_SERVER['HTTP_REFERER'] ) )
	{
		$_SERVER['HTTP_REFERER'] = trim( $_SERVER['HTTP_REFERER'] );
		if( preg_match( '/^'. preg_quote( $_CHC_CONFIG['aktuelle_homepage_url'], '/' ) .'/', $_SERVER['HTTP_REFERER'] ) )
		{
			$chC_seite = str_replace( $_CHC_CONFIG['aktuelle_homepage_url'], '', $_SERVER['HTTP_REFERER'] );
		}
	}
	if( !isset( $chC_seite ) )
	{
		$chC_seite = $_SERVER['PHP_SELF'] .'?chCounter_mode=noscript';
		$chC_parse_url = parse_url( $_CHC_CONFIG['aktuelle_homepage_url'] );
		if( isset( $chC_parse_url['path'] ) )
		{
			$chC_seite = preg_replace( '/^'. preg_quote( $chC_parse_url['path'], '/' ) .'/', '', $chC_seite );
		}
	}
}
elseif( $_CHC_CONFIG['mode'] == 'js' )
{
	if( !isset( $_GET['jscode_version'] ) )
	{
		$_GET['jscode_version'] = '';
	}
	if( version_compare( $_GET['jscode_version'], $_CHC_CONFIG['min_jscode_version'], '<' ) == TRUE )
	{
		ob_start();
		require_once( CHC_ROOT .'/languages/'. $_CHC_CONFIG['lang'] .'/main.lang.php' );
		ob_end_clean();
		die( 'document.write("'. chC_convert_encoding( $_CHC_LANG['error:outdated_jscode'], $_CHC_CONFIG['homepage_charset'], 'UTF-8' ) .'");' );
	}

	$_CHC_CONFIG['visibility'] = ( isset( $_GET['visible'] ) && ( $_GET['visible'] == '0' || $_GET['visible'] == '1' ) ) ? $_GET['visible'] : intval( $_CHC_CONFIG['default_counter_visibility'] );
	$_CHC_CONFIG['status'] = ( isset( $_GET['status'] ) && $_GET['status'] == 'inactive' ) ? 'inactive' : 'active';

	$_SERVER['HTTP_REFERER'] = isset( $_GET['referrer'] ) ? $_GET['referrer'] : '';

	if( !isset( $_GET['page_url'] ) )
	{
		die( '/* chCounter error: No page url passed via GET. Script aborted. */' );
	}
	#else
	#{
	#	$_GET['page_url'] = strtr( $_GET['page_url'], $chC_html_translation_table );
	#}

	$chC_page_url = preg_replace( '/http(s?):\/\/(www\.)?/', 'http\\1://', $_GET['page_url'] );
	if( !empty( $_CHC_CONFIG['js_gleichwertige_homepage_urls'] ) )
	{
		$_CHC_CONFIG['js_gleichwertige_homepage_urls'] = preg_replace( '/; ?$/', '', $_CHC_CONFIG['js_gleichwertige_homepage_urls'] );
		$chC_urls = explode( '; ', $_CHC_CONFIG['js_gleichwertige_homepage_urls'] );
		foreach( $chC_urls as $chC_url )
		{
			$chC_tmp_aktuelle_hp_url = preg_replace( '/http(s?):\/\/(www\.)?/', 'http\\1://', $chC_url );
			$chC_tmp = strpos(
				strtolower( $chC_page_url ),
				strtolower( $chC_tmp_aktuelle_hp_url )
			);
			if( is_int( $chC_tmp ) )
			{
				break;
			}
		}
	}
	else
	{
		$chC_tmp_aktuelle_hp_url = preg_replace( '/http(s?):\/\/(www\.)?/', 'http\\1://', $_CHC_CONFIG['aktuelle_homepage_url'] );
		$chC_tmp = strpos(
			strtolower( $chC_page_url ),
			strtolower( $chC_tmp_aktuelle_hp_url )
		);
	}
	if( !is_int( $chC_tmp ) )
	{
		// JavaScript nicht auf Homepage-Domain ausgeführt -> kein Seitenname zu ermitteln -> inaktiv.
		// Praktisch bei lokal aufgerufenen HTMl-Seiten: Counter sichtbar, Besuch wird aber nicht registiert.
		// Es wird zwar noch ein (falscher) Dateipfad ermittelt, da der Counter aber inaktiv ist, wird die Variable §chC_seite nicht weiter benutzt.
		$_CHC_CONFIG['status'] = 'inactive';
	}
	$chC_seite = substr(
		$chC_page_url,
		$chC_tmp + strlen( $chC_tmp_aktuelle_hp_url )
	);
	$chCounter_page_title = isset( $_GET['page_title'] )
		? stripslashes( $_GET['page_title'] ) #chC_convert_encoding( $_GET['page_title'], 'UTF-8', $_CHC_CONFIG['homepage_charset'] )
		: '';


	$chC_tmp = parse_url( $chC_seite );
	if( isset( $chC_tmp['query'] ) )
	{
		$_SERVER['QUERY_STRING'] = $chC_tmp['query'];
	}
	else
	{
		unset( $_SERVER['QUERY_STRING'] );
	}


	if(
		isset( $_GET['res_width'] ) && isset( $_GET['res_height'] )
		&&
		!empty( $_GET['res_width'] ) && !empty( $_GET['res_height'] )
	  )
	{
		$chC_aufloesung = intval( $_GET['res_width'] ) .'x'. intval( $_GET['res_height'] );
	}
	else
	{
		unset( $chC_aufloesung );
	}
}
else /* Einbindung mit PHP... */
{
	if( $_CHC_CONFIG['aktiviere_seitenverwaltung_von_mehreren_domains'] == '1' )
	{
		// Homepage-URL angegeben: nicht standardmäßge Homepage
		if( isset( $chCounter_homepage_url ) && $chCounter_homepage_url != $_CHC_CONFIG['default_homepage_url'] )
		{
			$chC_homepages = chC_get_ids_and_urls( 'homepages' );
			$_CHC_CONFIG['aktuelle_homepage_id'] = array_search( $chCounter_homepage_url, $chC_homepages  );
			if( $_CHC_CONFIG['aktuelle_homepage_id'] === FALSE )
			{
				// angegebene Homepage in Einstellung 'homepages_urls' NICHT vorhanden
				// statt dessen zu benutzene Homepage ermitteln
				chC_evaluate( 'homepage', $_CHC_CONFIG['aktuelle_homepage_id'], $_CHC_CONFIG['aktuelle_homepage_url'] );
			}
			else
			{
				// Homepage vorhanden in config, übernehmen
				$_CHC_CONFIG['aktuelle_homepage_url'] = $homepages[$_CHC_CONFIG['aktuelle_homepage_id']];
			}
		}
		elseif( !isset( $chCounter_homepage_url ) ) // zu benutzende Homepage ermitteln
		{
			chC_evaluate( 'homepage', $_CHC_CONFIG['aktuelle_homepage_id'], $_CHC_CONFIG['aktuelle_homepage_url'] );
		}

		// dazu gehörige Counter-URL ermitteln:
		$_CHC_CONFIG['aktuelle_counter_url'] = chC_get_url( 'counter', $_CHC_CONFIG['aktuelle_homepage_id'] );
	}


	$_CHC_CONFIG['status'] = ( isset( $chCounter_status ) && $chCounter_status == 'inactive' ) ? 'inactive' : 'active';
	$_CHC_CONFIG['visibility'] = ( isset( $chCounter_visible ) && ( $chCounter_visible == 0 || $chCounter_visible == 1 ) ) ? $chCounter_visible : intval( $_CHC_CONFIG['default_counter_visibility'] );




	if( $_CHC_CONFIG['php_self_oder_request_uri'] != 'REQUEST_URI' || !isset( $_SERVER['REQUEST_URI'] ) )
	{
		$chC_seite = $_SERVER['PHP_SELF'];
		if( $_CHC_CONFIG['php_self_oder_request_uri'] == 'PHP_SELF + QUERY_STRING' && isset( $_SERVER['QUERY_STRING'] ) && !empty( $_SERVER['QUERY_STRING'] ) )
		{
			$chC_seite .= '?'. $_SERVER['QUERY_STRING'];
		}
	}
	else
	{
		$chC_seite = $_SERVER['REQUEST_URI'];
		$chC_parse_url = parse_url ( $chC_seite );
		if( empty( $chC_parse_url['path'] ) || $chC_parse_url['path'] == '/' /*$chC_parse_url['path'][strlen( $chC_parse_url['path'] )-1] == '/'*/ )
		{ // wenn  bspw. nur "domain.tld/"
			$chC_seite = $_SERVER['PHP_SELF'];
			if( isset( $chC_parse_url['query'] ) && !empty( $chC_parse_url['query'] ) )
			{
				$chC_seite .= '?'. $chC_parse_url['query'];
			}
		}
	}


	// für den Fall, dass Homepage-URL bspw. "http://www.domain.tld/user_name" ist: (also Stammverzeichnis der Homepage erst "user_name" ist)
	// "user_name" entfernen aus $chC_seite, worin "user_name" durch REQUEST_URI oder PHP_SELF noch vorhanden sein könnte
	$chC_hp_parse_url = parse_url( $_CHC_CONFIG['aktuelle_homepage_url'] );
	if( isset( $chC_hp_parse_url['path'] ) )
	{
		$chC_seite = preg_replace( '/^'. preg_quote( $chC_hp_parse_url['path'], '/' ) .'/', '', $chC_seite );

		if( $chC_seite == '/' || empty( $chC_seite ) )
		{
			// kann nur sein, wenn Seite zuvor über REQUEST_URI gebildet wurde. Auf PHP_SELF und QUERY_STRING zurückgreifen
			$chC_seite = $_SERVER['PHP_SELF'];
			if( isset( $chC_parse_url['query'] ) )
			{
				$chC_seite .= '?'. $chC_parse_url['query'];
			}
			$chC_seite = str_replace( $chC_hp_parse_url['path'], '/', $chC_seite );
		}

		if( $chC_seite[0] != '/' )
		{
			$chC_seite = '/'. $chC_seite;
		}
	}

	#$chC_seite = strtr( $chC_seite, $chC_html_translation_table );

	if( isset( $chCounter_utf8_page_title ) )
	{
		$chCounter_page_title = $chCounter_utf8_page_title;
	}
	else
	{
		$chCounter_page_title = isset( $chCounter_page_title )
			? chC_convert_encoding( $chCounter_page_title, 'UTF-8', $_CHC_CONFIG['homepage_charset'] )
			: '';
	}
	$chCounter_template = isset( $chCounter_template ) ? $chCounter_template : '';
}


$chC_parse_url = parse_url( $chC_seite );
if( isset( $chC_parse_url['query'] ) && !empty( $chC_parse_url['query'] ) )
{
	$chC_seite = chC_page_purge_query_string( $chC_seite, $_CHC_CONFIG['seiten_query_string_bereinigung_modus'], $_CHC_CONFIG['seiten_query_string_bereinigung_variablen'] );
}
if( is_int( strpos( $chC_seite, '#' ) ) )
{
	$chC_seite = preg_replace( '/#.*$/', '', $chC_seite );
}
if( substr( $chC_seite, 0, 3 ) == '/./' )
{
	$chC_seite = substr( $chC_seite, 2 );
}



// Aneignung und erste Behandlung fremder Daten
$chC_HTTP_REFERER = isset( $_SERVER['HTTP_REFERER'] ) ?  trim( $_SERVER['HTTP_REFERER'] ) : '';
$chC_HTTP_USER_AGENT = isset( $_SERVER['HTTP_USER_AGENT'] ) ? trim( $_SERVER['HTTP_USER_AGENT'] ) : '';
$chC_HTTP_ACCEPT_LANGUAGE = isset( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) ? trim( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) : '';
// schon mal ein paar fremde Daten entschärfen... User-Agents und Referrer aber erst kurz vorm Eintragen in DB
$chC_url_data = parse_url( $chC_HTTP_REFERER );
$chC_refhost = isset( $chC_url_data['host'] ) ? $_CHC_DB->escape_string( $chC_url_data['host'] ) : '';
$chC_HTTP_ACCEPT_LANGUAGE = $_CHC_DB->escape_string( $chC_HTTP_ACCEPT_LANGUAGE );
$chC_seite = $_CHC_DB->escape_string( $chC_seite );
$chCounter_page_title = $_CHC_DB->escape_string( $chCounter_page_title );





/************** noch nen paar wichtige Variablen. Warum diese in einem Array sind? historisch bedingt und sinnfrei(!?) **************/
$_CHC_VARIABLES = array(
	'timestamp_tagesanfang' => chC_get_timestamp( 'tag' ),
	'timestamp_monatsanfang' => chC_get_timestamp( 'monat' ),
	'timestamp_jahresanfang' => chC_get_timestamp( 'jahr' ),
	'timestamp_kalenderwoche' => chC_get_timestamp( 'kw' ),
	'update_queries' => array(
		CHC_TABLE_DATA => array(),
		CHC_TABLE_COUNTED_USERS => array(),
		CHC_TABLE_ACCESS => array()
	)
);
$_CHC_VARIABLES['aktueller_monat'] = chC_format_date( 'Ym', $_CHC_VARIABLES['timestamp_tagesanfang'], FALSE );



#var_dump($_CHC_VARIABLES);

//timer( 'Vorbereitungen, Variablen' );


/************** - **************/


$_CHC_DB->query(
	'LOCK TABLES
		`'. CHC_DATABASE .'`.`'. CHC_TABLE_COUNTED_USERS .'` AS c WRITE,
		`'. CHC_DATABASE .'`.`'. CHC_TABLE_COUNTED_USERS .'` WRITE,
		`'. CHC_DATABASE .'`.`'. CHC_TABLE_IGNORED_USERS .'` AS i WRITE,
		`'. CHC_DATABASE .'`.`'. CHC_TABLE_IGNORED_USERS .'` WRITE,
		`'. CHC_DATABASE .'`.`'. CHC_TABLE_DATA .'`as d WRITE,
		`'. CHC_DATABASE .'`.`'. CHC_TABLE_DATA .'` WRITE,
		`'. CHC_DATABASE .'`.`'. CHC_TABLE_PAGES .'`as p WRITE,
		`'. CHC_DATABASE .'`.`'. CHC_TABLE_ONLINE_USERS .'` as o WRITE,
		`'. CHC_DATABASE .'`.`'. CHC_TABLE_ONLINE_USERS .'`AS online WRITE,
		`'. CHC_DATABASE .'`.`'. CHC_TABLE_ONLINE_USERS .'` WRITE,
		`'. CHC_DATABASE .'`.`'. CHC_TABLE_LOG_DATA .'` WRITE;'
);

//timer( 'LOCK TABLES' );

/* *** Counterstand ermitteln *** */
$_CHC_VALUES = $_CHC_DB->query(
	'SELECT
		d.besucher_gesamt, d.besucher_heute, d.heute_timestamp, d.besucher_gestern,
		d.`max_online:anzahl`, d.`max_online:timestamp`,
		d.`max_besucher_pro_tag:anzahl`, d.`max_besucher_pro_tag:timestamp`,
		d.`max_seitenaufrufe_pro_tag:anzahl`, d.`max_seitenaufrufe_pro_tag:timestamp`,
		d.seitenaufrufe_gesamt, d.seitenaufrufe_heute, d.seitenaufrufe_gestern,
		d.`durchschnittlich_pro_tag:timestamp`, d.`durchschnittlich_pro_tag:besucher`, d.`durchschnittlich_pro_tag:seitenaufrufe`,
		d.`seitenaufrufe_pro_besucher:besucher`, d.`seitenaufrufe_pro_besucher:seitenaufrufe`,
		d.js_aktiv, d.js_robots, d.js_alle,
		d.timestamp_letztes_db_aufraeumen,
		IF( p.id IS NOT NULL, p.id, -1 ) as diese_seite_id,
		IF( c.nr IS NOT NULL, 1, 0 ) as counted, IF(c.nr IS NOT NULL, c.nr, 0) as besucher_nr, IF(c.seitenaufrufe IS NOT NULL, c.seitenaufrufe, 0) as besucher_seitenaufrufe,
		IF(c.is_robot IS NOT NULL, c.is_robot, -1 ) as is_robot, IF( c.letzte_seite IS NOT NULL, c.letzte_seite, -1 ) as letzte_seite,
		IF( online.id IS NOT NULL, online.id, 0) as online,
		IF(i.tmp_blocked = 0, 1, 0) as ignored_user, IF( i.id IS NOT NULL, i.id, -1 ) as ignored_user_id
	FROM `'. CHC_DATABASE .'`.`'. CHC_TABLE_DATA .'` AS d
	LEFT JOIN `'. CHC_DATABASE .'`.`'. CHC_TABLE_PAGES."` AS p
		ON
			p.wert =  '".$chC_seite."'
			AND p.homepage_id = ". $_CHC_CONFIG['aktuelle_homepage_id'] .'
			AND p.monat = '. $_CHC_VARIABLES['aktueller_monat'] .'
	LEFT JOIN `'. CHC_DATABASE .'`.`'. CHC_TABLE_COUNTED_USERS ."` AS c
		ON
			( (c.ip = '". $chC_REMOTE_ADDR ."')
			  OR (c.ip LIKE '". substr( $chC_REMOTE_ADDR, 0, strrpos( $chC_REMOTE_ADDR, '.' ) )."%' AND c.user_agent = '". $_CHC_DB->escape_string( $chC_HTTP_USER_AGENT ) ."')
			)
			AND c.timestamp ".
			( $_CHC_CONFIG['modus_zaehlsperre'] == 'intervall'
				? '>= '. ( CHC_TIMESTAMP - $_CHC_CONFIG['blockzeit'] )
				:	' + '
					.( ( date( 'I' ) == '1' && $_CHC_CONFIG['dst'] == '0' )
						? date( 'Z') - 3600
						: date( 'Z' )
					)
					.' >= '. $_CHC_VARIABLES['timestamp_tagesanfang']
			) .'
	LEFT JOIN `'. CHC_DATABASE .'`.`'. CHC_TABLE_ONLINE_USERS .'` as online
		ON
			c.nr = online.nr
			AND online.timestamp_letzter_aufruf >= '. ( CHC_TIMESTAMP - $_CHC_CONFIG['user_online_fuer'] ) .'
	LEFT JOIN `'.CHC_DATABASE .'`.`'. CHC_TABLE_IGNORED_USERS ."` AS i
		ON
			( (i.ip = '". $chC_REMOTE_ADDR ."')
			  OR (i.ip LIKE '". substr( $chC_REMOTE_ADDR, 0, strrpos( $chC_REMOTE_ADDR, '.' ) )."%' AND i.user_agent = '". $_CHC_DB->escape_string( $chC_HTTP_USER_AGENT ) ."')
			)
			AND i.timestamp ".
			( $_CHC_CONFIG['modus_zaehlsperre'] == 'intervall'
				? '>= '. ( CHC_TIMESTAMP - $_CHC_CONFIG['blockzeit'] )
				:	' + '
					.( ( date( 'I' ) == '1' && $_CHC_CONFIG['dst'] == '0' )
						? date( 'Z') - 3600
						: date( 'Z' )
					)
					.' >= '. $_CHC_VARIABLES['timestamp_tagesanfang']
			) .';'
);
$_CHC_VALUES = $_CHC_DB->fetch_assoc( $_CHC_VALUES );

$chC_result = $_CHC_DB->query(
	'SELECT COUNT(*) as users_online
	FROM `'. CHC_DATABASE .'`.`'. CHC_TABLE_ONLINE_USERS .'` as o
	WHERE o.timestamp_letzter_aufruf >= '. ( CHC_TIMESTAMP - $_CHC_CONFIG['user_online_fuer'] ) .';'
);
$_CHC_VALUES = array_merge( $_CHC_VALUES, $_CHC_DB->fetch_assoc( $chC_result ) );

//timer( '$_CHC_VALUES' );

#print "<pre>"; var_dump( $_CHC_VALUES) ; print "</pre>";# exit;


// Counter zuvor schon einmal _aktiv_ eingebunden
if( defined( 'CHC_ACTIVELY_EXECUTED' ) )
{
	#$_CHC_CONFIG['status'] = 'inactive';
}
elseif( $_CHC_VALUES['ignored_user'] == '1' )
// ( Status == inaktiv ) == TRUE
{
	$_CHC_CONFIG['status'] = 'inactive';
	$_CHC_DB->query(
		'UPDATE `'.CHC_DATABASE .'`.`'. CHC_TABLE_IGNORED_USERS .'`
		SET seitenaufrufe = seitenaufrufe+1, timestamp = '. CHC_TIMESTAMP .'
		WHERE id = '. $_CHC_VALUES['ignored_user_id'] .'
		LIMIT 1;'
	);
}
elseif( ( $_CHC_CONFIG['status'] != 'inactive' && $_CHC_VALUES['counted'] == '0' ) || isset( $_COOKIE['CHC_COUNT_PROTECTION'] ) )
{
	//
	// muss Status auf inaktiv gesetzt werden?
	//

	// Administrator-Cookie
	if( isset( $_COOKIE['CHC_COUNT_PROTECTION'] ) )
	{
		$chC_ignored_user_motive = 'admin';
		$chC_temporary_ignored_user = TRUE;
		$_CHC_CONFIG['status'] = 'inactive';
	}


	// "Schwarze Listen"
	//
	// User-Agents
	elseif(
		!empty( $_CHC_CONFIG['blacklist_user_agents'] )
		&& chC_list_match( $_CHC_CONFIG['blacklist_user_agents'], $chC_HTTP_USER_AGENT ) == TRUE
	)
	{
		$chC_ignored_user_motive = 'bad user agent';
		$chC_temporary_ignored_user = FALSE;
		$_CHC_CONFIG['status'] = 'inactive';
	}
	// Referrer
	elseif(
		!empty( $_CHC_CONFIG['blacklist_referrers'] )
		&& chC_list_match( $_CHC_CONFIG['blacklist_referrers'], $chC_HTTP_REFERER ) == TRUE
	)
	{
		$chC_ignored_user_motive = 'bad referrer';
		$chC_temporary_ignored_user = FALSE;
		$_CHC_CONFIG['status'] = 'inactive';
	}
	// Seiten
	elseif(
		!empty( $_CHC_CONFIG['blacklist_pages'] )
		&& chC_list_match( $_CHC_CONFIG['blacklist_pages'], $chC_seite ) == TRUE
	)
	{
		$chC_ignored_user_motive = 'bad page';
		$chC_temporary_ignored_user = TRUE;
		$_CHC_CONFIG['status'] = 'inactive';
	}
	// IP
	elseif(
		!empty( $_CHC_CONFIG['blacklist_ips'] )
		&& chC_list_match( $_CHC_CONFIG['blacklist_ips'], $chC_REMOTE_ADDR ) == TRUE
	)
	{
		$chC_ignored_user_motive = 'bad IP';
		$chC_temporary_ignored_user = FALSE;
		$_CHC_CONFIG['status'] = 'inactive';
	}
	// Hosts
	elseif( !empty( $_CHC_CONFIG['blacklist_hosts'] ) )
	{
		$chC_host = @gethostbyaddr( $chC_REMOTE_ADDR );
		if( $chC_host != $chC_REMOTE_ADDR )
		{
			if( chC_list_match( $_CHC_CONFIG['blacklist_hosts'], $chC_host ) == TRUE )
			{
				$chC_ignored_user_motive = 'bad host';
				$chC_temporary_ignored_user = FALSE;
				$_CHC_CONFIG['status'] = 'inactive';
			}
		}
	}

	// block robots
	if( $_CHC_CONFIG['block_robots'] == '1' && ( $_CHC_CONFIG['status'] != 'inactive' && $_CHC_VALUES['counted'] == '0' ) )
	{
		$chC_useragent_info = chC_analyse_user_agent( $chC_HTTP_USER_AGENT );
		if( $chC_useragent_info['robot'] == TRUE )
		{
			$_CHC_VALUES['is_robot'] = 1;
			$chC_ignored_user_motive = 'robot';
			$chC_temporary_ignored_user = FALSE;
			$_CHC_CONFIG['status'] = 'inactive';
		}
		else
		{
			$_CHC_VALUES['is_robot'] = 0;
		}
	}


	if( isset( $chC_ignored_user_motive ) )
	{
		if( $_CHC_VALUES['ignored_user_id'] != '-1' )
		{
			$_CHC_DB->query(
				'UPDATE `'.CHC_DATABASE .'`.`'. CHC_TABLE_IGNORED_USERS ."`
				SET grund = '". $chC_ignored_user_motive ."', tmp_blocked = ". intval( $chC_temporary_ignored_user ) .', seitenaufrufe = seitenaufrufe+1, timestamp = '. CHC_TIMESTAMP .'
				WHERE id = '. $_CHC_VALUES['ignored_user_id'] .'
				LIMIT 1;'
			);
		}
		else
		{
			if( empty( $chC_host ) )
			{
				$chC_host = @gethostbyaddr( $chC_REMOTE_ADDR );
			}

			if( !isset( $chC_useragent_info ) )
			{
				$chC_useragent_info = chC_analyse_user_agent( $chC_HTTP_USER_AGENT );
				$_CHC_VALUES['is_robot'] = ( $chC_useragent_info['robot'] == TRUE ) ? 1 : 0;
			}
			$_CHC_DB->query(
				'INSERT INTO `'.CHC_DATABASE .'`.`'. CHC_TABLE_IGNORED_USERS ."`
				(ip, host, grund, tmp_blocked, user_agent, is_robot, timestamp, seitenaufrufe)
				VALUES ('". $chC_REMOTE_ADDR ."', '". $chC_host ."', '". $chC_ignored_user_motive ."', ". intval( $chC_temporary_ignored_user ) .", '". $_CHC_DB->escape_string( $chC_HTTP_USER_AGENT ) ."', ". $_CHC_VALUES['is_robot'] .', '. CHC_TIMESTAMP .', 1 );'
			);
		}
	}
}


if( $_CHC_CONFIG['status'] != 'inactive' && !defined( 'CHC_ACTIVELY_EXECUTED' ) )
{
	define( 'CHC_ACTIVELY_EXECUTED', TRUE );
}


//timer( 'IGNORED_USER?' );



if( $_CHC_VALUES['counted'] == '0' && $_CHC_CONFIG['status'] != 'inactive' )
{
	$_CHC_VALUES['besucher_nr'] = $_CHC_VALUES['besucher_gesamt'] + 1;

	if( !isset( $chC_useragent_info ) )
	{
		$chC_useragent_info = chC_analyse_user_agent( $chC_HTTP_USER_AGENT );
		$_CHC_VALUES['is_robot'] = ( $chC_useragent_info['robot'] == TRUE ) ? 1 : 0;
	}

	if( empty( $chC_host ) )
	{
		$chC_host = @gethostbyaddr( $chC_REMOTE_ADDR );
	}
}


// wenn Besucher bereits gezählt:
if( $_CHC_VALUES['counted'] == '1' )
{
	$_CHC_VARIABLES['update_queries'][CHC_TABLE_COUNTED_USERS][] = 'timestamp = '. CHC_TIMESTAMP;
}
// ansonsten: neuer Besucher oder inaktiv (Administrator/ geblockter Besucher über blacklists)
else
{
	if( $_CHC_CONFIG['status'] != 'inactive' )
	{
		// Besucher blocken - so früh wie möglich, um Tabelle wieder Entsperren zu können
		// (deshalb bereits an dieser Stelle mit schon frühzeitig erhöhter nr, bevor die Besucherzahl selbst erhöht wird, is unschön)
		$_CHC_DB->query(
			'INSERT INTO `'. CHC_DATABASE .'`.`'. CHC_TABLE_COUNTED_USERS ."`
				(nr, ip, user_agent, is_robot, timestamp)
			VALUES
				('".$_CHC_VALUES['besucher_nr']."', '". $chC_REMOTE_ADDR ."', '". $_CHC_DB->escape_string ( $chC_HTTP_USER_AGENT ) ."', ". $_CHC_VALUES['is_robot'] .", ".CHC_TIMESTAMP.")"
		);

		$_CHC_VARIABLES['new_block'] = TRUE;
	}
}


/* *** Online-User-Management *** */
if( $_CHC_CONFIG['status'] != 'inactive' )
{
	// Daten des Besuchers aktualieren oder erstmalig in DB schreiben
	if( $_CHC_VALUES['online'] != '0' ) // Besucher steht schon in der DB
	{
		$_CHC_DB->query(
			'UPDATE `'. CHC_DATABASE .'`.`'. CHC_TABLE_ONLINE_USERS .'`
			SET
				timestamp_letzter_aufruf = '. CHC_TIMESTAMP .",
				seitenaufrufe = seitenaufrufe + 1,
				seite = '". $chC_seite ."',
				homepage_id = ". $_CHC_CONFIG['aktuelle_homepage_id'] .'
			WHERE id = '. $_CHC_VALUES['online'] .';'
		);
	}
	else
	{
		$_CHC_VALUES['users_online']++;
		$_CHC_DB->query(
			'INSERT INTO `'. CHC_DATABASE .'`.`'. CHC_TABLE_ONLINE_USERS .'`
			(nr, ip, user_agent, is_robot, timestamp_erster_aufruf, timestamp_letzter_aufruf, seite, homepage_id, seitenaufrufe)
			VALUES
			( '. $_CHC_VALUES['besucher_nr'] .", '". $chC_REMOTE_ADDR ."', '". $_CHC_DB->escape_string( $chC_HTTP_USER_AGENT ) ."', ". $_CHC_VALUES['is_robot'] .', '. CHC_TIMESTAMP .', '. CHC_TIMESTAMP .", '". $chC_seite ."', ".$_CHC_CONFIG['aktuelle_homepage_id'] .', 1 )'
		);
	}
}


unset( $general_db_cleanup );
if( $_CHC_VALUES['counted'] == '0' && $_CHC_CONFIG['status'] != 'inactive' )
{
		// "Garbage Cleaner"
		// - nicht mehr benötigte Daten löschen
		// - Tabellen optimieren
		// alles wenn vorgegebenes Zeitintervall verstrichen
		if( ( CHC_TIMESTAMP - $_CHC_VALUES['timestamp_letztes_db_aufraeumen'] ) > $_CHC_CONFIG['db_aufraeumen_nach'] )
		{
			$chC_general_db_cleanup = TRUE;
			$_CHC_DB->query(
				'UPDATE `'. CHC_DATABASE .'`.`'. CHC_TABLE_DATA .'`
				SET timestamp_letztes_db_aufraeumen = '. CHC_TIMESTAMP .';'
			);
		}
}



$_CHC_DB->query( 'UNLOCK TABLES;' );





// Online-User-Zahl mit Rekord abgleichen
if( $_CHC_VALUES['users_online'] > $_CHC_VALUES['max_online:anzahl'] )
{
	$_CHC_VARIABLES['update_queries'][CHC_TABLE_DATA][] = '`max_online:anzahl` = '. $_CHC_VALUES['users_online'] .', `max_online:timestamp` = '. CHC_TIMESTAMP;
	$_CHC_VALUES['max_online'] = $_CHC_VALUES['users_online'];
}



if( $_CHC_VALUES['heute_timestamp'] < $_CHC_VARIABLES['timestamp_tagesanfang'] )
{
	$_CHC_VARIABLES['update_queries'][CHC_TABLE_DATA][] =
		 'besucher_gestern = IF( heute_timestamp < '. $_CHC_VARIABLES['timestamp_tagesanfang'] .', besucher_heute, besucher_gestern ),'
		.'besucher_heute = IF( heute_timestamp < '. $_CHC_VARIABLES['timestamp_tagesanfang'] .', 0, besucher_heute),'
		.'seitenaufrufe_gestern = IF( heute_timestamp < '. $_CHC_VARIABLES['timestamp_tagesanfang'] .', seitenaufrufe_heute, seitenaufrufe_gestern ),'
		.'seitenaufrufe_heute = IF( heute_timestamp < '. $_CHC_VARIABLES['timestamp_tagesanfang'] .', 0, seitenaufrufe_heute ),'
		.'heute_timestamp = IF( heute_timestamp < '. $_CHC_VARIABLES['timestamp_tagesanfang'] .', '. $_CHC_VARIABLES['timestamp_tagesanfang'] .', heute_timestamp )';
	$_CHC_VALUES['besucher_gestern'] = $_CHC_VALUES['besucher_heute'];
	$_CHC_VALUES['besucher_heute'] = 0;
	$_CHC_VALUES['seitenaufrufe_gestern'] = $_CHC_VALUES['seitenaufrufe_heute'];
	$_CHC_VALUES['seitenaufrufe_heute'] = 0;
}


$chC_checksum = str_replace(
	chr(27),
	$_CHC_CONFIG['script_version'],
	base64_decode('CjwhLS0KfCAgY2hDb3VudGVyIBsKfCAgYSBjb3VudGVyIGFuZCBzdGF0aXN0aWNzIHNjcmlwdCB3cml0dGVuIGluIFBIUAp8ICAoYykgQ2hyaXN0b3BoIEJhY2huZXIgYW5kIEJlcnQgS29lcm4gMjAwNyAtIHJlbGVhc2VkIHVuZGVyIHRoZSBHTlUgR1BMCnwgIHNlZSBhdCBbIGh0dHA6Ly9jaENvdW50ZXIub3JnLyBdCi0tPgoKCg==' )
);



//timer( 'COUNTED, ONLINE_USERS, ...' );



/* *** Wenn nicht zu Blocken: Pro Besuch einmalige Zähl-Operationen ausführen *** */
if( $_CHC_VALUES['counted'] == '0' && $_CHC_CONFIG['status'] != 'inactive' )
{
	// zählen
	$_CHC_VALUES['besucher_gesamt']++;
	$_CHC_VALUES['besucher_heute']++;
	$_CHC_VALUES['durchschnittlich_pro_tag:besucher']++;
	$_CHC_VARIABLES['update_queries'][CHC_TABLE_DATA][] =
		 'besucher_gesamt = besucher_gesamt + 1,'
		.'besucher_heute = besucher_heute + 1, '
		.'`seitenaufrufe_pro_besucher:besucher` = `seitenaufrufe_pro_besucher:besucher` + 1, '
		.'`durchschnittlich_pro_tag:besucher` = `durchschnittlich_pro_tag:besucher` + 1';

	if( $_CHC_VALUES['besucher_heute'] > $_CHC_VALUES['max_besucher_pro_tag:anzahl'] )
	{
		$_CHC_VARIABLES['update_queries'][CHC_TABLE_DATA][] =
			'`max_besucher_pro_tag:anzahl` = besucher_heute, '
			.'`max_besucher_pro_tag:timestamp` = '.CHC_TIMESTAMP;
		$_CHC_VALUES['max_besucher_pro_tag:anzahl'] = $_CHC_VALUES['besucher_heute'];
		$_CHC_VALUES['max_besucher_pro_tag:timestamp'] = CHC_TIMESTAMP;
	}



	// loggen
	if( $_CHC_CONFIG['status_logs'] == '1' )
	{
		$_CHC_DB->query(
			'INSERT INTO `'.CHC_DATABASE .'`.`'. CHC_TABLE_LOG_DATA."`
			(nr, ip, host, user_agent, is_robot, http_accept_language, timestamp, referrer)
			VALUES
			('". $_CHC_VALUES['besucher_gesamt']."', '". $chC_REMOTE_ADDR ."', '". $chC_host ."', '". $_CHC_DB->escape_string ( $chC_HTTP_USER_AGENT )."', ". $_CHC_VALUES['is_robot'] .", '". $chC_HTTP_ACCEPT_LANGUAGE ."', ".CHC_TIMESTAMP.", '". $_CHC_DB->escape_string ( $chC_HTTP_REFERER )."')"
		);
	}




	$_CHC_DB->query(
		'LOCK TABLES
			`'. CHC_DATABASE .'`.`'. CHC_TABLE_USER_AGENTS .'` WRITE,
			`'. CHC_DATABASE .'`.`'. CHC_TABLE_REFERRERS .'` WRITE,
			`'. CHC_DATABASE .'`.`'. CHC_TABLE_LOCALE_INFORMATION .'` WRITE,
			`'. CHC_DATABASE .'`.`'. CHC_TABLE_SEARCH_ENGINES .'` WRITE,
			`'. CHC_DATABASE .'`.`'. CHC_TABLE_ACCESS .'` WRITE;'
	);



	// User-Agent-Statistik //
	if(
		$_CHC_CONFIG['status_user_agents'] == '1'	# Statistik aktiviert
		&& !empty( $chC_HTTP_USER_AGENT )	# String nicht leer
		&& !(						# User-Agent nicht in Exclusion-Liste vorhanden
			!empty( $_CHC_CONFIG['exclusion_list_user_agents'] )
			&& chC_list_match( $_CHC_CONFIG['exclusion_list_user_agents'], $_SERVER['HTTP_USER_AGENT'] ) == TRUE
		)
	  )
	{
		if( $chC_useragent_info['robot'] == TRUE )
		{
			if( $chC_useragent_info['robot'] == 'other' )
			{
				$chC_useragent_info['robot'] = strtolower( $chC_useragent_info['robot'] );
			}
			$chC_browser_or_robot = 'robot';
		}
		else
		{
			$chC_browser_or_robot = 'browser';
		}

		$chC_array = array(
			'user_agent' => $_CHC_DB->escape_string( $chC_HTTP_USER_AGENT ),
			$chC_browser_or_robot => $chC_useragent_info[$chC_browser_or_robot],
			'os' => $chC_useragent_info['os']
		);
		if( $chC_useragent_info[$chC_browser_or_robot.'_version'] == true )
		{
			$chC_array['version~'.$chC_browser_or_robot] = array(
					( $chC_useragent_info['robot'] == 'other' )
					? $_CHC_DB->escape_string(  $chC_useragent_info[$chC_browser_or_robot] .'~'. $chC_HTTP_USER_AGENT )
					: $_CHC_DB->escape_string( $chC_useragent_info[$chC_browser_or_robot] .'~'. $chC_useragent_info[$chC_browser_or_robot.'_version'] ),
				$chC_useragent_info[$chC_browser_or_robot]. '~versionen_gesamt'
			);
		}
		if( $chC_useragent_info['os_version'] == true )
		{
			$chC_array['version~os'] = array(
				$_CHC_DB->escape_string( $chC_useragent_info['os'] .'~'. $chC_useragent_info['os_version'] ),
				$chC_useragent_info['os'] .'~versionen_gesamt'
			);
		}

		if( $chC_useragent_info['robot'] == TRUE )
		{
			unset( $chC_array['os'] );
			unset( $chC_array['version~os'] );
		}


		$chC_array = chC_statistic_management( $chC_array, CHC_TABLE_USER_AGENTS, 'wert', $_CHC_VARIABLES['aktueller_monat'] );

		if( $chC_array['insert_values'] != FALSE )
		{
			$_CHC_DB->query(
				'INSERT INTO `'.CHC_DATABASE .'`.`'. CHC_TABLE_USER_AGENTS.'`
				( typ, wert, monat )
				VALUES '.
				$chC_array['insert_values']
			);
		}
		$_CHC_DB->query(
			'UPDATE `'. CHC_DATABASE .'`.`'. CHC_TABLE_USER_AGENTS .'`
			SET
				timestamp = '. CHC_TIMESTAMP .",
				anzahl = anzahl + 1,
				monat = IF( typ != 'user_agent', ". $_CHC_VARIABLES['aktueller_monat'] .', -1 )
			'. $chC_array['update_cond']

		);

	} # $_CHC_CONFIG['status_user_agents'] == '1' && ...


	//timer( 'USER_AGENTS' );


	// Referrer-Statistik //
	if(
		$_CHC_CONFIG['status_referrer'] == '1'		# Statistik aktiviert
		&& !empty( $chC_HTTP_REFERER )		# Referrer-String nicht leer
		&& !empty( $chC_refhost )
		&& !( 						# User-Agent nicht in Exclusion-Liste vorhanden
			  !empty( $_CHC_CONFIG['exclusion_list_referrers'] )
			  && chC_list_match( $_CHC_CONFIG['exclusion_list_referrers'], $_SERVER['HTTP_REFERER'] ) == TRUE
		)
		&& !( // bei Robots Referrer nicht speichern ( manche schicken z.B. die Suchmaschinen-URL jedes Mal als Referrer mit)
			$_CHC_CONFIG['block_robots'] == '0'
			&& (
				( isset( $chC_useragent_info ) && $chC_useragent_info['robot'] == TRUE )    //TODO besser, ohne is_robot
				||
				chC_is_robot( $chC_HTTP_USER_AGENT )
			)
		)
	  )
	{
		if( $_CHC_CONFIG['referrer_query_string_entfernen'] == '1' && is_int( strpos( $chC_HTTP_REFERER, '?' ) ) )
		{
			$chC_HTTP_REFERER = substr( $chC_HTTP_REFERER, 0, strpos( $chC_HTTP_REFERER, '?' ) );
		}

		if( substr( $chC_refhost, 0, 4 ) == 'www.' )
		{
			$chC_tmp_referrer = preg_replace( '#^http(s?)://www\.#', 'http\\1://', $chC_HTTP_REFERER );
			$chC_tmp_refhost = substr( $chC_refhost, 4 );
		}
		else
		{
			$chC_tmp_referrer = preg_replace( '#^http(s?)://#', 'http\\1://www.', $chC_HTTP_REFERER );
			$chC_tmp_refhost = 'www.'. $chC_refhost;
		}

		$chC_query = $_CHC_DB->query(
			'SELECT typ, wert, id
			FROM `'. CHC_DATABASE .'`.`'. CHC_TABLE_REFERRERS ."`
			WHERE
				(
					( typ = 'referrer' AND wert = '". $chC_HTTP_REFERER ."' )
					OR ( typ = 'referrer' AND wert = '". $chC_tmp_referrer ."' )
					OR ( typ = 'domain' AND wert = '". $chC_refhost ."' )
					OR ( typ = 'domain' AND wert = '". $chC_tmp_refhost ."' )
				)
				AND homepage_id = ". $_CHC_CONFIG['aktuelle_homepage_id'] .'
				AND monat = '. $_CHC_VARIABLES['aktueller_monat'] .'
			LIMIT 0,2;'
		);
		unset( $chC_referrer_id, $chC_domain_id );
		while( $chC_row = $_CHC_DB->fetch_assoc( $chC_query ) )
		{
			if( $chC_row['typ'] == 'referrer' )
			{
				$chC_referrer_id = $chC_row['id'];
			}
			else
			{
				$chC_domain_id = $chC_row['id'];
			}
		}
		$chC_insert = '';
		if( !isset( $chC_referrer_id ) )
		{
			$chC_insert .= "( 'referrer', '". $chC_HTTP_REFERER ."', ". $_CHC_CONFIG['aktuelle_homepage_id'] .', '. $_CHC_VARIABLES['aktueller_monat'] .')';
		}
		if( !isset( $chC_domain_id ) )
		{
			$chC_insert .= !empty( $chC_insert )
				? ", ( 'domain', '". $chC_refhost ."', ". $_CHC_CONFIG['aktuelle_homepage_id'] .', '. $_CHC_VARIABLES['aktueller_monat'] .')'
				: "( 'domain', '". $chC_refhost ."', ". $_CHC_CONFIG['aktuelle_homepage_id'] .', '. $_CHC_VARIABLES['aktueller_monat'] .')';
		}
		if( !empty( $chC_insert ) )
		{
			$_CHC_DB->query(
				'INSERT INTO `'. CHC_DATABASE .'`.`'. CHC_TABLE_REFERRERS .'`
				( typ, wert, homepage_id, monat )
				VALUES '. $chC_insert
			);
		}
		$_CHC_DB->query(
			'UPDATE `'. CHC_DATABASE .'`.`'. CHC_TABLE_REFERRERS .'`
			SET anzahl = anzahl + 1, timestamp = '. CHC_TIMESTAMP .'
			WHERE
				(
					'. ( !isset( $chC_referrer_id )
						? "( typ = 'referrer' AND wert = '". $chC_HTTP_REFERER ."' AND monat = ". $_CHC_VARIABLES['aktueller_monat'] .'  )'
						: 'id = '. $chC_referrer_id
					) .'
					OR '. ( !isset( $chC_domain_id )
						? "( typ = 'domain' AND wert = '". $chC_refhost ."' AND monat = ". $_CHC_VARIABLES['aktueller_monat'] .'  )'
						: 'id = '. $chC_domain_id
					) .'
				)
				AND homepage_id = '. $_CHC_CONFIG['aktuelle_homepage_id'] .'
			LIMIT 2;'
		);
	} # $_CHC_CONFIG['status_referrer'] == '1' && !empty($chC_HTTP_REFERER)


	//timer( 'REFERRER' );


	// Land/Sprache/Host //
	if(
		$_CHC_CONFIG['status_clh'] == '1'	# Statistik aktivert
	  )
	{
		// Sprache und Land des Besuchers anhand HTTP_ACCEPT_LANGUAGE
		$chC_http_accept_language_data = chC_http_accept_language_get_preferred( $chC_HTTP_ACCEPT_LANGUAGE );

		// Herkunft anhand IP/Host
		if( $chC_REMOTE_ADDR == $chC_host || preg_match( '/^\d+(\.\d+)+$/', $chC_host ) )
		{
			$chC_tld = 'unresolved';
		}
		elseif( $chC_REMOTE_ADDR == '127.0.0.1' )
		{
			$chC_tld = 'localhost';
		}
		else
		{
			if( is_int( strrpos( $chC_host, '.') ) )
			{
				$chC_tld = substr( $chC_host, strrpos( $chC_host, '.') ); # aus "abc.def.gh" -> ".gh"
				$chC_tld = empty( $chC_tld ) ? $chC_REMOTE_ADDR : $chC_tld;
			}
			else
			{
				$chC_tld = $chC_host;
			}
		}


		$chC_array = array ( 'host_tld' => $chC_tld );
		if( isset( $chC_http_accept_language_data['country'] ) )
		{
			$chC_array['country'] = $_CHC_DB->escape_string( $chC_http_accept_language_data['country'] );
		}
		if( isset( $chC_http_accept_language_data['language'] ) )
		{
			$chC_array['language'] = $_CHC_DB->escape_string( $chC_http_accept_language_data['language'] );
		}
		$chC_array = chC_statistic_management( $chC_array, CHC_TABLE_LOCALE_INFORMATION, 'wert', $_CHC_VARIABLES['aktueller_monat'] );

		if( $chC_array['insert_values'] != FALSE )
		{
			$_CHC_DB->query(
				'INSERT INTO `'.CHC_DATABASE .'`.`'. CHC_TABLE_LOCALE_INFORMATION.'`
				( typ, wert, monat )
				VALUES '. $chC_array['insert_values']
			);
		}

		$_CHC_DB->query(
			'UPDATE`'. CHC_DATABASE .'`.`'. CHC_TABLE_LOCALE_INFORMATION .'`
			SET
				anzahl = anzahl +1,
				timestamp = '. CHC_TIMESTAMP .'
			'. $chC_array['update_cond']
		);

	} # $_CHC_CONFIG['status_clh'] == '1'


	//timer( 'CLH' );

	// Suchmaschinen/-Suchwörter //
	if(
		$_CHC_CONFIG['status_suchmaschinen_und_suchwoerter'] == '1'
		&& !empty( $chC_HTTP_REFERER )
		&& !empty( $chC_refhost )
	  )
	{
		require_once( CHC_ROOT .'/includes/search_engines.lib.php' );

		foreach( $chC_search_engines as $chC_search_engine_data )
		{
			if( is_int( strpos( $chC_url_data['host'], $chC_search_engine_data['needle'] ) ) )
			{
				break;
			}
			else
			{
				unset( $chC_search_engine_data );
			}
		}

		if( isset( $chC_search_engine_data ) )
		{
			if( isset( $chC_url_data['query'] ) )
			{
				parse_str( $chC_url_data['query'], $chC_query_variables );

				if( isset( $chC_query_variables[$chC_search_engine_data['query_var']] ) )
				{
					$chC_suchphrase = trim( stripslashes( $chC_query_variables[$chC_search_engine_data['query_var']] ) );

					// Cache. Bsp nach parse_str ( == urldecode): cache:t7avrie9tosj:www.google.com/ wort1 wort2
					if(
						substr( $chC_suchphrase, 0, 6 ) == 'cache:'
					)
					{
						$chC_suchphrase = substr(
							$chC_suchphrase,
							strpos( $chC_suchphrase, ' ' )
						);
						$chC_suchphrase = trim( $chC_suchphrase );
					}

					if(
						empty( $chC_suchphrase )
						|| !preg_match( '/[\d\w]/', $chC_suchphrase )
						|| (
							intval( $_CHC_CONFIG['min_zeichenlaenge_suchwoerter_suchphrasen'] ) > 0
							&& strlen( $chC_suchphrase ) < $_CHC_CONFIG['min_zeichenlaenge_suchwoerter_suchphrasen']
						)
					)
					{
						unset( $chC_suchphrase );
					}
					else
					{
						$chC_suchphrase = chC_format_keywords( $chC_suchphrase );
					}
				}
			}

			$chC_suchmaschine = $_CHC_DB->escape_string( $chC_search_engine_data['name'] );

			if( isset( $chC_suchphrase ) )
			{
				if( $chC_anzahl = preg_match_all( '/(((\'|")?[^,]+\\3)|[^+, ]+)/', $chC_suchphrase, $chC_matches ) )
				{
					$chC_suchwoerter_array = array();
					for( $i = 0; $i < $chC_anzahl; $i++ )
					{
						/*if( !empty( $chC_matches[2][$i] ) )
						{
							// Anführungszeichen von Anfang und Ende weg
							$chC_matches[0][$i] = substr( $chC_matches[0][$i], 1, strlen( $chC_matches[0][$i] ) -2 );
						}*/
						$chC_matches[0][$i] = trim( $chC_matches[0][$i] );
						if(
							!empty( $chC_matches[0][$i] )
							&& !(						// Suchbegriff in Exclusion-Liste vorhanden
								!empty( $_CHC_CONFIG['exclusion_list_keywords'] )
								&& chC_list_match( $_CHC_CONFIG['exclusion_list_keywords'], $chC_matches[0][$i] ) == TRUE
							)
							&& preg_match( '/[\d\w]/', $chC_matches[0][$i] )
							&& !(
								intval( $_CHC_CONFIG['min_zeichenlaenge_suchwoerter_suchphrasen'] ) > 0
								&& strlen( $chC_matches[0][$i] ) < $_CHC_CONFIG['min_zeichenlaenge_suchwoerter_suchphrasen']
							)
						  )
						{                        #print mb_detect_encoding($chC_matches[0][$i]);
							$chC_suchwoerter_array[] = $chC_matches[0][$i];
						}
					}
				}


				$chC_array = array( 'suchmaschine' => $chC_suchmaschine );
				if(
					$_CHC_CONFIG['status_suchphrasen'] == '1'
					&& !(						// Suchbegriff in Exclusion-Liste vorhanden
						!empty( $_CHC_CONFIG['exclusion_list_search_phrases'] )
						&& chC_list_match( $_CHC_CONFIG['exclusion_list_search_phrases'], $chC_suchphrase ) == TRUE
					)
				  )
				{
					$chC_array['suchphrase'] = $_CHC_DB->escape_string( $chC_suchphrase );
				}
				if( isset( $chC_suchwoerter_array ) && count( $chC_suchwoerter_array ) > 0 )
				{
					$chC_array['suchwort'] = $chC_suchwoerter_array;
				}

				$chC_array = chC_statistic_management( $chC_array, CHC_TABLE_SEARCH_ENGINES, 'wert', $_CHC_VARIABLES['aktueller_monat'] );

				if( $chC_array['insert_values'] != FALSE )
				{
					$_CHC_DB->query(
						'INSERT INTO `'.CHC_DATABASE .'`.`'. CHC_TABLE_SEARCH_ENGINES.'`
						( typ, wert, monat )
						VALUES '. $chC_array['insert_values']
					);
				}

				if( $chC_array['update_cond'] != FALSE )
				{
					$_CHC_DB->query(
						'UPDATE`'. CHC_DATABASE .'`.`'. CHC_TABLE_SEARCH_ENGINES .'`
						SET
							anzahl = anzahl +1,
							timestamp = '. CHC_TIMESTAMP .'
					'. $chC_array['update_cond']
					);
				}

			}
			else
			{
				$_CHC_DB->query(
					'UPDATE `'. CHC_DATABASE .'`.`'. CHC_TABLE_SEARCH_ENGINES .'`
					SET anzahl = anzahl + 1, timestamp = '. CHC_TIMESTAMP ."
					WHERE
						typ = 'suchmaschine'
						AND wert = '". $chC_suchmaschine ."'
						AND monat = ". $_CHC_VARIABLES['aktueller_monat'] .'
					LIMIT 1'
				);

				if( $_CHC_DB->affected_rows() == 0 )
				{
					$_CHC_DB->query(
						'INSERT INTO `'. CHC_DATABASE .'`.`'. CHC_TABLE_SEARCH_ENGINES ."`
						( typ, wert, anzahl, timestamp, monat)
						VALUES ('suchmaschine', '". $chC_suchmaschine ."', 1, ". CHC_TIMESTAMP .', '. $_CHC_VARIABLES['aktueller_monat'] .');'
					);
				}
			}

		}

	} // $_CHC_CONFIG['status_suchwoerter'] == '1' && !empty( $chC_HTTP_REFERER )

	//timer( 'SUCHMASCHINEN' );



	// Zugriffsstatistik: Besucher //  und: Besucher pro Tageszeit/Wochentag
	if( $_CHC_CONFIG['status_access'] == '1' )
	{
		$chC_array = array(
			'tag'	=> $_CHC_VARIABLES['timestamp_tagesanfang'],
			'monat' => $_CHC_VARIABLES['timestamp_monatsanfang'],
			'jahr' => $_CHC_VARIABLES['timestamp_jahresanfang'],
			'kw' => $_CHC_VARIABLES['timestamp_kalenderwoche']
		);

		$chC_array = chC_statistic_management( $chC_array, CHC_TABLE_ACCESS, 'timestamp' );
		if( $chC_array['insert_values'] != FALSE )
		{
			$_CHC_DB->query( 'INSERT INTO `'.CHC_DATABASE .'`.`'. CHC_TABLE_ACCESS.'` ( typ, timestamp ) VALUES '. $chC_array['insert_values'] );
		}

		$chC_current_hour = chC_format_date( 'H', CHC_TIMESTAMP, FALSE );
		$_CHC_VARIABLES['update_queries'][CHC_TABLE_ACCESS][] = 'besucher_'. $chC_current_hour .' = besucher_'. $chC_current_hour .' + 1 ';

	} # $_CHC_CONFIG['stat_access'] == '1'


	//timer( 'ACCESS' );

	$_CHC_DB->query( 'UNLOCK TABLES;' );








	// Auflösung
	if( $_CHC_CONFIG['status_aufloesungen'] == '1' ) # Statistik aktiviert
	{
		if(
			$_CHC_CONFIG['mode'] == 'js'
			&& isset( $chC_aufloesung )
			&& !( 						# Auflösung nicht in Exclusion-Liste vorhanden
				!empty( $_CHC_CONFIG['exclusion_list_screen_resolutions'] )
				&& chC_list_match( $_CHC_CONFIG['exclusion_list_screen_resolutions'], $chC_aufloesung ) == TRUE
			)
		  ) # Aufruf des Counters erfolgt gerade über JS und die Auflösung per GET mitgeliefert
		{
			$_CHC_DB->query(
				'UPDATE `'. CHC_DATABASE .'`.`'. CHC_TABLE_SCREEN_RESOLUTIONS .'`
				SET
					anzahl = anzahl+1,
					timestamp = '. CHC_TIMESTAMP ."
				WHERE
					wert = '". $chC_aufloesung ."'
					AND monat = ". $_CHC_VARIABLES['aktueller_monat'] .'
				LIMIT 1'
			);
			if( $_CHC_DB->affected_rows() == 0 )
			{
				$_CHC_DB->query(
					'INSERT INTO `'.CHC_DATABASE .'`.`'. CHC_TABLE_SCREEN_RESOLUTIONS."`
						(wert, anzahl, timestamp, monat)
					VALUES
						( '". $chC_aufloesung ."', 1, ". CHC_TIMESTAMP .', '. $_CHC_VARIABLES['aktueller_monat'] .' );'
				);
			}
			$_CHC_VARIABLES['update_queries'][CHC_TABLE_COUNTED_USERS][] = "aufloesung = 1";
			$_CHC_DB->query(
				'UPDATE `'.CHC_DATABASE .'`.`'. CHC_TABLE_LOG_DATA ."`
				SET aufloesung = '". $chC_aufloesung ."'
				WHERE nr= ". $_CHC_VALUES['besucher_nr'] .'
				LIMIT 1'
			);
		}
		else # Counter wird nicht über den JS-Modus aufgerufen
		{
			$_CHC_VARIABLES['stat_resolution'] = TRUE; # d.h.: bei der Ausgabe des Counters JS-SCript zum Ermitteln der Auflösung mitschicken
		}

	} # $_CHC_CONFIG['status_aufloesungen'] == '1'

	//timer( 'RES' );

	// JavaScript aktiviert/deaktiviert? //
	if( $_CHC_CONFIG['status_js'] == '1' )
	{
		if( $_CHC_CONFIG['mode'] == 'js' )
		{
			$_CHC_VARIABLES['update_queries'][CHC_TABLE_DATA][] =
				 'js_alle = js_alle + 1, '
				 .'js_aktiv = js_aktiv + 1';
			$_CHC_VARIABLES['update_queries'][CHC_TABLE_COUNTED_USERS][] = 'js = 1';
			$_CHC_DB->query(
				'UPDATE `'.CHC_DATABASE .'`.`'. CHC_TABLE_LOG_DATA .'`
				SET js = 1
				WHERE nr= '. $_CHC_VALUES['besucher_nr'] .'
				LIMIT 1'
			);
		}
		else
		{
			$_CHC_VARIABLES['update_queries'][CHC_TABLE_DATA][] = 'js_alle = js_alle + 1';
			if( $_CHC_CONFIG['mode'] != 'noscript' )
			{
				$_CHC_VARIABLES['stat_js'] =  TRUE; # in Ausgabe Script hinzufügen, um zu testen, ob JS aktiviert ist oder nicht
			}
		}
		if( $_CHC_VALUES['is_robot'] == '1' )
		{
			$_CHC_VARIABLES['update_queries'][CHC_TABLE_DATA][] = 'js_robots = js_robots +1';
		}
	}


}



// immer wenn Counter aktiv:
if( $_CHC_CONFIG['status'] != 'inactive' )
{
	// Zugriffsstatistik: Seitenaufrufe //
	if( $_CHC_CONFIG['status_access'] == '1' )
	{
		# Wenn nicht neuer Besucher: prüfen, ob die Zeilen für aktuellen Tag/Monat in der Zugriffsstatistik-Tabelle vorhanden
		# Wenn nicht, hinzufügen. Bei neuem Besucher wurde dies schon um Rahmen des besucher++ erledigt (jetzt: seitenaufrufe++)
		if( !isset( $_CHC_VARIABLES['new_block'] ) )
		{
			$_CHC_DB->query( 'LOCK TABLE `'. CHC_DATABASE .'`.`'. CHC_TABLE_ACCESS .'` WRITE;' );
			$chC_array = array(
				'tag'	=> $_CHC_VARIABLES['timestamp_tagesanfang'],
				'monat' => $_CHC_VARIABLES['timestamp_monatsanfang'],
				'jahr' => $_CHC_VARIABLES['timestamp_jahresanfang'],
				'kw' => $_CHC_VARIABLES['timestamp_kalenderwoche']
			);

			$chC_array = chC_statistic_management( $chC_array, CHC_TABLE_ACCESS, 'timestamp' );
			if( $chC_array['insert_values'] != FALSE )
			{
				$_CHC_DB->query( 'INSERT INTO `'.CHC_DATABASE .'`.`'. CHC_TABLE_ACCESS.'` ( typ, timestamp ) VALUES '. $chC_array['insert_values'] );
			}
			$_CHC_DB->query( 'UNLOCK TABLE;' );
		}

		$chC_current_hour = chC_format_date( 'H', CHC_TIMESTAMP, FALSE );
		$_CHC_VARIABLES['update_queries'][CHC_TABLE_ACCESS][] = 'seitenaufrufe_'. $chC_current_hour .' = seitenaufrufe_'. $chC_current_hour .' + 1';

	} # $_CHC_CONFIG['stat_access'] == '1'



	# Weitere Seitenaufruf-Variablen erhöhen (allgemeine Rekorde in tabelle_data, und Log-Eintrag)
	$_CHC_VARIABLES['update_queries'][CHC_TABLE_DATA][] =
		'seitenaufrufe_gesamt = seitenaufrufe_gesamt + 1, '
		.'seitenaufrufe_heute = seitenaufrufe_heute + 1, '
		.'`seitenaufrufe_pro_besucher:seitenaufrufe` = `seitenaufrufe_pro_besucher:seitenaufrufe` + 1, '
		.'`durchschnittlich_pro_tag:seitenaufrufe` = `durchschnittlich_pro_tag:seitenaufrufe` + 1';
	$_CHC_VARIABLES['update_queries'][CHC_TABLE_COUNTED_USERS][] = 'seitenaufrufe = seitenaufrufe + 1';

	if( $_CHC_CONFIG['status_logs'] == '1' )
	{
		$_CHC_DB->query(
			'UPDATE `'.CHC_DATABASE .'`.`'. CHC_TABLE_LOG_DATA ."`
			SET
				seitenaufrufe = seitenaufrufe + 1,
				seiten = CONCAT( seiten, '". $chC_seite .'|'. $_CHC_CONFIG['aktuelle_homepage_id'] .'|'. CHC_TIMESTAMP ."|__|' )
			WHERE nr= ". $_CHC_VALUES['besucher_nr'] .'
			LIMIT 1'
		);
	}

	$_CHC_VALUES['seitenaufrufe_heute']++;
	$_CHC_VALUES['durchschnittlich_pro_tag:seitenaufrufe']++;
	$_CHC_VALUES['seitenaufrufe_gesamt']++;
	$_CHC_VALUES['besucher_seitenaufrufe']++;

	if( $_CHC_VALUES['seitenaufrufe_heute'] > $_CHC_VALUES['max_seitenaufrufe_pro_tag:anzahl'] )
	{
		$_CHC_VARIABLES['update_queries'][CHC_TABLE_DATA][] =
			'`max_seitenaufrufe_pro_tag:anzahl` = seitenaufrufe_heute, '
			.'`max_seitenaufrufe_pro_tag:timestamp` = '.CHC_TIMESTAMP;
		$_CHC_VALUES['max_seitenaufrufe_pro_tag:anzahl'] = $_CHC_VALUES['seitenaufrufe_heute'];
		$_CHC_VALUES['max_seitenaufrufe_pro_tag:timestamp'] = CHC_TIMESTAMP;
	}
	//timer( 'VERSCH. SEITENAUFRUFE' );


	// Seitenstatistik
	 if(
		$_CHC_CONFIG['status_seiten'] == '1'
		&& !empty( $chC_seite )
		&& !(
			!empty( $_CHC_CONFIG['exclusion_list_pages'] )
			&& chC_list_match( $_CHC_CONFIG['exclusion_list_pages'], $chC_seite ) == TRUE
		)
	   )
	{
		#if( !empty( $chCounter_page_title ) )
		#{
		#	$chCounter_page_title = chC_undo_utf8_htmlentities( $chCounter_page_title );
		#}

		if(
			empty( $chCounter_page_title )
			&& $_CHC_CONFIG['seitenstatistik_titel_suche'] == '1'
			&& ( ( strtoupper( substr( PHP_OS, 0, 3 ) ) === 'WIN' )  // counter.php nicht durchsuchen, sonst wird <title> ein paar Zeilen unter dieser Zeile hier gefunden
				? strtolower( __FILE__ ) != strtolower( str_replace( '/', '\\', $chC_script_filename ) )
				: __FILE__ != $chC_script_filename )
			&& $_CHC_CONFIG['mode'] != 'js'
		  )
		{
			$chC_file = @implode( '', @file( $chC_script_filename ) );
			if( $chC_file == TRUE)
			{
				if( $chC_anzahl = preg_match_all( '/(<!-- BEGIN CHCOUNTER_PAGE_TITLE -->|<title>)(.+)(<!-- END CHCOUNTER_PAGE_TITLE -->|<\/title>)/isU', $chC_file, $chC_matches ) )
				{
					if( $chC_anzahl == 1 )
					{
						$chCounter_page_title = $chC_matches[2][0];
					}
					elseif( $chC_anzahl > 1 )
					{
						for( $chC_i = 0; $chC_i < $chC_anzahl; $chC_i++ )
						{
							if( strtolower( $chC_matches[1][$chC_i] ) != '<title>' )
							{
								$chC_page_title_tag = $chC_i;
								break;
							}
						}
						if( !isset( $chC_page_title_tag ) )
						{
							$chC_page_title_tag = 0;
						}
						$chCounter_page_title = $chC_matches[2][$chC_page_title_tag];
					}
					$chCounter_page_title = chC_convert_encoding( $chCounter_page_title, 'UTF-8', $_CHC_CONFIG['homepage_charset'] );
					#$chCounter_page_title = chC_undo_utf8_htmlentities( $chCounter_page_title );
					$chCounter_page_title = $_CHC_DB->escape_string( trim( $chCounter_page_title ) );
				}
			}
		}
		//timer( 'SEITENSTATISTIK' );


		$_CHC_DB->query(
			'UPDATE `'. CHC_DATABASE .'`.`'. CHC_TABLE_PAGES .'`
			SET
				anzahl = anzahl + 1,
				'. ( ( $_CHC_CONFIG['status_einstiegs_ausgangsseiten'] == '1' )
					? ( $_CHC_VALUES['letzte_seite'] == -1 ? 'anzahl_einstiegsseite = anzahl_einstiegsseite +1,' : '' ) . '
					   anzahl_ausgangsseite = anzahl_ausgangsseite + 1,'
					: ''
				) .'
				timestamp = '. CHC_TIMESTAMP ." ,
				titel = '". $chCounter_page_title ."'
			WHERE
				id = ". $_CHC_VALUES['diese_seite_id'] .';'
		);
		if( $_CHC_DB->affected_rows() == 0 )
		{
			if(
				( isset( $chC_seite_in_counterverzeichnis ) && $chC_seite_in_counterverzeichnis == 1 )
				||
				chC_page_in_counter_directory( $chC_seite ) == TRUE
			)
			{
				$chC_seite_in_counterverzeichnis = 1;
			}
			else
			{
				$chC_seite_in_counterverzeichnis = 0;
			}
			$_CHC_DB->query(
				'INSERT INTO `'. CHC_DATABASE .'`.`'. CHC_TABLE_PAGES ."`
				(wert, homepage_id, counter_verzeichnis, titel, timestamp, monat, anzahl, anzahl_einstiegsseite, anzahl_ausgangsseite )
				VALUES
				( '". $chC_seite."', ". $_CHC_CONFIG['aktuelle_homepage_id'] .", ". $chC_seite_in_counterverzeichnis .", '". $chCounter_page_title ."', "
				.CHC_TIMESTAMP .', '. $_CHC_VARIABLES['aktueller_monat'] .', 1, '. ( $_CHC_VALUES['letzte_seite'] == -1 ? '1' : '0' ) . ', 1 )'
			);
			$_CHC_VALUES['diese_seite_id'] = $_CHC_DB->insert_id();
		}

		if( $_CHC_CONFIG['status_einstiegs_ausgangsseiten'] == '1' && $_CHC_VALUES['letzte_seite'] > 0 )
		{
			$_CHC_DB->query(
				'UPDATE `'. CHC_DATABASE .'`.`'. CHC_TABLE_PAGES .'`
				SET anzahl_ausgangsseite = anzahl_ausgangsseite -1
				WHERE id = '. $_CHC_VALUES['letzte_seite'] .';'
			);
		}

		$_CHC_VARIABLES['update_queries'][CHC_TABLE_COUNTED_USERS][] = 'letzte_seite = '. $_CHC_VALUES['diese_seite_id'];


	} # $_CHC_CONFIG['status_seiten'] == '1' && !empty($chC_seite)

}



//timer( 'VOR DB_CLEANUP' );


/* *** abschließende Datenbank-Operationen *** */


if( isset( $chC_general_db_cleanup ) && $chC_general_db_cleanup == TRUE )
{
	chC_general_db_cleanup();
}

//timer( 'NACH DB_CLEANUP' );

// die gesammelten Update-Statements an DB senden
foreach( $_CHC_VARIABLES['update_queries'] as $chC_table => $chC_fields )
{
	if( count( $chC_fields ) == 0 )
	{
		continue;
	}
	$chC_sql = 'UPDATE `'.CHC_DATABASE .'`.`'. $chC_table.'` '
		.'SET '. implode( ', ', $chC_fields );

	switch( $chC_table )
	{
		case CHC_TABLE_COUNTED_USERS:
			$chC_sql .= ' WHERE nr = '.$_CHC_VALUES['besucher_nr'];
			break;

		case CHC_TABLE_ACCESS:
			$chC_sql .= ' WHERE '
				."(typ = 'monat' AND timestamp = '".$_CHC_VARIABLES['timestamp_monatsanfang']."') "
				."OR (typ = 'tag' AND timestamp = '".$_CHC_VARIABLES['timestamp_tagesanfang']."') "
				."OR (typ = 'jahr' AND timestamp = '".$_CHC_VARIABLES['timestamp_jahresanfang']."') "
				."OR (typ = 'kw' AND timestamp = '".$_CHC_VARIABLES['timestamp_kalenderwoche']."') "
				."OR typ = 'tageszeit' "
				."OR typ = 'wochentag_". ( chC_format_date( 'w', CHC_TIMESTAMP, FALSE ) == '0' ? 7 : chC_format_date( 'w', CHC_TIMESTAMP, FALSE )  ) .'_'. chC_format_date( 'D', CHC_TIMESTAMP, FALSE ) ."'";
	}
	$_CHC_DB->query( $chC_sql );
}

//timer( 'UPDATE_STATEMENTS' );

#print "<!-- <br />\n<br />\nausgeführte Datenbank-Queries: ".$_CHC_DB->get_number_of_queries()."<br />\n<pre>";
#print_r($_CHC_DB->statements);
#print "</pre><br />\n<br /> -->\n";



/************** Ausgabe **************/

if( $_CHC_CONFIG['mode'] != 'js' && !( isset( $chCounter_no_ouput ) && $chCounter_no_ouput == TRUE ) )
{
	print $chC_checksum;
	if( $_CHC_CONFIG['status'] == 'inactive' )
	{
		print '<!-- chCounter '. $_CHC_CONFIG['script_version'] .": inactive -->\n";
	}
}


if( isset( $_CHC_VARIABLES['stat_resolution'] ) || isset( $_CHC_VARIABLES['stat_js'] ) )
{
	print '<!-- BEGIN chCounter '.$_CHC_CONFIG['script_version']." additional statistics -->\n"
		. "<script type=\"text/javascript\">\n"
		."// <![CDATA[\n"
		. "document.write(\"<script type=\\\"text/javascript\\\" src=\\\"" . $_CHC_CONFIG['aktuelle_counter_url'] ."/additional.php?";
	$chC_query = isset( $_CHC_VARIABLES['stat_resolution'] ) ? "res_width=\" + screen.width + \"&res_height=\" + screen.height + \"" : '';
	if( isset( $_CHC_VARIABLES['stat_js'] ) )
	{
		$chC_query .= empty( $chC_query ) ? 'js=true' : '&js=true';
	}
	print $chC_query ."\\\"><\/script>\");\n"
		."// ]]>\n"
		."</script>\n"
		.'<!-- END chCounter '.$_CHC_CONFIG['script_version']." additional statistics -->\n";
}

if( $_CHC_CONFIG['visibility'] == 1 )
{
	/* *** Sprachdatei *** */
	if( !isset( $_CHC_LANG ) )
	{
		ob_start();
		require_once( CHC_ROOT .'/languages/'. $_CHC_CONFIG['lang'] .'/lang_config.inc.php' );
		require_once( CHC_ROOT .'/languages/'. $_CHC_CONFIG['lang'] .'/main.lang.php' );
		ob_end_clean();
	}

	$_CHC_TPL = new chC_template();

	if( !empty( $chCounter_template ) )
	{
		$_CHC_TPL->load_template( $chCounter_template );
	}
	else
	{
		$_CHC_TPL->load_file( CHC_ROOT.'/templates/counter.tpl.html' );
	}

	$chC_laufzeit = ( CHC_TIMESTAMP - gmmktime(
				0,
				0,
				0,
				gmdate( 'n', $_CHC_VALUES['durchschnittlich_pro_tag:timestamp'] ),
				gmdate( 'j', $_CHC_VALUES['durchschnittlich_pro_tag:timestamp'] ),
				gmdate( 'y', $_CHC_VALUES['durchschnittlich_pro_tag:timestamp'] )
			)
		) / 86400;

	$_CHC_TPL->assign( array(
			'L_COUNTER_START' => $_CHC_LANG['counter_start:'],
			'V_COUNTER_START' => $_CHC_CONFIG['timestamp_start_pseudo'] != '0'
				? chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $_CHC_CONFIG['timestamp_start_pseudo'] )
				: $_CHC_LANG['unknown'],

			'L_TOTAL_VISITORS' => $_CHC_LANG['total_visitors:'],
			'V_TOTAL_VISITORS' => number_format( $_CHC_VALUES['besucher_gesamt'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'L_VISITORS_TODAY' => $_CHC_LANG['visitors_today:'],
			'V_VISITORS_TODAY' => number_format( $_CHC_VALUES['besucher_heute'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'L_VISITORS_YESTERDAY' => $_CHC_LANG['visitors_yesterday:'],
			'V_VISITORS_YESTERDAY' => number_format( $_CHC_VALUES['besucher_gestern'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'L_VISITORS_PER_DAY' => $_CHC_LANG['visitors_per_day:'],
			'V_VISITORS_PER_DAY' => number_format( @round( $_CHC_VALUES['durchschnittlich_pro_tag:besucher'] / $chC_laufzeit, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'L_VISITORS_CURRENTLY_ONLINE' => $_CHC_LANG['visitors_currently_online:'],
			'V_VISITORS_CURRENTLY_ONLINE' => number_format( $_CHC_VALUES['users_online'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'L_MAX_VISITORS_ONLINE' => $_CHC_LANG['max_visitors_online:'],
			'V_MAX_VISITORS_ONLINE' => number_format( $_CHC_VALUES['max_online:anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'L_MAX_VISITORS_ONLINE_DATE' => $_CHC_LANG['max_visitors_online_date:'],
			'V_MAX_VISITORS_ONLINE_DATE' => $_CHC_VALUES['max_online:timestamp'] != '0'
				? chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:complete'], $_CHC_VALUES['max_online:timestamp'] )
				: $_CHC_LANG['unknown'],

			'L_MAX_VISITORS_PER_DAY' => $_CHC_LANG['max_visitors_per_day:'],
			'V_MAX_VISITORS_PER_DAY' => number_format( $_CHC_VALUES['max_besucher_pro_tag:anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'L_MAX_VISITORS_PER_DAY_DATE' => $_CHC_LANG['max_visitors_per_day_date:'],
			'V_MAX_VISITORS_PER_DAY_DATE' => $_CHC_VALUES['max_besucher_pro_tag:timestamp'] != '0'
				? chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $_CHC_VALUES['max_besucher_pro_tag:timestamp'] )
				: $_CHC_LANG['unknown'],

			'L_TOTAL_PAGE_VIEWS' => $_CHC_LANG['total_page_views:'],
			'V_TOTAL_PAGE_VIEWS' => number_format( $_CHC_VALUES['seitenaufrufe_gesamt'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'L_PAGE_VIEWS_TODAY' => $_CHC_LANG['page_views_today:'],
			'V_PAGE_VIEWS_TODAY' => number_format( $_CHC_VALUES['seitenaufrufe_heute'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'L_PAGE_VIEWS_YESTERDAY' => $_CHC_LANG['page_views_yesterday:'],
			'V_PAGE_VIEWS_YESTERDAY' => number_format( $_CHC_VALUES['seitenaufrufe_gestern'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'L_PAGE_VIEWS_PER_DAY' => $_CHC_LANG['page_views_per_day:'],
			'V_PAGE_VIEWS_PER_DAY' => number_format( @round( $_CHC_VALUES['durchschnittlich_pro_tag:seitenaufrufe'] / $chC_laufzeit, 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'L_MAX_PAGE_VIEWS_PER_DAY' => $_CHC_LANG['max_page_views_per_day:'],
			'V_MAX_PAGE_VIEWS_PER_DAY' => number_format( $_CHC_VALUES['max_seitenaufrufe_pro_tag:anzahl'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'L_MAX_PAGE_VIEWS_PER_DAY_DATE' => $_CHC_LANG['max_page_views_per_day_date:'],
			'V_MAX_PAGE_VIEWS_PER_DAY_DATE' => $_CHC_VALUES['max_seitenaufrufe_pro_tag:timestamp'] != '0'
				? chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:date_only'], $_CHC_VALUES['max_seitenaufrufe_pro_tag:timestamp'] )
				: $_CHC_LANG['unknown'],

			'L_PAGE_VIEWS_PER_VISITOR' => $_CHC_LANG['page_views_per_visitor:'],
			'V_PAGE_VIEWS_PER_VISITOR' => number_format( @round( $_CHC_VALUES['seitenaufrufe_pro_besucher:seitenaufrufe'] / $_CHC_VALUES['seitenaufrufe_pro_besucher:besucher'], 2 ), 2, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'L_PAGE_VIEWS_OF_CURRENT_VISITOR' => $_CHC_LANG['page_views_of_current_visitor:'],
			'V_PAGE_VIEWS_OF_CURRENT_VISITOR' => number_format( $_CHC_VALUES['besucher_seitenaufrufe'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] ),

			'L_JAVASCRIPT_ACTIVATED' => $_CHC_LANG['javascript_activated:'],
			'V_JS_PERCENTAGE' => $_CHC_CONFIG['status_js'] == '1'
				? @round(
					$_CHC_VALUES['js_aktiv'] / ( ( $_CHC_CONFIG['robots_von_js_stats_ausschliessen'] == '0' ) ? $_CHC_VALUES['js_alle'] : $_CHC_VALUES['js_alle'] - $_CHC_VALUES['js_robots'] ) * 100,
					2
				) .'%'
				: $_CHC_LANG['deactivated'],

			'V_COUNTER_URL' => $_CHC_CONFIG['aktuelle_counter_url'],
			'L_STATISTICS' => $_CHC_LANG['statistics']
		)
	);

	if( $chCounter_show_page_views_of_the_current_page === TRUE )
	{
		$chC_result = $_CHC_DB->query(
			'SELECT SUM( anzahl ) as diese_seite_seitenaufrufe
			FROM `'. CHC_DATABASE .'`.`'. CHC_TABLE_PAGES ."` as p
			WHERE
				p.wert =  '". $chC_seite ."'
				AND p.homepage_id = ". $_CHC_CONFIG['aktuelle_homepage_id'] .';'
		);
		$chC_result = $_CHC_DB->fetch_assoc( $chC_result );

		$_CHC_TPL->assign( array(
				'L_PAGE_VIEWS_THIS_PAGE' => $_CHC_LANG['page_views_this_page:'],
				'V_PAGE_VIEWS_THIS_PAGE' => number_format( $chC_result['diese_seite_seitenaufrufe'], 0, $_CHC_LANG['CONFIG']['decimal_separator'], $_CHC_LANG['CONFIG']['thousands_separator'] )
			)
		);
	}
	$chC_counter_output = $_CHC_TPL->get_tpl_as_var();
	$chC_counter_output = chC_convert_encoding( $chC_counter_output, $_CHC_CONFIG['homepage_charset'], 'UTF-8' );
	if( $_CHC_CONFIG['mode'] == 'js' )
	{
		$chC_counter_output = preg_replace( '/\r\n|\r|\n/', '', addslashes( $chC_counter_output ) );
		print 'document.write("'. $chC_counter_output ."\");\n";
	}
	else
	{
		print $chC_counter_output;
	}

	$_CHC_TPL->free();
}



if( isset( $chCounter_no_output ) && $chCounter_no_output == TRUE )
{
	ob_end_clean();
}


if( $chCounter_force_new_db_connection === TRUE )
{
	$_CHC_DB->close();
	unset( $_CHC_DB );
}


// error_reporting und magic_quotes_runtime auf alte Werte
set_magic_quotes_runtime( $chC_old_magic_quotes_runtime );
error_reporting( $chC_old_error_reporting );


//timer( 'Ende counter.php' );

#include(CHC_ROOT.'/unblock.php');

?>