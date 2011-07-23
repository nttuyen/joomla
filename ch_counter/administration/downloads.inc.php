<?php

/*
 **************************************
 *
 * administration/downloads.inc.php
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

if( CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED == FALSE )
{
	die( $_CHC_LANG['download_feature_is_deactivated'] );
}


if( isset( $_GET['action'] ) && $_GET['action'] == 'new_download' )
{
	if(
		isset( $_POST['new_download'] ) &&
		(
			empty( $_POST['wert'] )
			|| empty( $_POST['url'] )
		)
	)
	{
		$felder_nicht_vollstaendig = TRUE;
	}
	elseif( isset( $_POST['new_download'] ) )
	{
		$versuch_des_eintrages = TRUE;
		if( !preg_match( '#^(http|https|ftp)://#i', $_POST['url'] ) )
		{
			$_POST['url'] = 'http://'. $_POST['url'];
		}
		if( $_CHC_DB->query(
			'INSERT INTO `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."`
			( typ, wert, url, timestamp_eintrag )
			VALUES ( 'download', '". $_CHC_DB->escape_string( $_POST['wert'] ) ."', '". $_CHC_DB->escape_string( $_POST['url'] ) ."', ". time() .' );'
		) )
		{
			print $_CHC_LANG['download_successfully_inserted'] ."<br />\n<a href=\"index.php?cat=downloads\">". $_CHC_LANG['to_the_overall_view'] .'</a>';
		}
		else
		{
			print $_CHC_LANG['download_could_not_be_inserted'] ."<br />\n<a href=\"index.php?cat=downloads\">". $_CHC_LANG['to_the_overall_view'] .'</a>';
		}
	}
	if( !isset( $versuch_des_eintrages ) )
	{
		?>
<a href="index.php?cat=downloads">[ <?php print $_CHC_LANG['back_to_the_overall_view']; ?> ]</a><br />
<br />
<br />
<form action="index.php?cat=downloads&amp;action=new_download" method="post">
 <fieldset style="margin-left: auto; margin-right: auto; width: 500px;">
  <legend><?php print $_CHC_LANG['insert_a_new_download']; ?></legend>
  <table style="margin-left: auto; margin-right: auto; width: 500px;">
<?php
if( isset( $felder_nicht_vollstaendig ) )
{
	?>
   <tr>
    <td colspan="2"><b><?php print $_CHC_LANG['please_fill_out_every_field']; ?></b></td>
   </tr>
	<?php
}
?>
   <tr>
    <td><?php print $_CHC_LANG['name']; ?></td>
    <td><input type="text" name="wert" value="" size="50" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['URL']; ?></td>
    <td><input type="text" name="url" value="" size="50" /></td>
   </tr>
   <tr>
    <td></td>
    <td><input type="submit" name="new_download" value="<?php print $_CHC_LANG['insert_download']; ?>" /></td>
   </tr>
  </table>
 </fieldset>
</form>
		<?php
	}
}
elseif( isset( $_GET['edit'] ) )
{
	$_GET['edit'] = intval( $_GET['edit'] );
	if(
		isset( $_POST['edit_download'] ) &&
		(
			empty( $_POST['wert'] )
			|| empty( $_POST['url'] )
		)
	)
	{
		$felder_nicht_vollstaendig = TRUE;
	}
	elseif( isset( $_POST['edit_download'] ) )
	{
		$versuch_des_updates = TRUE;

		if( intval( $_POST['timestamp_eintrag'] ) == 0 )
		{
			$timestamp_eintrag = 0;
		}
		else
		{
			$tmp = explode( '-', $_POST['timestamp_eintrag'] );
			$preg_match = @preg_match( '/^(\d{1,2}), (\d{1,2}):(\d{1,2}):(\d{1,2})/', $tmp[2], $match );
			$timestamp_eintrag = @gmmktime( $match[2], $match[3], $match[4], $tmp[1], $match[1], $tmp[0] );
			if( count( $tmp ) != 3 || $preg_match != TRUE || $timestamp_eintrag == FALSE || $timestamp_eintrag == -1 )
			{
				$timestamp_eintrag =  0;
			}
			else
			{
				$timestamp_eintrag = $timestamp_eintrag - ( 3600 * ( $_CHC_CONFIG['zeitzone'] + $_CHC_CONFIG['dst'] ) );
			}
		}
		if( intval( $_POST['timestamp'] ) == 0 )
		{
			$timestamp = 0;
		}
		else
		{
			$tmp = explode( '-', $_POST['timestamp'] );
			$preg_match = @preg_match( '/^(\d{1,2}), (\d{1,2}):(\d{1,2}):(\d{1,2})/', $tmp[2], $match );
			$timestamp = @gmmktime( $match[2], $match[3], $match[4], $tmp[1], $match[1], $tmp[0] );
			if( count( $tmp ) != 3 || $preg_match != TRUE || $timestamp == FALSE || $timestamp == -1 )
			{
				$timestamp =  0;
			}
			else
			{
				$timestamp = $timestamp - ( 3600 * ( $_CHC_CONFIG['zeitzone'] + $_CHC_CONFIG['dst'] ) );
			}
		}

		if( !preg_match( '#^(http|https|ftp)://#i', $_POST['url'] ) )
		{
			$_POST['url'] = 'http://'. $_POST['url'];
		}

		$result = $_CHC_DB->query(
			'UPDATE `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."`
			SET
				wert = '". $_CHC_DB->escape_string( $_POST['wert'] ) ."',
				url = '". $_CHC_DB->escape_string( $_POST['url'] ) ."',
				anzahl = ". $_POST['anzahl'].',
				timestamp_eintrag = '. ( $timestamp_eintrag == 0 ? 'timestamp_eintrag' : $timestamp_eintrag ) .',
				timestamp = '. $timestamp .'
			WHERE id = '. intval( $_POST['dl_id'] ) .';'
		);
		if( $result == TRUE )
		{
			print '<b>'. $_CHC_LANG['entry_successfully_updated'] .'</b><br /><br />';
		}
		else
		{
			print '<b>'. $_CHC_LANG['entry_could_not_be_updated'] .'</b><br /><br />';
		}
	}

	$result = $_CHC_DB->query(
		'SELECT id, wert, url, timestamp_eintrag, timestamp, anzahl
		FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS .'`
		WHERE id = '. $_GET['edit'] ." AND typ = 'download';"
	);
	if( $_CHC_DB->num_rows( $result ) == 0 )
	{
		print $_CHC_LANG['could_not_find_the_requested_entry'];
	}
	else
	{
		$row = $_CHC_DB->fetch_assoc( $result );
		?>
<a href="index.php?cat=downloads">[ <?php print $_CHC_LANG['back_to_the_overall_view']; ?> ]</a><br />
<br />
<br />
<form action="index.php?cat=downloads&amp;edit=<?php print $_GET['edit']; ?>" method="post">
<input type="hidden" name="dl_id" value="<?php print $_GET['edit']; ?>" />
 <fieldset style="margin-left: auto; margin-right: auto; width: 500px;">
  <legend><?php print $_CHC_LANG['edit_a_download_entry']; ?></legend>
  <br />
  <table style="margin-left: auto; margin-right: auto; width: 500px;">
<?php
if( isset( $felder_nicht_vollstaendig ) )
{
	?>
   <tr>
    <td colspan="2"><b><?php print $_CHC_LANG['please_fill_out_every_field']; ?></b></td>
   </tr>
	<?php
}
?>
   <tr>
    <td><?php print $_CHC_LANG['name']; ?></td>
    <td><input type="text" name="wert" value="<?php print chC_str_prepare_for_output( $row['wert'] ); ?>" size="50" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['URL']; ?></td>
    <td><input type="text" name="url" value="<?php print chC_str_prepare_for_output( $row['url'] ); ?>" size="50" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['number_of_downloads']; ?></td>
    <td><input type="text" name="anzahl" value="<?php print $row['anzahl']; ?>" size="14" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['time_of_upload']; ?></td>
    <td><input type="text" name="timestamp_eintrag" value="<?php print chC_format_date( 'Y-m-d, H:i:s', $row['timestamp_eintrag'] ); ?>" size="20" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['last_download']; ?></td>
    <td><input type="text" name="timestamp" value="<?php print $row['timestamp'] > 0 ? chC_format_date( 'Y-m-d, H:i:s', $row['timestamp'] ) : ''; ?>" size="20" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['HTML_Code']; ?></td>
    <td><textarea readonly="readonly" rows="4" cols="40"><?php print htmlentities( '<a href="'. $_CHC_CONFIG['default_counter_url'] .'/getfile.php?id='. $row['id'] .'">'. $row['wert'] .'</a>' ); ?></textarea></td>
   </tr>
   <tr>
    <td colspan="2" style="padding-top: 20px; text-align: center;"><input type="submit" name="edit_download" value="<?php print $_CHC_LANG['save_entry']; ?>" /></td>
   </tr>
  </table>
 </fieldset>
</form>
		<?php
	}
}
elseif( isset( $_GET['delete'] ) && $_GET['delete'] == 'many' && isset( $_POST['IDs'] ) && is_array( $_POST['IDs'] ) && count( $_POST['IDs'] ) > 0 )
{
	foreach( $_POST['IDs'] as $key => $value )
	{
		$_POST[$key] = intval( $value );
	}

	if( isset( $_POST['delete_downloads'] ) )
	{
		$loeschversuch = TRUE;
		$result = $_CHC_DB->query(
			'DELETE FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS .'`
			WHERE ( id = '. implode( ' OR id = ', $_POST['IDs'] ) ." ) AND typ = 'download';"
		);
		$result = $_CHC_DB->query(
			'DELETE FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS .'`
			WHERE ( id = '. implode( ' OR id = ', $_POST['IDs'] ) ." ) AND typ = 'download';"
		);
		if( $_CHC_DB->affected_rows( $result ) > 0 )
		{
			print $_CHC_LANG['entries_successfully_deleted'] .'<br /><a href="index.php?cat=downloads">'. $_CHC_LANG['to_the_overall_view'] .'</a>';
		}
		else
		{
			print $_CHC_LANG['entries_could_not_be_deleted'] .'<br /><a href="index.php?cat=downloads">'. $_CHC_LANG['to_the_overall_view'] .'</a>';
		}
	}
	if( !isset( $loeschversuch ) )
	{
		$result = $_CHC_DB->query(
			'SELECT wert
			FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS .'`
			WHERE ( id = '. implode( ' OR id = ', $_POST['IDs'] ) ." ) AND typ = 'download';"
		);
		if( $_CHC_DB->num_rows( $result ) == 0 )
		{
			print $_CHC_LANG['could_not_find_the_requested_entries'];
		}
		else
		{
			?>
<a href="index.php?cat=downloads">[ <?php print $_CHC_LANG['back_to_the_overall_view']; ?> ]</a><br />
<br />
<br />
<form action="index.php?cat=downloads&amp;delete=many" method="post">
<?php
foreach( $_POST['IDs'] as $value )
{
	print '<input type="hidden" name="IDs[]" value="'. $value ."\" />\n";
}
?>
 <fieldset style="margin-left: auto; margin-right: auto; width: 500px; text-align: left;">
  <legend><?php print $_CHC_LANG['delete_entries']; ?></legend>
  <br />
  <?php print $_CHC_LANG['delete_many_entries_confirmation']; ?><br />
  <ul>
  <?php
  while( $row = $_CHC_DB->fetch_assoc( $result ) )
  {
	print '<li>'. $row['wert'] ."</li>\n";
  }
  ?>
  </ul>
  <input type="submit" name="delete_downloads" value="<?php print $_CHC_LANG['delete_all_displayed_entries_now']; ?>" />
 </fieldset>
</form>
			<?php
		}
	}
}
elseif( isset( $_GET['delete'] ) && $_GET['delete'] != 'many' )
{
	$_GET['delete'] = intval( $_GET['delete'] );
	if( isset( $_POST['delete_download'] ) )
	{
		$loeschversuch = TRUE;
		$result = $_CHC_DB->query(
			'DELETE FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS .'`
			WHERE id = '. intval( $_POST['dl_id'] ) ." AND typ = 'download';"
		);
		$result = $_CHC_DB->query(
			'DELETE FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS .'`
			WHERE id = '. intval( $_POST['dl_id'] ) ." AND typ = 'download';"
		);
		if( $_CHC_DB->affected_rows( $result ) == 1 )
		{
			print $_CHC_LANG['entry_successfully_deleted'] .'<br /><a href="index.php?cat=downloads">'. $_CHC_LANG['to_the_overall_view'] .'</a>';
		}
		else
		{
			print $_CHC_LANG['entry_could_not_be_deleted'] .'<br /><a href="index.php?cat=downloads">'. $_CHC_LANG['to_the_overall_view'] .'</a>';
		}
	}
	if( !isset( $loeschversuch ) )
	{
		$result = $_CHC_DB->query(
			'SELECT id, wert, url
			FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS .'`
			WHERE id = '. $_GET['delete'] ." AND typ = 'download';"
		);
		if( $_CHC_DB->num_rows( $result ) == 0 )
		{
			print $_CHC_LANG['could_not_find_the_requested_entry'];
		}
		else
		{
			$row = $_CHC_DB->fetch_assoc( $result );
			?>
<a href="index.php?cat=downloads">[ <?php print $_CHC_LANG['back_to_the_overall_view']; ?> ]</a><br />
<br />
<br />
<form action="index.php?cat=downloads&amp;delete=<?php print $_GET['delete']; ?>" method="post">
 <input type="hidden" name="dl_id" value="<?php print $_GET['delete']; ?>" />
 <fieldset style="margin-left: auto; margin-right: auto; width: 500px;">
  <legend><?php print $_CHC_LANG['delete_entry?']; ?></legend>
  <table style="margin-left: auto; margin-right: auto; width: 500px;">
   <tr>
    <td><?php print $_CHC_LANG['ID']; ?></td>
    <td><?php print $row['id']; ?></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['name']; ?></td>
    <td><?php print chC_str_prepare_for_output( $row['wert'] ); ?></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['URL']; ?></td>
    <td><?php print chC_str_prepare_for_output( $row['url'] ); ?></td>
   </tr>
   <tr>
    <td colspan="2"><input type="submit" name="delete_download" value="<?php print $_CHC_LANG['delete_entry_now']; ?>" /></td>
   </tr>
  </table>
 </fieldset>
</form>
			<?php
		}
	}
}
else
{
	$sort_by = array(
		'quantity' => 'anzahl',
		'upload' => 'timestamp_eintrag',
		'name' => 'wert'
	);
	if( isset( $_GET['sort_by'] ) && isset( $sort_by[$_GET['sort_by']] ) )
	{
		$sort_by = $sort_by[$_GET['sort_by']];
	}
	else
	{
		$_GET['sort_by'] = 'upload';
		$sort_by = 'timestamp_eintrag';
	}
	if( isset( $_GET['sort_order'] ) && $_GET['sort_order'] == 'asc' )
	{
		$sort_order = 'ASC';
	}
	else
	{
		$_GET['sort_order'] = 'desc';
		$sort_order = 'DESC';
	}

	$result = $_CHC_DB->query(
		'SELECT id, wert, url, timestamp_eintrag, timestamp, anzahl
		FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."`
		WHERE  typ = 'download'
		ORDER BY ". $sort_by .' '. $sort_order .';'
	);

	?>
<a href="index.php?cat=downloads&amp;action=new_download"><?php print $_CHC_LANG['new_download']; ?></a><br />
<br />
<br />
<form method="get" action="index.php">
 <input type="hidden" name="cat" value="downloads" />
 <select name="sort_by">
  <option value="quantity" <?php print $_GET['sort_by'] == 'quantity' ? 'selected' : ''; ?> ><?php print $_CHC_LANG['quantity']; ?></option>
  <option value="upload" <?php print $_GET['sort_by'] == 'upload' ? 'selected' : ''; ?> ><?php print $_CHC_LANG['upload_date']; ?></option>
  <option value="name" <?php print $_GET['sort_by'] == 'name' ? 'selected' : ''; ?> ><?php print $_CHC_LANG['name']; ?></option>
 </select>
 <select name="sort_order">
  <option value="asc" <?php print $_GET['sort_order'] == 'asc' ? 'selected' : ''; ?> ><?php print $_CHC_LANG['ascending']; ?></option>
  <option value="desc" <?php print $_GET['sort_order'] == 'desc' ? 'selected' : ''; ?> ><?php print $_CHC_LANG['descending']; ?></option>
 </select>
 <input type="submit" value="<?php print $_CHC_LANG['OK']; ?>" />
</form>
<form method="post" action="index.php?cat=downloads&amp;delete=many" name="downloads_loeschen">
<table style="width: 95%; margin-left: auto; margin-right: auto; border: 1px solid #000000;" cellspacing="1" cellpadding="1">
 <tr class="row3">
  <td class="caption_table_log_data"></td>
  <td class="caption_table_log_data"><?php print $_CHC_LANG['ID']; ?></td>
  <td class="caption_table_log_data"><?php print $_CHC_LANG['name']; ?></td>
  <td class="caption_table_log_data"><?php print $_CHC_LANG['URL']; ?></td>
  <td class="caption_table_log_data" style="text-align:right;"><?php print $_CHC_LANG['upload']; ?></td>
  <td class="caption_table_log_data" style="text-align:right;"><?php print $_CHC_LANG['last_download']; ?></td>
  <td class="caption_table_log_data" style="text-align:right;"><?php print $_CHC_LANG['downloads']; ?></td>
  <td class="caption_table_log_data">&nbsp;</td>
  <td class="caption_table_log_data">&nbsp;</td>
 </tr>
	<?php
	if( $_CHC_DB->num_rows( $result ) == 0 )
	{
		print "<tr class=\"row1\">\n"
			.'<td colspan="9" style="text-align: center;">'. $_CHC_LANG['no_entry_in_database'] ."</td>\n"
			."</tr>\n";
	}
	$i = 0;
	while( $row = $_CHC_DB->fetch_assoc( $result ) )
	{
		$letzter_download = ( $row['timestamp'] == '0' )
			? '-'
			: chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:complete'], $row['timestamp'] );

		print '<tr class="row'. ( !( $i % 2 ) ? 1 : 2 ) ."\">\n"
			.'<td><input type="checkbox" name="IDs[]" value="'. $row['id'] .'"'. ( isset( $_GET['check'] ) && $_GET['check'] == 'all' ? ' checked="checked"' : '' ) ." /></td>\n"
			.'<td>'. $row['id'] ."</td>\n"
			.'<td>'. chC_str_prepare_for_output( $row['wert'] ) ."</td>\n"
			.'<td>'. chC_str_prepare_for_output( $row['url'] ) ."</td>\n"
			.'<td style="text-align:right;">'. chC_format_date( $_CHC_LANG['CONFIG']['DATE_FORMATS']['common_date_format:complete'], $row['timestamp_eintrag'] ) ."</td>\n"
			.'<td style="text-align:right;">'. $letzter_download ."</td>\n"
			.'<td style="text-align:right;">'. $row['anzahl'] ."</td>\n"
			.'<td style="text-align:right;"><a href="index.php?cat=downloads&amp;edit='. $row['id'] .'">'. $_CHC_LANG['edit'] ."</a></td>\n"
			.'<td style="text-align:right;"><a href="index.php?cat=downloads&amp;delete='. $row['id'] .'">'. $_CHC_LANG['delete'] ."</a></td>\n"
			."</tr>\n";
		$i++;
	}
	if( $_CHC_DB->num_rows( $result ) > 0 )
	{
		?>
 <tr>
  <td colspan="9" style="padding-top: 20px;">
   <a href="index.php?cat=downloads&amp;check=all" onClick="set_checkboxes( document.downloads_loeschen.elements['IDs[]'], true ); return false;"><?php print $_CHC_LANG['check_all']; ?></a>&nbsp;&nbsp;&nbsp;
   <a href="index.php?cat=downloads" onClick="set_checkboxes( document.downloads_loeschen.elements['IDs[]'], false ); return false;"><?php print $_CHC_LANG['uncheck_all']; ?></a>
   &nbsp;&nbsp;&nbsp;<input type="submit" value="<?php print $_CHC_LANG['delete_the_selected_entries']; ?>" />
  </td>
 </tr>
		<?php
	}
	?>
 <tr>
  <td colspan="9" style="padding-top:10px;"><?php print $_CHC_LANG['general_URL_for_download_counting:']; ?><code style="margin-left: 10px;"><?php print $_CHC_CONFIG['default_counter_url']; ?>/getfile.php?id=x</code></td></td>
 </tr>	
</table>
</form>
	<?php
}

?>
