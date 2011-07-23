<?php

/*
 **************************************
 *
 * additional.php
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


#ob_start();

error_reporting(E_ALL);
set_magic_quotes_runtime(0);

require( 'includes/config.inc.php' );
require( 'includes/common.inc.php' );
require( 'includes/functions.inc.php' );
require( 'includes/mysql.class.php' );

$_CHC_DB = &new chC_mysql( $_CHC_DBCONFIG['server'], $_CHC_DBCONFIG['user'], $_CHC_DBCONFIG['password'], $_CHC_DBCONFIG['database'] );

if( !isset( $_SERVER['HTTP_USER_AGENT'] ) )
{
	$_SERVER['HTTP_USER_AGENT'] = '';
}

$REMOTE_ADDR = chC_get_ip();

$aktueller_monat = chC_format_date( 'Ym', chC_get_timestamp( 'tag' ), FALSE );

# user momenten geblockt und noch nicht JS/Auflösung gespeichert?
$result = $_CHC_DB->query(
	'SELECT nr, js, aufloesung
	FROM `'. CHC_TABLE_COUNTED_USERS ."`
	WHERE
		(
			ip = '". $REMOTE_ADDR ."'
			OR ( ip LIKE '". substr( $REMOTE_ADDR, 0, strrpos( $REMOTE_ADDR, '.' ) ) ."%' AND user_agent = '". $_CHC_DB->escape_string( $_SERVER['HTTP_USER_AGENT'] ) ."')
		)
		AND
		(
			js = 0
			OR aufloesung = ''
		)
		AND is_robot = 0
	ORDER BY timestamp DESC
	LIMIT 0,1;"
);
if( $_CHC_DB->num_rows( $result ) == 1 )
{
	$row = $_CHC_DB->fetch_assoc( $result );

	$_CHC_CONFIG = chC_get_config();
	$update_log_data = '';
	$update_counted_users = '';

	if( $row['aufloesung'] == '' && $_CHC_CONFIG['status_aufloesungen'] == '1' )
	{
		if( isset( $_GET['res_width'] ) && isset( $_GET['res_height'] ) )
		{
			$aufloesung = $_GET['res_width'] . 'x' . $_GET['res_height'];

			if(
				preg_match( "/^\d+x\d+$/", $aufloesung )
				&& !(
					!empty( $_CHC_CONFIG['exclusion_list_screen_resolutions'] )
					&& chC_list_match( $_CHC_CONFIG['exclusion_list_screen_resolutions'], $aufloesung ) == TRUE
				)
			  )
			{
				$_CHC_DB->query(
					'UPDATE `'. CHC_TABLE_SCREEN_RESOLUTIONS .'`
					SET anzahl = anzahl+1, timestamp = '. CHC_TIMESTAMP ."
					WHERE
						wert = '". $_CHC_DB->escape_string( $aufloesung ) ."'
						AND monat = ". $aktueller_monat .';'
				);
				if( $_CHC_DB->affected_rows() == 0 )
				{
					$_CHC_DB->query(
						'INSERT INTO `'. CHC_TABLE_SCREEN_RESOLUTIONS ."`
						( wert, anzahl, timestamp, monat )
						VALUES ('". $_CHC_DB->escape_string( $aufloesung ) ."', 1, ". CHC_TIMESTAMP .', '. $aktueller_monat .' );'
					);
				}

				$update_log_data = "aufloesung = '". $_CHC_DB->escape_string( $aufloesung ) ."'";
				$update_counted_users = "aufloesung = '". $_CHC_DB->escape_string( $aufloesung ) ."'";
			}
		}
	}



	if( $row['js'] == '0' && $_CHC_CONFIG['status_js'] == '1' )
	{
		$_CHC_DB->query(
			'UPDATE `'. CHC_TABLE_DATA .'`
			SET js_aktiv = js_aktiv + 1;'
		);
		$update_log_data .= empty( $update_log_data ) ? 'js = 1' : ', js = 1';
		$update_counted_users .= empty( $update_counted_users ) ? 'js = 1' : ', js = 1';
	}


	if( !empty( $update_counted_users ) )
	{
		$_CHC_DB->query(
			'UPDATE `'. CHC_TABLE_COUNTED_USERS .'`
			SET '. $update_counted_users .'
			WHERE nr = '. $row['nr']
		);
	}

	if( !empty( $update_log_data) && $_CHC_CONFIG['status_logs'] == '1' )
	{
		$_CHC_DB->query(
			'UPDATE `'. CHC_TABLE_LOG_DATA .'`
			SET '. $update_log_data .'
			WHERE nr = '. $row['nr']
		);
	}

}

#ob_end_clean();

?>
