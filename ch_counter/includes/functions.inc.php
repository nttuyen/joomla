<?php

/*
 **************************************
 *
 * includes/functions.inc.php
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



// wenn der Counter selber innerhalb einer Funktion inkludiert wird, gibt's ohne diese globals Probleme:
global $_CHC_DB, $_CHC_LANG, $_CHC_CONFIG, $_CHC_TPL;
global $chC_ualib_browsers, $chC_ualib_os, $chC_ualib_robots;



function chC_format_date( $format, $timestamp, $localize = TRUE, $zeitzone = FALSE, $dst = FALSE )
{
	global $_CHC_LANG, $_CHC_CONFIG;

	if( $zeitzone === FALSE )
	{
		$zeitzone = $_CHC_CONFIG['zeitzone'];
	}
	if( $dst === FALSE )
	{
		$dst = $_CHC_CONFIG['dst'];
	}

	$datum = gmdate( $format, $timestamp + ( 3600 * ( $zeitzone + $dst ) ) );
	if( $datum === FALSE )
	{
		return $timestamp;
	}

	return ( $localize === TRUE ) ? chC_localize_date( $datum ) : $datum;
}


function chC_localize_date( $datum )
{
	global $_CHC_LANG;
	return ( $_CHC_LANG['CONFIG']['lang_code'] != 'en' ) ? strtr( $datum, $_CHC_LANG['date'] ) : $datum;
}


function chC_format_month( $string, &$liste_monate )
{
	$jahr = substr( $string, 0, 4 );
	$monat = substr( $string, 4 );
	$monat = str_replace( array_keys( $liste_monate ), $liste_monate, $monat );
	return $monat .' '. $jahr;
}



function chC_get_first_cw( $year )
{
	global $_CHC_CONFIG;

	$wochentag = gmdate(
		'w',
		gmmktime( 0, 0, 0, 1, 1, $year )
	);

	// 1. Kalenderwoche: 1. Woche mit mindestens 4 der ersten 7 Januartage. Wochenbeginn laut ISO 8601 (1988): Montag
	if( $wochentag <= 4 )
	{
		// wir sind in der ersten Kalenderwoche -> auf den Montag dieser Woche zurückgehen
		$montag = gmmktime( 0, 0, 0, 1, 1 - ( $wochentag - 1 ), $year );
	}
	else
	{
		// wir sind der letzten Woche des vergangenen Jahres -> auf den nächsten  Montag vor
		$montag = gmmktime( 0, 0, 0, 1, 1 + ( 7 - $wochentag + 1 ), $year );
	}
	return $montag;
}


function chC_get_timestamp_of_cw( $calendar_week, $year )
{
	global $_CHC_CONFIG;

	// Timestamp der ersten Kalenderwoche (des Montags) berechnen, mit gmmktime auf dieses Datum hochrechnen auf angegebene Kalenderwoche

	$erste_kw = chC_get_first_cw( $year );
	$zu_addierende_tage = ( $calendar_week - 1 ) * 7;

	return gmmktime(
		0,
		0,
		0,
		gmdate( 'm', $erste_kw ), // Monat des Anfangs der ersten KW
		gmdate( 'd', $erste_kw ) + $zu_addierende_tage, // jetziger Tag + zu addieren Tage, um auf angegebene KW zu kommen
		gmdate( 'Y', $erste_kw ) // Jahr des Anfangs der ersten KW
	);
}


function chC_get_timestamp( $type )
{
	global $_CHC_CONFIG;

	if( $type == 'tag' )
	{
		// Anfang des jetzigen Tages
		return gmmktime(
			0,
			0,
			0,
			chC_format_date( 'n', CHC_TIMESTAMP, FALSE ),
			chC_format_date( 'j', CHC_TIMESTAMP, FALSE ),
			chC_format_date( 'Y', CHC_TIMESTAMP, FALSE )
		);
	}
	elseif( $type == 'kw' )
	{
		// Anfang der jetzigen Kalenderwoche
		return chC_get_timestamp_of_cw(
			chC_format_date( 'W', CHC_TIMESTAMP, FALSE ),
			chC_format_date( 'Y', CHC_TIMESTAMP, FALSE )
		);
	}
	elseif( $type == 'monat' )
	{
		// Anfang des jetzigen Monats
		return  gmmktime(
			0,
			0,
			0,
			chC_format_date( 'n', CHC_TIMESTAMP, FALSE ),
			1,
			chC_format_date( 'Y', CHC_TIMESTAMP, FALSE )
		);
	}
	elseif( $type == 'jahr' )
	{
		// Anfang des jetzigen Jahres
		return gmmktime(
			0,
			0,
			0,
			1,
			1,
			chC_format_date( 'Y', CHC_TIMESTAMP, FALSE )
		);
	}

	return FALSE;
}


function chC_statistic_management( $data_to_deal_with, $table, $field, $month = FALSE )
{
	global $_CHC_CONFIG, $_CHC_DB;

	if( count( $data_to_deal_with ) == 0 )
	{
		return;
	}

	$insert_values = '';
	$update_cond = 'WHERE (';

	$count_data_to_deal_with = count( $data_to_deal_with );

	foreach( $data_to_deal_with as $key => $value )
	{
		if( is_array( $value ) )
		{
			$count_data_to_deal_with--;
			foreach( $value as $k => $v )
			{
				if( strlen( $v ) === 0 )
				{
					continue;
				}
				$count_data_to_deal_with++;
				$update_cond .= ( $update_cond != 'WHERE (' ) ? ' OR ' : '';
				$update_cond .= "( typ = '". $key ."' AND ". $field ." = '". $v ."' )\n";
			}
		}
		else
		{
			if( strlen( $value ) === 0 )
			{
				$count_data_to_deal_with--;
				continue;
			}
			$update_cond .= ( $update_cond != 'WHERE (' ) ? ' OR ' : '';
			$update_cond .= "( typ = '". $key ."' AND ". $field ." = '". $value ."' )\n";
		}
	}
	$update_cond .= ' )';
	if( $month != FALSE )
	{
		if( $table == CHC_TABLE_USER_AGENTS )
		{
			$update_cond .= 'AND (monat = '. $month ." OR (typ = 'user_agent' AND monat = -1) )";
		}
		else
		{
			$update_cond .= " AND monat = ". $month;
		}
	}

	$query = $_CHC_DB->query(
		'SELECT typ, '. $field .'
		FROM `'. CHC_DATABASE .'`.`'. $table ."`
		". $update_cond .'
		LIMIT 0, '. $count_data_to_deal_with
	);

	if( $_CHC_DB->num_rows( $query ) < $count_data_to_deal_with )
	{
		$stored_data = array();
		while( $row = $_CHC_DB->fetch_assoc( $query ) )
		{
			$stored_data[$row['typ'] .'-'. $row[$field]] = 0;
		}
		foreach( $data_to_deal_with as $key => $value )
		{
			if( is_array( $value ) )
			{
				foreach( $value as $k => $v )
				{
					if( !isset( $stored_data[$key .'-'. $v] ) )
					{
						$insert_values = !empty( $insert_values ) ? $insert_values . ', ' : '';
						$insert_values .= "('". $key ."', '". $v ."'";
						if( $month != FALSE )
						{
							$insert_values .= ', '. $month;
						}
						$insert_values .= " )\n";
					}
				}
			}
			else
			{
				if( !isset( $stored_data[$key .'-'. $value] ) )
				{
					$insert_values = !empty( $insert_values ) ? $insert_values . ', ' : '';
					$insert_values .= "('". $key ."', '". $value ."'";
					if( $month != FALSE )
					{
						$insert_values .= ', '. $month;
					}
					$insert_values .= " )\n";
				}
			}
		}
	}

	return array(
		'insert_values' => !empty( $insert_values ) ? $insert_values : FALSE,
		'update_cond' => $update_cond
	);
}



function chC_page_purge_query_string( $seite, $modus, $variablen = '' )
{
	$parse_url = @parse_url( $seite );
	if( !isset( $parse_url['query'] ) )
	{
		return $seite;
	}

	if( $modus == 'keine' )
	{
		$neuer_query_string = '';
	}
	elseif( $modus == 'ohne' && !empty( $variablen ) )
	{
		/*
		$variablen = preg_replace( '/; ?$/', '', $variablen );
		$neuer_query_string = preg_replace(
			'/(.?)('. str_replace( '; ', '|', $variablen ) .')(=[^&]*)?([^&]*)&?/ei',
			'( (  "$1" == \'&\' || "$1" == \'\' ) && "$4" == \'\' ) ? "$1" : "$0"',
			$parse_url['query']
		);
		$neuer_query_string = preg_replace( '/&$/', '', $neuer_query_string );
		*/
		if( empty( $variablen ) )
		{
			$neuer_query_string = $parse_url['query'];
		}
		else
		{
			parse_str( $parse_url['query'], $query_string_variablen );

			$variablen = strtolower( preg_replace( '/; ?$/', '', $variablen ) );
			$verbotene_variablen = explode( '; ', $variablen );

			$neuer_query_string = '';
			foreach( $query_string_variablen as $var_name => $var_value )
			{
				if( !in_array( strtolower( $var_name ), $verbotene_variablen ) )
				{
					$neuer_query_string .= empty( $neuer_query_string )
						? $var_name
						: '&'. $var_name;
					$neuer_query_string .= !empty( $var_value )
						? '='. $var_value
						: '';
				}
			}
		}
	}
	elseif( $modus == 'nur' )
	{
		if( empty( $variablen ) )
		{
			$neuer_query_string = '';
		}
		else
		{
			parse_str( $parse_url['query'], $query_string_variablen );

			$variablen = strtolower( preg_replace( '/; ?$/', '', $variablen ) );
			$erlaubte_variablen = explode( '; ', $variablen );

			$neuer_query_string = '';
			foreach( $query_string_variablen as $var_name => $var_value )
			{
				if( in_array( strtolower( $var_name ), $erlaubte_variablen ) )
				{
					$neuer_query_string .= empty( $neuer_query_string )
						? $var_name .'='. $var_value
						: '&'. $var_name .'='. $var_value;
				}
			}
		}
	}

	if( !isset( $neuer_query_string ) )
	{
		return $seite;
	}
	else
	{
		if( empty( $neuer_query_string ) )
		{
			return str_replace( '?'. $parse_url['query'], '', $seite );
		}
		else
		{
			return str_replace( $parse_url['query'], $neuer_query_string, $seite );
		}
	}
}



