<?php

/*
 **************************************
 *
 * administration/logs.inc.php
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



if( !defined( 'CHC_ACP' ) )
{
	header( 'Location: http://'. $_SERVER['SERVER_NAME'] . dirname( $_SERVER['PHP_SELF'] ) .'/index.php' );
	exit;
}


$max = $_CHC_DB->query(
	'SELECT COUNT(nr) as anzahl
	FROM `'.CHC_TABLE_LOG_DATA.'`'
);
$max = $_CHC_DB->fetch_assoc( $max );
$max_seiten = @ceil( intval( $max['anzahl'] ) / $_CHC_CONFIG['anzahl_pro_logseite'] );
$seite = isset( $_GET['p'] )
	? (int) $_GET['p']
	: ( $_CHC_CONFIG['anordnung_log_eintraege'] == 'DESC' ? 1 : $max_seiten );
$start = ( $seite - 1 ) * $_CHC_CONFIG['anzahl_pro_logseite'];

$logdata = $_CHC_DB->query(
	'SELECT
		nr,
		ip,
		host,
		user_agent,
		timestamp,
		referrer,
		seitenaufrufe
	FROM `'. CHC_TABLE_LOG_DATA.'`
	ORDER BY timestamp '. ( $_CHC_CONFIG['anordnung_log_eintraege'] == 'DESC' ? 'DESC' : 'ASC' ) .'
	LIMIT '.$start.' , '.$_CHC_CONFIG['anzahl_pro_logseite']
);

if( $max_seiten > 1 )
{
	print "<div style=\"margin-left: auto; margin-right: auto; width:95%; text-align:center\">\n";
	for( $i = 1; $i < $seite; $i++ )
	{
		print '<a href="index.php?cat=logs&amp;p='. $i .'">'. $i ."</a> | \n";
	}
	print '<span style="font-size: 9pt; font-weight: bold;">'. $i ."</span>\n";
	for( $i = $seite + 1; $i < $max_seiten + 1; $i++ )
	{
		print ' | <a href="index.php?cat=logs&amp;p='. $i .'">'. $i ."</a>\n";
	}
	print "</div>\n<br />\n<br />\n";
}
?>
<table style="width: 95%; margin-left: auto; margin-right: auto; border: 1px solid #000000;" cellspacing="1" cellpadding="1">
 <tr class="row3">
  <td class="caption_table_log_data" style="width:7%;"><b><?php print $_CHC_LANG['No.']; ?></b></td>
  <td class="caption_table_log_data" style="width:15%"><b><?php print $_CHC_LANG['IP']; ?></b></td>
  <td class="caption_table_log_data" style="width:15%"><b><?php print $_CHC_LANG['Host']; ?></b></td>
  <td class="caption_table_log_data" style="width:21%"><b><?php print $_CHC_LANG['user_agent']; ?></b></td>
  <td class="caption_table_log_data" style="width:22%"><b><?php print $_CHC_LANG['referrer']; ?></b></td>
  <td class="caption_table_log_data" style="width:8%;"><b><?php print $_CHC_LANG['page_views']; ?></b></td>
  <td class="caption_table_log_data" style="width:12%"><b><?php print $_CHC_LANG['date_time']; ?></b></td>
 </tr>
<?php

$i = 0;
while( $row = $_CHC_DB->fetch_assoc( $logdata ) )
{
     if( !empty( $row['referrer'] ) )
     {
		$refhost = parse_url( $row['referrer'] );
		$refhost = isset( $refhost['host'] ) ? $refhost['host'] : $row['referrer'];
		if( strlen( $refhost ) > 25)
		{
				$refhost = substr( $refhost, 0, 22 ) .'...';
		}
		$referrer = '<a href="'. htmlentities( $row['referrer'] ) .'" target="_blank">'. chC_str_prepare_for_output( $refhost ) .'</a>';
	}
	else
	{
		$referrer = '';
	}

	print '<tr class="row'. ( !( $i % 2 ) ? 1 : 2 ) ."\">\n"
		."<td>\n"
		.' <a href="visitor_details.php?user_nr='. $row['nr'] .'" onclick="window.open( \'visitor_details.php?user_nr='. $row['nr'] .'\', \'visitor_details\', \'width=710, height=600, screenX=0, screenY=0, resizable=yes, scrollbars=yes\' ); return false;" target="visitor_details" title="'. $_CHC_LANG['visitor_details'] .'">'. $row['nr'] ."</a>\n"
		."</td>\n"
		."<td>\n"
		.' <a target="blank" href="http://whois.sc/'. chC_str_prepare_for_output( $row['ip'] ) .'">'. chC_str_prepare_for_output( $row['ip'] ) ."</a>\n"
		."</td>\n"
		.'<td>'. chC_str_prepare_for_output( $row['host'], 35 ) ."</td>\n"
		.'<td>' .chC_str_prepare_for_output( $row['user_agent'], 35) ."</td>\n"
		.'<td>'. $referrer ."</td>\n"
		.'<td style="text-align:right:">'. $row['seitenaufrufe'] ."</td>\n"
		."<td>\n"
		.' '. chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:complete'], $row['timestamp'] )
		.' <a href="visitor_details.php?user_nr='. $row['nr'] .'" onclick="window.open( \'visitor_details.php?user_nr='. $row['nr'] .'\', \'visitor_details\', \'width=710, height=600, screenX=0, screenY=0, resizable=yes, scrollbars=yes\' ); return false;" target="visitor_details">'
		.'<img src="../images/details.png" width="8" height="8" border="0" alt="" title="'. $_CHC_LANG['visitor_details'] ."\" /></a>\n</td>\n"
		."</tr>\n";
	$i++;
}

if( $_CHC_DB->num_rows( $logdata ) == 0 )
{
	print "<tr class=\"row1\">\n<td colspan=\"7\" style=\"text-align:center\">".$_CHC_LANG['no_visitors_logged_yet']."</td>\n</tr>\n";
}

?>
</table>
<br />
<?php
if( $max_seiten > 1 )
{
	print "<div style=\"margin-left: auto; margin-right: auto; width:95%; text-align:center\">\n";
	for( $i = 1; $i < $seite; $i++ )
	{
		print '<a href="index.php?cat=logs&amp;p='. $i .'">'. $i ."</a> | \n";
	}
	print '<span style="font-size: 9pt; font-weight: bold;">'. $i ."</span>\n";
	for( $i = $seite + 1; $i < $max_seiten + 1; $i++ )
	{
		print ' | <a href="index.php?cat=logs&amp;p='. $i .'">'. $i ."</a>\n";
	}
	print "</div>\n<br />\n<br />\n";
}
?>