<?php

/*
 **************************************
 *
 * administration/visitor_details.php
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

if( @ini_get( 'register_globals' ) )
{
	foreach ( $_REQUEST as $var_name => $void )
	{
		unset( ${$var_name} );
	}
}

define( 'CHC_ROOT', dirname( dirname( __FILE__ ) ) );

require_once( '../includes/config.inc.php' );
require_once( '../includes/common.inc.php' );
require_once( '../includes/mysql.class.php' );
require_once( '../includes/user_agents.lib.php' );
require_once( '../includes/functions.inc.php' );

$_CHC_DB = new chC_mysql( $_CHC_DBCONFIG['server'], $_CHC_DBCONFIG['user'], $_CHC_DBCONFIG['password'], $_CHC_DBCONFIG['database'] );


// Konfiguration einholhen
$_CHC_CONFIG = chC_get_config();

// Sprachdateien einbinden
ob_start();
require( '../languages/'. $_CHC_CONFIG['lang_administration'] .'/lang_config.inc.php' );
require( '../languages/'. $_CHC_CONFIG['lang_administration'] .'/main.lang.php' );
require( '../languages/'. $_CHC_CONFIG['lang_administration'] .'/administration.lang.php' );
ob_end_clean();


if( $_CHC_CONFIG['aktiviere_seitenverwaltung_von_mehreren_domains'] == '1' )
{
	chC_evaluate( 'homepage', $aktuelle_homepage_id, $aktuelle_homepage_url );
	$aktuelle_counter_url = chC_get_url( 'counter', $aktuelle_homepage_id );
}
else
{
	$aktuelle_counter_url = $_CHC_CONFIG['default_counter_url'];
}


$login = chC_manage_login();
if( chC_logged_in() != 'admin' )
{
	require_once( '../includes/template.class.php' );
	$_CHC_TPL = new chC_template(); 

	$failed_login = ( $login == -1 ) ? 1 : 0;
	print chC_get_login_page(
		$_CHC_LANG['online_users_page_title'],
		$failed_login
	);
	exit;
}


if( isset( $_GET['user_nr'] ) )
{
	$result = $_CHC_DB->query(
		'SELECT
			nr,
			ip,
			host,
			user_agent,
			http_accept_language,
			timestamp,
			referrer,
			seitenaufrufe,
			seiten,
			js,
			aufloesung,
			downloads,
			hyperlinks
		FROM `'.CHC_TABLE_LOG_DATA.'`
		WHERE nr = '. intval( $_GET['user_nr'] ) .'
		LIMIT 0, 1'
	);

	$title = 'chCounter '. $_CHC_CONFIG['script_version'] .' - ' .$_CHC_LANG['visitor_details'];
	
	print '<?xml version="1.0" encoding="UTF-8"?>'."\n"; 
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title><?php print $title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="author" content="Bert Körn & Christoph Bachner" />
	<meta name="robots" content="noindex,nofollow" /> 
  <link rel="stylesheet" type="text/css" href="style.css" />
  <style type="text/css">
  .table_pages td{ padding: 0px; }
  .table_pages .right_column{ padding-left: 20px; }
  </style>
 </head>
 <body>
  <div class="main_box" style="width: 650px">
   <div class="header"><b><?php print $title; ?></b></div>
   <div class="content">
    <?php
	if( $_CHC_DB->num_rows( $result ) != 1 )
	{
		print $_CHC_LANG['the_requested_visitor_does_not_exist'];
	}
	else
	{
		print "<table style=\"width: 628px; border: 0px;\" cellspacing=\"1\" cellpadding=\"1\">\n";

		$row = $_CHC_DB->fetch_assoc( $result );

		if( !empty( $row['referrer'] ) )
		{
			$referrer = '<a href="'. chC_str_prepare_for_output( $row['referrer'] ) .'" target="_blank">'. chC_str_prepare_for_output( $row['referrer'], 70 ). '</a>';
		}
		else
		{
			$referrer = '';
		}
    ?>
     <tr class="row1">
      <td style="padding-right: 6px"><?php print $_CHC_LANG['No.']; ?></td>
      <td><?php print $row['nr']; ?></td>
     </tr>
     <tr class="row2">
      <td style="padding-right: 6px"><?php print $_CHC_LANG['date_time']; ?></td>
      <td><?php print chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:complete'], $row['timestamp'] ); ?></td>
     </tr>
     <tr class="row1">
      <td style="padding-right: 6px"><?php print $_CHC_LANG['IP']; ?></td>
      <td><?php print chC_str_prepare_for_output( $row['ip'] ); ?></td>
     </tr>
     <tr class="row2">
      <td style="padding-right: 6px"><?php print $_CHC_LANG['Host']; ?></td>
      <td><?php print chC_str_prepare_for_output( $row['host'] ); ?></td>
     </tr>
     <tr class="row1">
      <td style="padding-right: 6px"><?php print $_CHC_LANG['user_agent']; ?></td>
      <td>
		<?php
		$useragent_info = chC_analyse_user_agent( $row['user_agent'] );
		if( $useragent_info['browser'] == TRUE )
		{
			print '<img src="../images/browsers/'. $useragent_info['browser_icon'] .'" alt="" title="';
			print ( $useragent_info['browser'] == 'unknown' ) ? $_CHC_LANG['unknown_browser'] : $useragent_info['browser'];
			print ( $useragent_info['browser_version'] == TRUE && $useragent_info['browser_version'] != 'unknown' ) ? ' '. $useragent_info['browser_version'] : '';
			print "\" />\n";
		}
		if( $useragent_info['robot'] == TRUE )
		{
			print '<img src="../images/robots/'. $useragent_info['robot_icon'] .'" alt="" title="';
			print ( $useragent_info['robot'] == 'other' ) ? $_CHC_LANG['unknown_robot'] : $useragent_info['robot'];
			print ( $useragent_info['robot_version'] == TRUE && $useragent_info['robot'] != 'other' ) ? ' '.$useragent_info['robot_version'] : '';
			print "\" />\n";
		}
		if( $useragent_info['os'] == TRUE && $useragent_info['robot'] != TRUE )
		{
			print ' <img src="../images/os/'. $useragent_info['os_icon'] .'" alt="" title="';
			print ( $useragent_info['os'] == 'unknown' ) ? $_CHC_LANG['unknown_operating_system'] : $useragent_info['os'];
			print ( $useragent_info['os_version'] == TRUE && $useragent_info['os_version'] != 'unknown' ) ? ' '.$useragent_info['os_version'] : '';
			print "\" />";
		}
		print "<br />\n       ". chC_str_prepare_for_output( $row['user_agent'], 70 );
		?>
      </td>
     </tr>
     <tr class="row2">
      <td style="padding-right: 6px;"><?php print $_CHC_LANG['browser\'s_language_settings']; ?></td>
      <td>
       <?php       
		if( empty( $row['http_accept_language'] ) )
		{
			print $_CHC_LANG['not_available'];
		}
		else
		{
			$http_accept_language_data = chC_http_accept_language_get_preferred( $row['http_accept_language'] );
			
			print '<i>'. $_CHC_LANG['preferred:'] .'</i> ';
			if( !isset( $http_accept_language_data['language'] ) )
			{
				print $_CHC_LANG['unknown'];
			}
			else
			{
				$accept_lang = $http_accept_language_data['language'];
				print isset( $_CHC_LANG['lib_languages'][$accept_lang] )
					? $_CHC_LANG['lib_languages'][$accept_lang]
					: $accept_lang;
				if( isset( $http_accept_language_data['country'] ) )
				{
					$accept_country = $http_accept_language_data['country'];
					print ' / ';
					print isset( $_CHC_LANG['lib_countries'][$accept_country] )
						? $_CHC_LANG['lib_countries'][$accept_country]
						: strtoupper( $accept_country );

					if( is_file( CHC_ROOT .'/images/flags/'. $accept_country .'.gif' ) )
					{
						print ' <img src="../images/flags/'. $accept_country .'.gif" alt="" title="'
						. ( isset( $_CHC_LANG['lib_countries'][$accept_country] )
							? $_CHC_LANG['lib_countries'][$accept_country]
							: $accept_country )
						.'" />';
					}
				}
				print "<br />\n". $row['http_accept_language'];
			}
		}
       ?>
      </td>
     </tr>
     <tr class="row1">
      <td style="padding-right: 6px"><?php print $_CHC_LANG['referrer']; ?></td>
      <td><?php print $referrer; ?></td>
     </tr>
     <tr class="row2">
      <td style="padding-right: 6px"><?php print $_CHC_LANG['javascript']; ?></td>
      <td><?php
		print ( $row['js'] == '1' )
			? $_CHC_LANG['js_available_and_activated']
			: $_CHC_LANG['js_not_available_or_deactivated'];
		?></td>
     </tr>
     <tr class="row1">
      <td style="padding-right: 6px"><?php print $_CHC_LANG['screen_resolution']; ?></td>
      <td><?php print $row['aufloesung'] != '0' ? chC_str_prepare_for_output( $row['aufloesung'] ) : ''; ?></td>
     </tr>
     <tr class="row2">
      <td style="padding-right: 6px"><?php print $_CHC_LANG['page_views']; ?>:</td>
      <td><?php print $row['seitenaufrufe']; ?></td>
     </tr>
     <tr class="row1">
      <td style="padding-right: 6px; vertical-align:top;"><?php print $_CHC_LANG['visited_pages']; ?></td>
      <td>
       <table style="border:0px" class="table_pages">
		<?php
		$bedingung = '';
		$array = explode( '|__|', $row['seiten'] );
		$seiten = array();
		for( $i = 0; $i < count( $array )-1; $i++ )
		{
			$seite = explode( '|', $array[$i] );
			if( count( $seite ) > 3 ) # wenn ein '|' im Seitenpfad vorkommen sollte. seite|homepage_id|timestamp
			{
				$tmp = '';
				$tmp2 = $seite[count( $seite ) - 2]; // homepage_id
				$tmp3 = $seite[count( $seite ) - 1]; // timestamp
				for( $j = 0; $j < count( $seite ) - 2; $j++ )
				{
					$tmp .= ( $j == 0 ) ? $seite[$j] : '|'.$seite[$j];
				}
				$seiten[] = array(
					'seite' => $tmp,
					'homepage_id' => $tmp2,
					'timestamp' => $tmp3
				);
			}
			else
			{
				$seiten[] = array(
					'seite' => $seite[0],
					'homepage_id' => $seite[1],
					'timestamp' => $seite[2]
				);
			}
			$bedingung .= !empty( $bedingung ) ? ' OR ' : '';
			$bedingung .= "( wert ='". $_CHC_DB->escape_string( $seite[0] ) ."' AND homepage_id = ". $seite[1] .')';
		}
		$result = $_CHC_DB->query(
			'SELECT wert, titel FROM `'. CHC_TABLE_PAGES .'`
			WHERE '. $bedingung .'
			ORDER BY monat DESC'
		);
		$titel = array();
		if( $_CHC_CONFIG['logdaten_zeige_seitentitel'] == '1' )
		{
			while( $zeile = $_CHC_DB->fetch_assoc( $result ) )
			{
			 	if( !isset( $titel[$zeile['wert']] ) )
			 	{
					$titel[$zeile['wert']] = $zeile['titel'];
				}
			}
		}
		foreach( $seiten as $seite )
		{
			$seite['titel'] = ( isset( $titel[$seite['seite']] ) && !empty(  $titel[$seite['seite']] ) ) ? $titel[$seite['seite']] : $seite['seite'];

			print "<tr>\n"
				.'<td>'. chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:complete'], $seite['timestamp'] ) ."</td>\n"
				.'<td class="right_column"><a href="'. chC_get_url( chC_page_in_counter_directory( $seite['seite'], $seite['homepage_id'] ) == FALSE ? 'homepage' : 'counter', $seite['homepage_id'] ) . htmlentities( $seite['seite'] ) .'" target="_blank" title="'. htmlentities( $seite['seite'] ) .'">'
				. chC_str_prepare_for_output( ( ( strlen( $seite['titel'] ) > 40 ) ? chC_utf8_substr( $seite['titel'], 0, 40 ) .'...' : $seite['titel'] ), 0, TRUE, TRUE ) .'</a>'
				."</td>\n"
				."</tr>\n";
		}
	?>
       </table>
      </td>
     </tr>
	<?php
	foreach( array( 'downloads' => CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED, 'hyperlinks' => CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED ) as $dls_or_links => $status )
	{
		if( $status == TRUE )
		{
			?>
     <tr class="row<?php print $dls_or_links == 'downloads' ? '2' : '1'; ?>">
      <td style="padding-right: 6px; vertical-align:top;"><?php print $dls_or_links == 'downloads' ? $_CHC_LANG['downloads'] : $_CHC_LANG['hyperlinks']; ?></td>
      <td>
			<?php
			if( !empty( $row[$dls_or_links] ) )
			{
				print '       <table style="border:0px" class="table_pages">'."\n";
				$bedingung = "typ = '". ( $dls_or_links == 'downloads' ? 'download' : 'hyperlink' ) ."'";
				$array = explode( ';', $row[$dls_or_links] );
				$entries_form_log_data = array();
				for( $i = 0; $i < count( $array )-1; $i++ )
				{
					$entry = explode( ',', $array[$i] );
					$entries_form_log_data[] = array(
						'id' => $entry[0],
						'wert' => '',
						'timestamp' => $entry[1]
					);
					$bedingung .= ' OR ( id ='. $entry['0'] .' )';
				}
				$result = $_CHC_DB->query(
					'SELECT id, wert FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS .'`
					WHERE '. $bedingung
				);
				$entries = array();
				while( $zeile = $_CHC_DB->fetch_assoc( $result ) )
				{
					$entries[$zeile['id']] = $zeile;
				}
				foreach( $entries_form_log_data as $entry )
				{
					if( !isset( $entries[$entry['id']] ) )
					{
						continue;
					}

					print "<tr>\n"
					.'<td>'. chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:complete'], $entry['timestamp'] ) ."</td>\n"
					.'<td class="right_column"><a href="'. $aktuelle_counter_url .'/'. ( $dls_or_links == 'downloads' ? 'getfile' : 'refer' ) .'.php?id='. $entry['id'] .'" target="_blank">'
					. chC_str_prepare_for_output( ( ( strlen( $entries[$entry['id']]['wert'] ) > 40 ) ? chC_utf8_substr( $entries[$entry['id']]['wert'], 0, 40 ) .'...' : $entries[$entry['id']]['wert'] ) ) .'</a>'
					."</td>\n"
					."</tr>\n";
				}
				print "</table>\n";
			}
		#else
		#{
		#	print '-';
		#}
	?>
      </td>
     </tr>
<?php
	} // if status == TRUE
	} // foreach
} // else (d.h. num_rows == 1 )
?>
   </table>
   </div>
   <div class="footer">&nbsp;</div>
  </div>
  <br />
  <br />
  <div style="text-align: center;"><a href="javascript:window.close()"><?php print $_CHC_LANG['close_window']; ?></a></div>
 </body>
</html>
<?php
} // if( isset( $_GET['user_nr'] ) )
?>