function chC_general_db_cleanup()
{
	global $_CHC_DB, $_CHC_CONFIG;

	// alte Online-User löschen...
	$_CHC_DB->query(
		'DELETE FROM `'. CHC_DATABASE .'`.`'. CHC_TABLE_ONLINE_USERS.'`
		WHERE timestamp_letzter_aufruf < '.( CHC_TIMESTAMP - $_CHC_CONFIG['user_online_fuer'] )
	);

	// alte Counted-User löschen...
	$_CHC_DB->query(
		'DELETE FROM `'. CHC_DATABASE .'`.`'. CHC_TABLE_COUNTED_USERS .'`
		WHERE timestamp '
		.( $_CHC_CONFIG['modus_zaehlsperre'] == 'intervall'
				? '< '. ( CHC_TIMESTAMP - $_CHC_CONFIG['blockzeit'] )
				:	' + '
					.( ( date( 'I' ) == '1' && $_CHC_CONFIG['dst'] == '0' )
						? date( 'Z') - 3600
						: date( 'Z' )
					)
					.' < '. chC_get_timestamp( 'tag' )
		)
	);

	$_CHC_DB->query(
		'DELETE FROM `'. CHC_DATABASE .'`.`'. CHC_TABLE_IGNORED_USERS .'`
		WHERE timestamp '
		.( $_CHC_CONFIG['modus_zaehlsperre'] == 'intervall'
				? '< '. ( CHC_TIMESTAMP - $_CHC_CONFIG['blockzeit'] )
				:	' + '
					.( ( date( 'I' ) == '1' && $_CHC_CONFIG['dst'] == '0' )
						? date( 'Z') - 3600
						: date( 'Z' )
					)
					.' < '. chC_get_timestamp( 'tag' )
		)
	);

	// alte Logdaten löschen...
	if( $_CHC_CONFIG['log_eintraege_loeschen_nach:wert_in_sek'] != '0' )
	{
		$_CHC_DB->query(
			'DELETE FROM `'.CHC_DATABASE .'`.`'. CHC_TABLE_LOG_DATA.'`
			WHERE timestamp < '. ( CHC_TIMESTAMP - $_CHC_CONFIG['log_eintraege_loeschen_nach:wert_in_sek'] )
		);
	}





	if(
		$_CHC_CONFIG['regelmaessiges_loeschen:user_agents:aktiviert'] == '1'
		|| $_CHC_CONFIG['regelmaessiges_loeschen:referrer:aktiviert'] == '1'
		|| $_CHC_CONFIG['regelmaessiges_loeschen:verweisende_domains:aktiviert'] == '1'
	  )
	{
		// regelmäßiges Löschen von User-Agents/Referrern/Verweisenden Domains...
		$loesch_typen_array = array(
			array(
				'typ' => 'user_agent',
				'loesch_werte' => $_CHC_CONFIG['regelmaessiges_loeschen:user_agents:werte'],
				'tabelle' => CHC_TABLE_USER_AGENTS,
				'aktiviert' => $_CHC_CONFIG['regelmaessiges_loeschen:user_agents:aktiviert'] == '1' ? 1 : 0
			),
			array(
				'typ' => 'referrer',
				'loesch_werte' => $_CHC_CONFIG['regelmaessiges_loeschen:referrer:werte'],
				'tabelle' => CHC_TABLE_REFERRERS,
				'aktiviert' => $_CHC_CONFIG['regelmaessiges_loeschen:referrer:aktiviert'] == '1' ? 1 : 0
			),
			array(
				'typ' => 'domain',
				'loesch_werte' => $_CHC_CONFIG['regelmaessiges_loeschen:verweisende_domains:werte'],
				'tabelle' => CHC_TABLE_REFERRERS,
				'aktiviert' => $_CHC_CONFIG['regelmaessiges_loeschen:verweisende_domains:aktiviert'] == '1' ? 1 : 0
			)
		);
		foreach( $loesch_typen_array as $loesch_typ )
		{
			if( $loesch_typ['aktiviert'] == 1 )
			{
				$array = explode( ';', $loesch_typ['loesch_werte'] );

				$result = $_CHC_DB->query(
					'SELECT SUM(anzahl) as anzahl, MAX(timestamp) as timestamp
					FROM `'.CHC_DATABASE .'`.`'. $loesch_typ['tabelle'] ."`
					WHERE
						typ = '". $loesch_typ['typ'] ."'
						AND wert != '__chC:more__'
						AND anzahl <= ". $array[0] .'
						AND timestamp <= '. ( CHC_TIMESTAMP - $array[1] )
				);

				$row = $_CHC_DB->fetch_assoc( $result );

				if( $row['anzahl'] > 0 )
				{
					$result = $_CHC_DB->query(
						'UPDATE `'.CHC_DATABASE .'`.`'. $loesch_typ['tabelle'] .'`
						SET
							anzahl = anzahl + '. $row['anzahl'] .',
							timestamp = IF( timestamp > '. $row['timestamp'] .', timestamp, '. $row['timestamp'] .")
						WHERE
							typ = '". $loesch_typ['typ'] ."'
							AND wert != '__chC:more__'
							AND anzahl <= ". $array[0] .'
							AND timestamp <= '. ( CHC_TIMESTAMP - $array[1] )
					);
					if( $_CHC_DB->affected_rows() == 0 )
					{
						$_CHC_DB->query(
							'INSERT INTO `'.CHC_DATABASE .'`.`'. $loesch_typ['tabelle'] ."`
							( typ, wert, anzahl, timestamp )
							VALUES
							( '". $loesch_typ['typ'] ."', '__chC:more__', ". $row['anzahl'].' , '. $row['timestamp'] .' );'
						);
					}

					$_CHC_DB->query(
						'DELETE FROM `'.CHC_DATABASE .'`.`'. $loesch_typ['tabelle'] ."`
						WHERE
							typ = '". $loesch_typ['typ'] ."'
							AND wert != '__chC:more__'
							AND anzahl <= ". $array[0] .'
							AND timestamp <= '. ( CHC_TIMESTAMP - $array[1] )
					);
				}
			}
		}
	}


	// Tabellen optimieren
	$_CHC_DB->query(
		'OPTIMIZE TABLE
		`'. CHC_DATABASE .'`.`'. CHC_TABLE_LOG_DATA.'`,
		`'. CHC_DATABASE .'`.`'. CHC_TABLE_ONLINE_USERS.'`,
		`'. CHC_DATABASE .'`.`'. CHC_TABLE_COUNTED_USERS.'`,
		`'. CHC_DATABASE .'`.`'. CHC_TABLE_IGNORED_USERS.'`'
		. ( $_CHC_CONFIG['regelmaessiges_loeschen:user_agents:aktiviert'] == '1' ? ",\n`". CHC_DATABASE .'`.`'. CHC_TABLE_USER_AGENTS .'`' : '' )
		. ( ( $_CHC_CONFIG['regelmaessiges_loeschen:referrer:aktiviert'] == '1'
		   || $_CHC_CONFIG['regelmaessiges_loeschen:verweisende_domains:aktiviert'] == '1' )
			? ",\n`". CHC_DATABASE .'`.`'. CHC_TABLE_REFERRERS .'`'
			: ''
		  )
	);
}



function chC_str_prepare_for_output( $string, $width = 0, $html_breaks = TRUE, $remove_doubled_entities = FALSE )
{
	if( $width > 0 )
	{
		$string = wordwrap( $string, $width, "\n", 1 );
	}

	$string = htmlentities( $string, ENT_COMPAT, 'UTF-8' ); #print $string."<br>";
	if( $remove_doubled_entities == TRUE )
	{
		$string = preg_replace( '/&amp;([a-zA-Z]+;)/', '&\\1', $string );
	}

	return ( $html_breaks == TRUE )
		? nl2br( $string )
		: $string;
}



function chC_utf8_substr( $string, $start, $length = FALSE )
{
	$string = utf8_decode( $string );
	if( $length == FALSE )
	{
		$string = substr( $string, $start );
	}
	else
	{
		$string = substr( $string, $start, $length );
	}
	return utf8_encode( $string );
}



function chC_convert_encoding( $string, $to_encoding, $from_encoding )
{
	if( extension_loaded( 'mbstring' ) )
	{
		$converted_string = @mb_convert_encoding( $string, $to_encoding, $from_encoding );
	}
	elseif( extension_loaded( 'iconv' ) )
	{
		if( !function_exists( 'iconv' ) && function_exists( 'libiconv' ) )
		{
			$converted_string = @libiconv($input_encoding, $output_encoding, $string);
		}
		else
		{
			$converted_string = @iconv( $from_encoding, $to_encoding, $string );
		}
	}
	elseif( extension_loaded( 'recode' ) )
	{
		$converted_string = @recode_string( $from_encoding. '..'. $to_encoding, $string );
	}
	elseif( $to_encoding = 'UTF-8' && preg_match( '/(ISO-8859-1|Latin1)/i', $from_encoding ) )
	{
		$converted_string = utf8_encode( $string );
	}

	if( isset( $converted_string ) && is_string( $converted_string ) && !empty( $converted_string ) )
	{
		return $converted_string;
	}
	else
	{
		return $string;
	}
}



function chC_format_keywords( $string )
{
	if( extension_loaded( 'mbstring' ) )
	{
		$detected_encoding = mb_detect_encoding( $string, 'UTF-8,ISO-8859-1,ASCII,JIS,EUC-JP,SJIS' );
		$detected_encoding = $detected_encoding == TRUE ? $detected_encoding : 'UTF-8';
		$lowered_string = mb_strtolower( $string, $detected_encoding );
		if( $detected_encoding == TRUE && strtolower( $detected_encoding ) != 'utf-8' )
		{
			$lowered_string = mb_convert_encoding( $lowered_string, 'UTF-8', $detected_encoding );
		}
	}
	else
	{
		$lowered_string = utf8_encode( strtolower( utf8_decode( $string ) ) );
	}
	return ( $lowered_string == TRUE ) ? $lowered_string : $string;
}



function chC_get_ids_and_urls( $type = 'homepages' )
{
	global $_CHC_CONFIG;

	if( $type == 'counter' )
	{
		$urls = str_replace( 'default_counter_url', $_CHC_CONFIG['default_counter_url'], $_CHC_CONFIG['counter_urls'] );
	}
	else
	{
		$urls = str_replace( 'default_homepage_url', $_CHC_CONFIG['default_homepage_url'], $_CHC_CONFIG['homepages_urls'] );
	}

	if( $number = preg_match_all( '/(\d+) => ([^ ;]+); /', $urls, $matches ) )
	{
		$array = array();
		for( $i = 0; $i < $number; $i++ )
		{
			$array[$matches[1][$i]] = $matches[2][$i];
		}
		return $array;
	}
	else
	{
		die( 'chCounter error: setting `'. $type .'_urls` is empty or it\'s syntax is wrong.' );
	}
}


function chC_get_url( $type, $id )
{
	global $_CHC_CONFIG;
	static $liste_counter, $liste_homepage;

	if( !isset( ${'liste_'. $type} ) )
	{
		${'liste_'. $type} = ( $type == 'counter'  )
			? chC_get_ids_and_urls( 'counter' )
			: chC_get_ids_and_urls( 'homepages' );
	}

	if( !isset( ${'liste_'. $type}[$id] ) )
	{
		$url = ( $type == 'counter'  )
			? $_CHC_CONFIG['default_counter_url']
			: $_CHC_CONFIG['default_homepage_url'];
	}
	else
	{
		$url = ${'liste_'. $type}[$id];
	}


	if( $type == 'counter' )
	{
		$homepage_url = chC_get_url( 'homepage', $id );
		$counter_url = preg_replace( '/http(s?):\/\/(www\.)?/', '', $url );
		$tmp_homepage_url = preg_replace( '/http(s?):\/\/(www\.)?/', '', $homepage_url );
		if( !preg_match( '/^'. preg_quote( $tmp_homepage_url, '/' ) .'(\/.*)?$/', $counter_url ) )
		{
			$parse_url = parse_url( $url );
			return $parse_url['scheme'] . '://'. $parse_url['host'];
		}
		else
		{
			return $homepage_url;
		}
	}

	return $url;
}


function chC_evaluate( $type, &$id, &$url )
{
	global $_CHC_CONFIG;

	$urls = ( $type == 'counter' )
		? $_CHC_CONFIG['counter_urls']
		: $_CHC_CONFIG['homepages_urls'];

	$SERVER_NAME = preg_replace( '/http(s?):\/\/(www\.)?/', '', $_SERVER['SERVER_NAME'] );
	if( preg_match( '/(\d+) => (http(s?):\/\/(www\.)?'. preg_quote( $SERVER_NAME, '/' ) .'.{0,}); /', $urls, $match ) )
	{
		$id = $match[1];
		$url = $match[2];
	}
	else
	{
		$id = 1;
		$url = ( $type == 'counter' )
			? $_CHC_CONFIG['default_counter_url']
			: $_CHC_CONFIG['default_homepage_url'];
	}
}



function chC_page_in_counter_directory( $seite, $id = 1 )
{
	global $_CHC_CONFIG;

	if( isset( $_CHC_CONFIG['aktuelle_counter_url'] ) )
	{
		$counter_url = $_CHC_CONFIG['aktuelle_counter_url'];
	}
	else
	{
		if( $id != 1 )
		{
			$counter_url = chC_get_url( 'counter', $id );
		}
		else
		{
			$counter_url = $_CHC_CONFIG['default_counter_url'];
		}
	}

	$counter_url = preg_replace( '/http(s?):\/\/(www\.)?/', '', $counter_url );
	$SERVER_NAME = preg_replace( '/www\./', '', $_SERVER['SERVER_NAME'] );

	if( preg_match( '/^'. preg_quote( $counter_url, '/' ) .'/', $SERVER_NAME . $seite ) )
	{
		return TRUE;
	}
	return FALSE;
}




function chC_analyse_user_agent( $useragent )
{
	global $chC_ualib_browsers, $chC_ualib_os, $chC_ualib_robots;

	$chC_ualib_browser =& $chC_ualib_browsers;
	$chC_ualib_robot =& $chC_ualib_robots;
	$libs = array( 'browser', 'os', 'robot' );

	foreach( $libs as $libname )
	{
		// Wenn Browser und OS schon durchgelaufen und Browser erfolgreich ermittelt,
		// ist es kein Robot, und das Durchsuchen der Arrays kann beendet werden
		if(
			( isset( $browser ) && isset( $os ) )
			&&
			$browser != 'unknown'
		  )
		{
			break;
		}

		// jeweiliges Library-Array durchlaufen
		foreach( ${'chC_ualib_'.$libname} as $name => $array )
		{
			if( $array['use_PCRE'] == 1 )
			{
				if( preg_match( $array['pattern'], $useragent, $match ) )
				{
					if( !empty ( $array['anti_pattern'] ) && preg_match( $array['anti_pattern'], $useragent ) )
					{
						continue;
					}
					${$libname} = $name;
				}
			}
			else
			{
				if( is_int( strpos( $useragent, $array['pattern'] ) ) )
				{
					if( !empty( $array['anti_pattern'] ) && is_int( strpos ( $useragent, $array['anti_pattern'] ) ) )
					{
						continue;
					}
					${$libname} = $name;
				}
			}

			// Wenn kein Treffer, Loop fortsetzen -> weitersuchen:
			if( !isset( ${$libname} ) )
			{
			 	continue;
			}

			// Ansonsten: Treffer

			// Icon
			${$libname.'_icon'} = $array['icon'];

			// nach Version suchen?
			if( $array['use_PCRE'] == 1 && ${'chC_ualib_'.$libname}[${$libname}]['version'] != false ) // mit preg_match bereits Version ermittelt
			{
				if( !empty( $match[ (int) ${'chC_ualib_'.$libname}[${$libname}]['version'] ] ) )
				{
					${$libname.'_version'} = $match[ (int) ${'chC_ualib_'.$libname}[${$libname}]['version'] ];
				}
				else
				{
					${$libname.'_version'} = 'unknown';
				}
			}
			elseif( is_array ( ${'chC_ualib_'.$libname}[${$libname}]['version'] ) )
			{
				foreach( ${'chC_ualib_'.$libname}[${$libname}]['version'] as $pattern => $version )
				{
					if( is_int( strpos( $useragent, (string) $pattern ) ) )
					{
						${$libname.'_version'} = $version;
						break;
					}
				}
				if( !isset( ${$libname.'_version'} ) )
				{
					${$libname.'_version'} = 'unknown';
				}
			}

                        // mit dem nächsten lib-Typ weiter
			continue 2;
		}
	}

	if( isset( $robot ) )
	{
		unset( $browser );
	}

	return array(
		'browser'		=> isset( $browser ) ? $browser : FALSE,
		'browser_version'	=> isset($browser_version) ? $browser_version : FALSE,
		'browser_icon'		=>  isset( $browser ) ? $browser_icon : FALSE,
		'os'			=> $os,
		'os_version'		=> isset($os_version) ? $os_version : FALSE,
		'os_icon'		=> $os_icon,
		'robot'			=> isset( $robot ) ? $robot : FALSE,
		'robot_version'		=> isset( $robot_version ) ? $robot_version : FALSE,
		'robot_icon'		=> isset( $robot_icon ) ? $robot_icon : FALSE
	);

}


function chC_is_robot( $user_agent )
{
	global $chC_ualib_robots;
	static $identified_robots = array();

	if( $robot = array_search( $user_agent, $identified_robots ) )
	{
		return $robot;
	}

	foreach( $chC_ualib_robots as $name => $array )
	{
		if( $array['use_PCRE'] == 1 )
		{
			if( preg_match( $array['pattern'], $user_agent) )
			{
				if( ! ( !empty( $array['anti_pattern'] ) && preg_match( $array['anti_pattern'], $user_agent ) ) )
				{
					$identified_robots[$name] = $user_agent;
					return $name;
				}
			};
		}
		else
		{
			if( is_int( strpos( $user_agent, $array['pattern'] ) ) )
			{
				if( ! ( !empty ( $array['anti_pattern'] ) && is_int( strpos( $user_agent, $array['anti_pattern'] ) ) ) )
				{
					$identified_robots[$name] = $user_agent;
					return $name;
				}
			}
		}
	}
	return FALSE;
}


function chC_http_accept_language_get_preferred( $HTTP_ACCEPT_LANGUAGE )
{
	$HTTP_ACCEPT_LANGUAGE = trim( $HTTP_ACCEPT_LANGUAGE );
	if( !empty( $HTTP_ACCEPT_LANGUAGE ) )
	{
		$array = explode( ',', $HTTP_ACCEPT_LANGUAGE ); # einzelne (Sprache & Land-)Nennungen trennen
		$array = explode( ';', $array[0] ); // $chC_locale[0]: erste Nennung = höchste Priorität. Durch ';' werden Sprache/Land und die optionale Angabe zur Wichtigkeit getrennt
		$accept_lang = strtolower( $array[0] );
		if( strlen( $accept_lang ) == 5 ) # Bsp.: de_DE
		{
			$array = explode( '-', $accept_lang );
			if( count( $array ) == 2 )
			{
				return array(
					'language' => $array[0],
					'country' => $array[1]
				);
			}
		}
		elseif( strlen( $accept_lang ) == 2 ) # Bsp: de
		{
			return array(
				'language' => $accept_lang
			);
		}
	}
	return FALSE;
}


function chC_get_available_languages( $lang_dir )
{
	$languages = array();
	$dir_handle = opendir( $lang_dir );
	while( $value = readdir( $dir_handle ) )
	{
		if(
			$value != '.'
			&& $value != '..'
			&& is_dir( $lang_dir.'/'.$value )
			&& is_file( $lang_dir.'/'.$value.'/lang_name.txt' )
		  )
		{
			if( $name = @implode( '', @file( $lang_dir.'/'.$value.'/lang_name.txt' ) ) )
			{
				$languages[$value] = chC_convert_encoding( $name, 'UTF-8', 'ISO-8859-1' );
			}
		}
	}
	closedir( $dir_handle );

	if( !function_exists( 'chC_langcmp' ) )
	{
		function chC_langcmp( $a, $b )
		{
			return strcasecmp( $a, $b );
		}
	}
	uasort( $languages, 'chC_langcmp' );

	return $languages;
}



function chC_get_language_to_use( $available_languages )
{
	global $_CHC_CONFIG;

	if( isset( $_GET['lang'] ) && isset( $available_languages[$_GET['lang']] )  )
	{
		$lang = $_GET['lang'];
	}
	elseif( isset( $_SESSION['CHC_LANG'] ) && isset( $available_languages[$_SESSION['CHC_LANG']] ) )
	{
		$lang = $_SESSION['CHC_LANG'];
	}
	else
	{
		if( isset( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ))
		{
			$different_languages = explode( ',', $_SERVER['HTTP_ACCEPT_LANGUAGE'] );
			$http_accept_languages = array();
			foreach( $different_languages as $value )
			{
				$tmp = explode( ';', $value );
				$http_accept_languages[] = substr( $tmp[0], 0, 2 );
			}
			foreach( $http_accept_languages as $current_language )
			{
				if( isset( $available_languages[$current_language] ) )
				{
					$lang = $current_language;
					break;
				}
			}
		}
		if( !isset( $lang ) )
		{
			$lang = isset( $_CHC_CONFIG['lang'] ) ? $_CHC_CONFIG['lang'] : 'de';
		}
	}

	$_SESSION['CHC_LANG'] = $lang;
	return $lang;
}



function chC_send_select_list_to_tpl( $select_name, $liste, $selected )
{
	global $_CHC_TPL;

	$done_select = FALSE;
	foreach( $liste as $value => $name )
	{
		$block_array = array(
			'VALUE'		=> $value,
			'NAME'		=> $name
		);
		if( $value == $selected && $done_select == FALSE )
		{
			$block_array['SELECTED'] = TRUE;
			$done_select = TRUE;
		}
		$_CHC_TPL->add_block( $select_name, $block_array );
	}
}


function chC_get_config()
{
	global $_CHC_DB;
	static $config;

	if( $config == TRUE )
	{
		return $config;
	}

	$result = $_CHC_DB->query(
		'SELECT setting, value
		FROM `'. CHC_DATABASE .'`.`'. CHC_TABLE_CONFIG .'`'
	);

	$config = array();
	while( $row = $_CHC_DB->fetch_assoc( $result ) )
	{
		$config[$row['setting']] = $row['value'];
	}

	return $config;
}


function chC_set_config( $var, $value = FALSE )
{
	global $_CHC_DB, $_CHC_CONFIG;

	if( is_array( $var ) && $value == FALSE )
	{
		foreach( $var as $name => $value )
		{
			$_CHC_DB->query(
				'UPDATE `'. CHC_DATABASE .'`.`'. CHC_TABLE_CONFIG ."`
				SET value = '". $_CHC_DB->escape_string( $value ) ."'
				WHERE setting = '". $_CHC_DB->escape_string( $name ) ."'"
			);
			$_CHC_CONFIG[$name] = $value;
		}
	}
	else
	{
		$_CHC_DB->query(
			'UPDATE `'. CHC_DATABASE .'`.`'. CHC_TABLE_CONFIG ."`
			SET value = '". $_CHC_DB->escape_string( $value ) ."'
			WHERE setting = '". $_CHC_DB->escape_string( $var ) ."'"
		);
		$_CHC_CONFIG[$var] = $value;
	}
}


function chC_list_match( $list, $value )
{
	$list = str_replace(
		array( '; ', '%' ),
		array( '|', '.*'),
		preg_quote( $list, '/' )
	);
	return preg_match( '/^('. $list .')$/i', $value );
}


function chC_convert_hideout_list_to_condition( $hideout_list )
{
	global $_CHC_DB;

	if( trim( $hideout_list ) == '' )
	{
		return '';
	}

	$hideout_list = preg_replace( '/; ?$/', '', $hideout_list );

	$hideout_list = $_CHC_DB->escape_string( $hideout_list );
	return "( wert NOT LIKE '"
		.str_replace(
			'; ',
			"' AND WERT NOT LIKE '",
			$hideout_list
		)
		."' )";
}


function chC_login( $name, $pw, $cookie = 0, $admin_required = FALSE )
{
	global $_CHC_DB;

	$result = $_CHC_DB->query(
		"SELECT setting
		FROM `".CHC_DATABASE .'`.`'. CHC_TABLE_CONFIG."`
		WHERE
			(
				( setting = 'admin_name' AND value = '".$name."' )
				OR ( setting = 'admin_passwort' AND value = '".$pw."' )
			)
			OR
			(
				( setting = 'gast_name' AND value = '".$name."' )
				OR ( setting = 'gast_passwort' AND value = '".$pw."' )
			)"
	);
	if( $_CHC_DB->num_rows( $result ) == 2 )
	{
		$row = $_CHC_DB->fetch_assoc( $result );
		$typ = is_int( strpos( $row['setting'], 'admin' ) ) ? 'admin' : 'guest';

		if( $admin_required == TRUE && $typ == 'guest' )
		{
			return -1;
		}

		$_SESSION['CHC_LOGGED_IN'] = $typ;
		if( $cookie == 1 )
		{
			setcookie( 'CHC_LOGIN', $name.'~'.$pw, time() + 25920000, '/' );
		}
		return $_SESSION['CHC_LOGGED_IN'];
	}
	return -1;
}


function chC_manage_login( $admin_required = FALSE )
{
	if( !isset( $_SESSION['CHC_LOGGED_IN'] ) )
	{
		$login = 0;
		if( isset( $_POST['login_form'] ) ) // Login per Form
		{
			$_POST['login_cookie'] = ( isset( $_POST['login_cookie'] ) ) ? 1 : 0;
			if( !empty( $_POST['login_name'] ) )
			{
				$login = chC_login( $_POST['login_name'], md5( $_POST['login_pw'] ), $_POST['login_cookie'], $admin_required );
			}
			else
			{
				$login = -1;
			}
		}
		elseif( isset( $_GET['user'] ) && isset( $_GET['pw'] ) ) // Login per URL
		{
			if( !empty( $_GET['user'] ) )
			{
				$login = chC_login( $_GET['user'], md5( $_GET['pw'] ), isset( $_GET['cookie'] ) ? 1 : 0, $admin_required );
			}
			else
			{
				$login = -1;
			}
		}
		elseif( isset( $_COOKIE['CHC_LOGIN'] ) )	// automatisches Cookie-Login
		{
			$name = substr(
				$_COOKIE['CHC_LOGIN'],
				0,
				strrpos( $_COOKIE['CHC_LOGIN'], '~' )
			);
			if( !empty( $name ) )
			{
				$pw = str_replace( $name .'~', '', $_COOKIE['CHC_LOGIN'] );
				$login = chC_login( $name, $pw, 1, $admin_required );
			}
			else
			{
				$login = -1;
			}
		}
		if( $login != 0 )
		{
			$login = ( $login === FALSE ) ? -1 : $login;
		}
	}
	return isset( $login ) ? $login : 2; // 0: kein einloggversuch. -1: einloggen fehlerhaft; 'admin'|'guest': einloggen erfolgreich; 2: bereits eingeloggt;
}


function chC_logged_in()
{
	return ( isset( $_SESSION['CHC_LOGGED_IN'] ) && $_SESSION['CHC_LOGGED_IN'] == TRUE ) ? $_SESSION['CHC_LOGGED_IN'] : FALSE;
}


function chC_logout()
{
	unset( $_SESSION['CHC_LOGGED_IN'] );
	if( isset( $_COOKIE['CHC_LOGIN'] ) )
	{
		setcookie( 'CHC_LOGIN', '', time() - 1, '/' );
	}
}


function chC_get_login_form( $failed_login )
{
	global $_CHC_LANG;

	$tpl = @implode( '', @file( CHC_ROOT .'/templates/stats/login_form.tpl.html' ) );
	if( $tpl == FALSE )
	{
		return FALSE;
	}

	$search = array(
		'{L_YOUR_LOGIN_NAME}',
		'{L_YOUR_PASSWORD}',
		'{L_SET_LOGIN_COOKIE}',
		'{L_LOGIN}',
		'{V_LOGIN_MESSAGE}',
		'{V_LOGIN_ERROR_MESSAGE}',
		'{V_LOGIN_NAME}',
		'{V_CHECKED}',
	);
	$replace = array(
		$_CHC_LANG['your_user_name:'],
		$_CHC_LANG['your_password:'],
		$_CHC_LANG['set_login_cookie'],
		$_CHC_LANG['login_now'],
		$_CHC_LANG['login_required'],
		$failed_login == 1 ? $_CHC_LANG['login_invalid_input'] : '',
		isset( $_POST['login_name'] ) ? $_POST['login_name'] : '',
		isset( $_POST['login_cookie'] ) && $_POST['login_cookie'] == '1' ? 'checked' : ''
	);

	return str_replace( $search, $replace, $tpl );
}


function chC_get_login_page( $title = '', $failed_login, $counter_output = '' )
{
	global $_CHC_TPL, $_CHC_LANG, $_CHC_CONFIG;

	$_CHC_TPL-> free();
	$_CHC_TPL->load_file( CHC_ROOT.'/templates/stats/login_page.tpl.html' );

	$available_languages = chC_get_available_languages( CHC_ROOT .'/languages' );
	$lang = chC_get_language_to_use( $available_languages );
	chC_send_select_list_to_tpl( 'COUNTER_LANGUAGES', $available_languages, $lang );

	$_CHC_TPL->assign( array(
			'COUNTER' => $counter_output,
			'V_PAGE_TITLE' => $title,
			'V_SCRIPT_VERSION' => $_CHC_CONFIG['script_version'],
			'LOGIN_FORM' => chC_get_login_form( $failed_login ),
			'L_OK'	=> $_CHC_LANG['OK'],
			'L_LANGUAGE' => $_CHC_LANG['Language'],
			'L_CLOSE_WINDOW' => $_CHC_LANG['close_window']
		)
	);

	return $_CHC_TPL->get_tpl_as_var();
}




function chC_valid_ip( $string )
{
    $array = explode( '.', $string );
    $count = count( $array );

    if ( $count != 4 )
    {
		return FALSE;
	}

    for ( $i = 0; $i < $count; $i++ )
    {
		if(
			!preg_match( '/^[0-9]{1,3}$/', $array[$i] )
			|| $array[$i] > 255
		  )
		{
			return FALSE;
		}
    }

	// http://www.faqs.org/rfcs/rfc1918.html: 3. Private Address Space
	if(
		( $array[0] == 10 ) ||
		( $array[0] == 127 ) ||
		( $array[0] == 172 && $array[1] >= 16 && $array[1] <= 31 ) ||
		( $array[0] == 192 && $array[1] === 0 && $array[2] == 2 ) ||
		( $array[0] == 192 && $array[1] == 168 )
	  )
	{
		return FALSE;
	}

	return TRUE;
}



function chC_get_ip()
{
	foreach( array( 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REMOTECLIENT_IP' ) as $var_name )
	{
		if( isset( $_SERVER[$var_name] ) && !empty( $_SERVER[$var_name] ) )
		{
			if( is_int( strpos( $_SERVER[$var_name], ', ' ) ) )
			{
				$array = explode( ', ', $_SERVER[$var_name] );
				foreach( $array as $value )
				{
					if( chC_valid_ip( trim( $value ) ) == TRUE )
					{
						return trim( $value );
					}
				}
			}
			elseif( chC_valid_ip( $_SERVER[$var_name] ) == TRUE )
			{
				return $_SERVER[$var_name];
			}
		}
	}
	return $_SERVER['REMOTE_ADDR'];
}



function chC_stats_create_list_of_available_months( $table, $condition = '' )
{
	global $_CHC_DB, $_CHC_LANG, $liste_monate, $aktueller_monat;

	$sql = 'SELECT DISTINCT monat
		FROM `'. $table .'`
		WHERE monat > 0 ';
	if( !empty( $condition ) )
	{
		$sql .= ' AND ( '. $condition .' ) ';
	}
	$sql .= 'ORDER BY monat DESC;';

	$result = $_CHC_DB->query( $sql );

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

	return $liste;
}


function chC_stats_select_entries( $table, $condition, $limit, $month, $order_by = 'anzahl', $sort_mode = 'DESC', $additional_fields = '' )
{
	global $_CHC_DB;

	if( $month == 'all_months' )
	{
		$sql = 'SELECT DISTINCT wert, SUM(anzahl) as anzahl, MAX( timestamp ) AS timestamp '. $additional_fields .'
			FROM `'. $table .'` ';
		if( !empty( $condition ) )
		{
			$sql .= 'WHERE '. $condition .' ';
		}
		$sql .= 'GROUP BY wert
			ORDER BY '. $order_by .' '. $sort_mode .'
			LIMIT 0, '. $limit;
	}
	else
	{
		$sql = 'SELECT  wert, anzahl, timestamp
			FROM `'. $table .'`
			WHERE monat = '. $month .' ';
		if( !empty( $condition ) )
		{
			$sql .= 'AND ( '. $condition .' ) ';
		}
		$sql .= 'ORDER by '. $order_by .' '. $sort_mode .'
			LIMIT 0, '. $limit;
	}

	return $_CHC_DB->query( $sql );
}


function chC_stats_select_sum_count_max( $table, $condition, $month )
{
	global $_CHC_DB;

	if( $month == 'all_months' )
	{
		$sql = 'SELECT
				SUM(anzahl) as sum,
				COUNT(DISTINCT wert) as count,
				MAX(anzahl) as max
			FROM `'. $table .'` ';
		if( !empty( $condition ) )
		{
			$sql .= 'WHERE '. $condition .' ';
		}
		// $sql .= 'GROUP BY wert;';
	}
	else
	{
		$sql = 'SELECT
				SUM(anzahl) as sum,
				COUNT( anzahl ) as count,
				MAX(anzahl) as max
			FROM `'. $table .'`
			WHERE monat = '. $month .' ';
		if( !empty( $condition ) )
		{
			$sql .= 'AND ( '. $condition .' ) ';
		}
	}

	return $_CHC_DB->query( $sql );
}



function chC_user_agents_get_available_versions( $type = 'all' )
{
 	global $_CHC_DB;

        $sql = 'SELECT wert
		FROM `'. CHC_TABLE_USER_AGENTS .'`
		WHERE typ ';
	if( $type == 'browser' )
	{
	 	$sql .= "= 'version~browser'";
	}
	elseif( $type == 'operating_systems' )
	{
	 	$sql .= "= 'version~os'";
	}
	elseif( $type == 'robots' )
	{
	 	$sql .= "= 'version~robot'";
	}
	else
	{
		$sql.= "LIKE 'version~%'";
	};
	$sql .= " AND wert LIKE '%~versionen\_gesamt'";
	$result = $_CHC_DB->query( $sql );

	$vorhandene_versionen = '';
	while( $row = $_CHC_DB->fetch_assoc( $result ) )
	{
		$vorhandene_versionen .= $row['wert'];
	}
	return str_replace( '~versionen_gesamt', '; ', $vorhandene_versionen );
}


?>