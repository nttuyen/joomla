<?php

/*
 **************************************
 *
 * includes/download_details.class.php
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



class chC_dl_or_link_details extends chC_mysql
{
	var $config = array();
	var $template = '';
	var $date_format = 'Y-m-d';


	function get_details( $typ, $eintrag )
	{
		if( $typ != 'download' && $typ != 'hyperlink' )
		{
			return FALSE;
		}

		if( isset( $this->$typ[$eintrag] ) )
		{
			return $this->$typ[$eintrag];
		}

		if( is_int( $eintrag ) )
		{
			$result = parent::query(
				'SELECT id AS ID, typ as type, wert as `name`, url as URL, timestamp_eintrag AS timestamp_added, timestamp AS timestamp_last_request, anzahl AS quantity
				FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS .'`
				WHERE id = '. $eintrag ." AND typ = '". $typ ."';"
			);
		}
		else
		{
			$result = parent::query(
				'SELECT id AS ID, typ as type, wert as `name`, url as URL, timestamp_eintrag AS timestamp_added, timestamp AS timestamp_last_request, anzahl AS quantity
				FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."`
				WHERE name = '". parent::escape_string( $eintrag ) ."' AND typ = '". $typ ."'
				LIMIT 1;"
			);
		}
		if( parent::num_rows( $result ) == 0 )
		{
			return FALSE;
		}
		else
		{
			return parent::fetch_assoc( $result );
		}
	}


	function get_all( $typ, &$details_by_ID, &$details_by_name )
	{
		switch( $typ )
		{
			case 'hyperlinks':	$typ = 'hyperlink';
			default:		$typ = 'download';
		}

		$result = parent::query(
				'SELECT id AS ID, typ as type, wert as `name`, url as URL, timestamp_eintrag AS timestamp_added, timestamp AS timestamp_last_request, anzahl AS quantity
				FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."`
				WHERE typ = '". $typ ."';"
		);

		$details_by_ID = array();
		$details_by_name = array();

		while( $row = parent::fetch_assoc( $result ) )
		{
			$details_by_ID[$row['ID']] = $row;
			$details_by_name[$row['name']] = $row;
		}
	}


	function get_formated_details( $array, $template = '', $date_format = '' )
	{
		if( count( $this->config ) == 0 )
		{
			$result = parent::query(
				'SELECT setting, value
				FROM `'. CHC_DATABASE .'`.`'. CHC_TABLE_CONFIG .'`'
			);

			while( $row = parent::fetch_assoc( $result ) )
			{
				$this->config[$row['setting']] = $row['value'];
			}
		}

		if( empty( $template ) )
		{
			$template = $this->template;
		}

		if( empty( $date_format ) )
		{
			$date_format = $this->date_format;
		}

		foreach( $array as $key => $value )
		{
			if( $key == 'timestamp_added' || $key == 'timestamp_last_request' )
			{
				$value = chC_format_date( $date_format, $value, FALSE, $this->config['zeitzone'], $this->config['dst'] );
			}

			$template = str_replace( '{'. strtoupper( $key ) .'}', $value, $template );
		}

		return $template;
	}


	function set_template( $template )
	{
		$this->template = (string) $template;
	}

	function set_date_format( $template )
	{
		$this->date_format = (string) $template;
	}
}

?>
