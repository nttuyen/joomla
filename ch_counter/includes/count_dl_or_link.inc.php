<?php

/*
 **************************************
 *
 * includes/count_dl_or_link.inc.php
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



if( !defined( 'CHC_DOWNLOAD_OR_HYPERLINK' ) )
{
	exit;
}


$_CHC_DB = &new chC_mysql( $_CHC_DBCONFIG['server'], $_CHC_DBCONFIG['user'], $_CHC_DBCONFIG['password'], $_CHC_DBCONFIG['database'] );
$_CHC_CONFIG = chC_get_config();


if( !isset( $_SERVER['HTTP_USER_AGENT'] ) )
{
	$_SERVER['HTTP_USER_AGENT'] = '';
}
$REMOTE_ADDR = chC_get_ip();

$aktueller_monat = chC_format_date( 'Ym', chC_get_timestamp( 'tag' ), FALSE );

$result = $_CHC_DB->query(
	'SELECT id, wert, url
	FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS .'`
	WHERE id = '. $ID ." AND typ = '". CHC_DOWNLOAD_OR_HYPERLINK ."'"
);

if( $_CHC_DB->num_rows( $result ) == 0 )
{
	exit;
}

$entry_data = $_CHC_DB->fetch_assoc( $result );




if( !isset( $_COOKIE['CHC_COUNT_PROTECTION'] ) )
{
	$_CHC_DB->query(
		'UPDATE `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS .'`
		SET anzahl = anzahl +1, timestamp = '. CHC_TIMESTAMP .'
		WHERE id = '. $entry_data['id']
	);
	$_CHC_DB->query(
		'UPDATE `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS .'`
		SET anzahl = anzahl +1, timestamp = '. CHC_TIMESTAMP .'
		WHERE id = '. $entry_data['id'] .' AND monat = '. $aktueller_monat .';'
	);
	if( $_CHC_DB->affected_rows() == 0 )
	{
		$_CHC_DB->query(
			'INSERT INTO `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS .'`
			( id, typ, timestamp, monat, anzahl )
			VALUES ( '. $entry_data['id'] .", '". CHC_DOWNLOAD_OR_HYPERLINK ."', ". time() .', '. $aktueller_monat .', 1 );'
		);
	}


	$result = $_CHC_DB->query(
		'SELECT nr
		FROM `'. CHC_TABLE_COUNTED_USERS ."`
		WHERE
			(
				( ip = '". $REMOTE_ADDR ."' )
				OR ( ip LIKE '". substr( $REMOTE_ADDR, 0, strrpos( $REMOTE_ADDR, '.' ) )."%' AND user_agent = '". $_CHC_DB->escape_string( $_SERVER['HTTP_USER_AGENT'] ) ."' )
			)
			AND timestamp ". ( $_CHC_CONFIG['modus_zaehlsperre'] == 'intervall'
				? '>= '. ( CHC_TIMESTAMP - $_CHC_CONFIG['blockzeit'] )
				: ' + '
				.( ( date( 'I' ) == '1' && $_CHC_CONFIG['dst'] == '0' )
					? date( 'Z') - 3600
					: date( 'Z' )
				)
				.' >= '. chC_get_timestamp( 'tag' )
			) .'
		LIMIT 0,1;'
	);
	if( $_CHC_DB->num_rows( $result ) == 1 )
	{
		$dbfeld = CHC_DOWNLOAD_OR_HYPERLINK == 'download' ? 'downloads' : 'hyperlinks';
		$row = $_CHC_DB->fetch_assoc( $result );
		$_CHC_DB->query(
			'UPDATE `'.CHC_DATABASE .'`.`'. CHC_TABLE_LOG_DATA .'`
			SET
				'. $dbfeld .' = CONCAT( '. $dbfeld .", '". $entry_data['id'] .','. CHC_TIMESTAMP .";' )
			WHERE nr =  ". $row['nr'] .'
			LIMIT 1;'
		);
	}
}


return $entry_data['url'];

?>
