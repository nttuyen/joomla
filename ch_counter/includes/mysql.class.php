<?php

/*
 **************************************
 *
 * includes/mysql.class.php
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



class chC_mysql
{
	var $query_result;
	var $statement;
	var $connection_id;
	var $queries = 0;
	var $accepted_errors = '';
	var $statements = array();
	var $debug = TRUE;
	var $die_on_error = TRUE;
	var $errors = array();
	var $repaired = array();


	function chC_mysql( $db_server, $db_user, $db_passwort, $db_database = FALSE, $debug = '', $force_new_connection = FALSE )
	{
		if( $debug == 'DEBUG_OFF' )
		{
			$this->debug = FALSE;
		}
		elseif( $debug == 'DEBUG_ON' )
		{
			$this->debug = TRUE;

		} 
		$this->connection_id = @mysql_connect( $db_server, $db_user, $db_passwort, $force_new_connection ) OR $this->_handle_error();
		if( $db_database != FALSE )
		{
			@mysql_select_db( $db_database ) OR $this->_handle_error();
		}
	}

	function _handle_error( $statement = FALSE )
	{
		$this->errors[] = array(
			'statement'	=> $statement,
			'errno'		=> mysql_errno(),
			'error'		=> mysql_error()
		);
		
		if( $this->debug == FALSE || ( mysql_errno() != 0 && is_int( strpos( $this->accepted_errors, (string) mysql_errno() ) ) ) )
		{
			return FALSE;
		}


		if( $this->debug == TRUE )
		{
			print "<b>chCounter: MySQL error!</b><br />\n";
			if( $statement != FALSE )
			{
				print "SQL query:<br />\n"
				."<ul style=\"margin-top:5px; margin-bottom:5px\">\n"
				."<li><i>".$statement."</i></li>\n"
				."</ul>\n<br />\n";
			}
			print "Error number: ".mysql_errno()."<br />\n".mysql_error()."\n";
			if( $this->die_on_error == TRUE )
			{
				die( "<br />\n<i>Script stopped.</i>" );
			}
		}
		elseif( $this->die_on_error == TRUE )
		{
			exit;
		}
	}
	
	function _repair_table( $statement )
	{
		$tabellen = array(
			strtolower( CHC_TABLE_CONFIG ),
			strtolower( CHC_TABLE_DATA ),
			strtolower( CHC_TABLE_LOG_DATA ),
			strtolower( CHC_TABLE_COUNTED_USERS ),
			strtolower( CHC_TABLE_IGNORED_USERS ),
			strtolower( CHC_TABLE_ONLINE_USERS ),
			strtolower( CHC_TABLE_ACCESS ),
			strtolower( CHC_TABLE_SCREEN_RESOLUTIONS ),
			strtolower( CHC_TABLE_USER_AGENTS ),
			strtolower( CHC_TABLE_SEARCH_ENGINES ),
			strtolower( CHC_TABLE_REFERRERS ),
			strtolower( CHC_TABLE_LOCALE_INFORMATION ),
			strtolower( CHC_TABLE_PAGES )
		);
		if( $count = preg_match_all( '/('. implode( '|', $tabellen ) .')/i', $statement, $matches ) )
		{
			$nr = 0;
			for( $i = 0; $i < $count; $i++ )
			{
				if( !isset( $this->repaired[$matches[1][$i]] ) )
				{
					$this->query( 'REPAIR TABLE `'. $matches[1][$i] .'`;' );
					$this->repaired[$matches[1][$i]] = TRUE;
					$nr++;
				}
			}
			if( $nr > 0 )
			{
				return TRUE;
			}
		}
		return FALSE;		
	}
	
	
	

	function set_debug_mode( $mode )
	{
		$this->debug = ( $mode == 'OFF' ) ? FALSE : TRUE;
	}

	function is_connected()
	{
		if( $this->connection_id == FALSE )
		{
			return FALSE;
		}
		else
		{
			return mysql_ping( $this->connection_id );
		}
	}

	function get_errors()
	{
		return $this->errors;
	}

	function reset_errors()
	{
		$this->errors = array();
	}

	function set_accepted_errors( $errors )
	{
		$this->accepted_errors = (string) $errors;
	}

	function escape_string( $string )
	{
		return mysql_escape_string( $string );
	}

	function query( $statement )
	{
		$this->query_result = @mysql_query( $statement, $this->connection_id );
		$this->queries++;
		if( mysql_errno() )
		{
			if( mysql_errno() == 1016 || mysql_errno() == 1030 )
			{
				$return = $this->_repair_table( $statement );
				if( $return == TRUE )
				{
					$this->query_result = @mysql_query( $statement, $this->connection_id );
				}
				else
				{
					$this->_handle_error( $statement );
				}
			}
			else
			{
				$this->_handle_error( $statement );
			}
		}
		$this->statements[] = $statement;
		return $this->query_result;
	}

	function fetch_array( $query_result = FALSE, $all = FALSE )
	{
		return $this->_fetch( 'array', $query_result, $all );
	}

	function fetch_assoc( $query_result = FALSE, $all = FALSE )
	{
		return $this->_fetch( 'assoc', $query_result, $all );
	}

	function fetch_row ( $query_result = FALSE, $all = FALSE )
	{
		return $this->_fetch( 'row', $query_result, $all );
	}

	function _fetch( $type, $query_result, $all )
	{
		if( $query_result == FALSE )
		{
			$query_result = $this->query_result;
		}

		if( $all == FALSE )
		{
			return eval ( 'return @mysql_fetch_'.$type.'( $query_result );' );
		}
		else
		{
			$array = array();
			for($i = 0; $i < @mysql_num_rows( $query_result ); $i++)
			{
			 	eval( '$array[$i] = @mysql_fetch_'.$type.'( $query_result );' );
			}
			return $array;
		}
	}

	function num_rows( $query_result = FALSE )
	{
		return ( $query_result != FALSE ) ? @mysql_num_rows( $query_result ) : @mysql_num_rows( $this->query_result );
	}

	function insert_id()
	{
		return @mysql_insert_id();
	}

	function affected_rows()
	{
		return @mysql_affected_rows();
	}

	function get_number_of_queries()
	{
		return $this->queries;
	}

	function get_last_query()
	{
		return $this->statements[count($this->statements) -1];
	}

	function free_result()
	{
		@mysql_free_result( $this->query_result );
	}

	function close()
	{
		return @mysql_close( $this->connection_id );
	}
}

?>
