<?php

/*
 **************************************
 *
 * administration/settings.inc.php
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

if( !isset( $_GET['sub'] ) )
{
	$_GET['sub'] = 'global_settings';
}



 ?>
<div class="sub_navigation">

 <div class="cat_settings"><b><?php print $_CHC_LANG['general_settings']; ?></b></div>
 <div class="subcat_settings">
  &bull;&nbsp;&nbsp;<a href="index.php?cat=settings&amp;sub=global_settings" <?php print ( $_GET['sub'] == 'global_settings' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['global_settings']; ?></a><br />
  &bull;&nbsp;&nbsp;<a href="index.php?cat=settings&amp;sub=users" <?php print ( $_GET['sub'] == 'users' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['user_management']; ?></a><br />
 </div>
 <div class="cat_settings"><b><?php print $_CHC_LANG['counter']; ?></b></div>
 <div class="subcat_settings">
  &bull;&nbsp;&nbsp;<a href="index.php?cat=settings&amp;sub=counter_settings" <?php print ( $_GET['sub'] == 'counter_settings' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['counter_settings']; ?></a><br />
  &bull;&nbsp;&nbsp;<a href="index.php?cat=settings&amp;sub=records" <?php print ( $_GET['sub'] == 'records' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['edit_counter_records']; ?></a>
 </div>
 <div class="cat_settings"><b><?php print $_CHC_LANG['statistics']; ?></b></div>
 <div class="subcat_settings">
  &bull;&nbsp;&nbsp;<a href="index.php?cat=settings&amp;sub=statistics_settings" <?php print ( $_GET['sub'] == 'statistics_settings' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['settings']; ?></a><br />
  &bull;&nbsp;&nbsp;<a href="index.php?cat=settings&amp;sub=(de)activate_stats" <?php print ( $_GET['sub'] == '(de)activate_stats' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['(de)activate_statistics']; ?></a><br />
  &bull;&nbsp;&nbsp;<?php print $_CHC_LANG['database_operations:']; ?>
  <ul>
   <li><a href="index.php?cat=settings&amp;sub=reset_stats" <?php print ( $_GET['sub'] == 'reset_stats' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['reset_statistics']; ?></a></li>
   <li><a href="index.php?cat=settings&amp;sub=data_cleanup" <?php print ( $_GET['sub'] == 'data_cleanup' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['data_cleanup']; ?></a></li>
  </ul>
  &bull;&nbsp;&nbsp;<?php print $_CHC_LANG['lists:']; ?>
  <ul>
   <li><a href="index.php?cat=settings&amp;sub=blacklists" <?php print ( $_GET['sub'] == 'blacklists' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['blacklists']; ?></a></li>
   <li><a href="index.php?cat=settings&amp;sub=exclusion_lists" <?php print ( $_GET['sub'] == 'exclusion_lists' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['exclusion_lists']; ?></a></li>
   <li><a href="index.php?cat=settings&amp;sub=hideout_lists" <?php print ( $_GET['sub'] == 'hideout_lists' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['hideout_lists']; ?></a></li>
  </ul>
  &bull;&nbsp;&nbsp;<?php print $_CHC_LANG['statistics_display']; ?><br />
  <ul>
   <li style="margin-bottom: 10px;"><a href="index.php?cat=settings&amp;sub=access_authorisations" <?php print ( $_GET['sub'] == 'access_authorisations' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['access_authorisations']; ?></a></li>
   <li><a href="index.php?cat=settings&amp;sub=stats_latest_top" <?php print ( $_GET['sub'] == 'stats_latest_top' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['top/latest']; ?></a></li>
   <li><a href="index.php?cat=settings&amp;sub=stats_pages" <?php print ( $_GET['sub'] == 'stats_pages' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['pages_and_currently_online']; ?></a></li>
   <li><a href="index.php?cat=settings&amp;sub=stats_referrers" <?php print ( $_GET['sub'] == 'stats_referrers' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['referrers,_search_engines_and_keywords']; ?></a></li>
   <li><a href="index.php?cat=settings&amp;sub=stats_visitors_details" <?php print ( $_GET['sub'] == 'stats_visitors_details' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['visitors_details']; ?></a></li>
   <li><a href="index.php?cat=settings&amp;sub=stats_access" <?php print ( $_GET['sub'] == 'stats_access' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['access_statistics']; ?></a></li>
   <li><a href="index.php?cat=settings&amp;sub=stats_all_lists" <?php print ( $_GET['sub'] == 'stats_all_lists' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['all_lists']; ?></a></li>
   <li><a href="index.php?cat=settings&amp;sub=logs" <?php print ( $_GET['sub'] == 'logs' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['log_data']; ?></a></li>
<?php
if( CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED == TRUE )
{
 	?>
   <li><a href="index.php?cat=settings&amp;sub=stats_downloads_and_hyperlinks" <?php print ( $_GET['sub'] == 'stats_downloads_and_hyperlinks' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['statistics_downloads_and_hyperlinks']; ?></a></li>
 	<?php
}
?>
  </ul>
 </div>

</div>

<div class="content" style="width: 555px; margin-left: auto; margin-right: 0px;">
<?php

if( $_GET['sub'] == 'global_settings' )
{
	if( isset( $_POST['submit'] ) )
	{
		if( $_POST['default_homepage_url'][strlen( $_POST['default_homepage_url'] ) - 1] == '/' )
		{
			$_POST['default_homepage_url'] = substr( $_POST['default_homepage_url'], 0, strlen( $_POST['default_homepage_url'] ) - 1 );
		}
		if( !preg_match( '#^(http|https|ftp)://#i', $_POST['default_homepage_url'] ) )
		{
			$_POST['default_homepage_url'] = 'http://'. $_POST['default_homepage_url'];
		}
		if( !preg_match( '#^(http|https|ftp)://#i', $_POST['default_counter_url'] ) )
		{
			$_POST['default_counter_url'] = 'http://'. $_POST['default_counter_url'];
		}

		/*if( doubleval( $_POST['zeitzone'] ) != doubleval( $_CHC_CONFIG['zeitzone'] ) )
		{
			$sek_korrektur = ( doubleval( $_POST['zeitzone'] ) - doubleval( $_CHC_CONFIG['zeitzone'] ) ) * 3600;
			$_CHC_DB->query(
				'UPDATE `'. CHC_TABLE_ACCESS .'`
				SET timestamp = timestamp + '. $sek_korrektur ."
				WHERE
					typ = 'tag' OR typ = 'kw' OR typ = 'jahr' OR typ = 'monat'"
			);
		}      */

		chC_set_config( array(
				'default_homepage_url' => $_POST['default_homepage_url'],
				'default_counter_url' => $_POST['default_counter_url'],
				'zeitzone' => $_POST['zeitzone'],
				'dst' => $_POST['dst'],
				'lang' => $_POST['lang'],
				'lang_administration' => $_POST['lang_administration'],
				'homepage_charset' => $_POST['homepage_charset']
			)
		);

		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}
	?>
<form method="post" action="index.php?cat=settings&amp;sub=global_settings">
<?php
if( isset( $msg ) )
{
	print ' <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
}
?>
 <fieldset>
  <legend><?php print $_CHC_LANG['URLs']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['hp_url']; ?></td>
    <td><input type="text" name="default_homepage_url" value="<?php print $_CHC_CONFIG['default_homepage_url']; ?>" size="30" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['url_of_counter_directory']; ?></td>
    <td><input type="text" name="default_counter_url" value="<?php print $_CHC_CONFIG['default_counter_url']; ?>" size="30" /></td>
   </tr>
  </table>
 </fieldset>
 <fieldset>
  <legend><?php print $_CHC_LANG['time_settings']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['time_zone']; ?></td>
    <td>
     <select name="zeitzone">
<?php
	foreach( $_CHC_LANG['time_zones'] as $offset => $name )
	{
		print '      <option value="'. $offset .'"';
		if( $offset == $_CHC_CONFIG['zeitzone'] )
		{
			print ' selected';
		}

		print '>'. $name ."</option>\n";
	}
    ?>
     </select>
    </td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['enable_daylight_saving_time:']; ?></td>
    <td>
     <input type="radio" name="dst" value="1" <?php print ( $_CHC_CONFIG['dst'] == '1' ) ? 'checked="checked"' : ''; ?> /><?php print $_CHC_LANG['yes']; ?><br />
     <input type="radio" name="dst" value="0" <?php print ( $_CHC_CONFIG['dst'] == '0' ) ? 'checked="checked"' : ''; ?> /><?php print $_CHC_LANG['no']; ?>
    </td>
   </tr>
  </table>
 </fieldset>
 <fieldset>
  <legend><?php print $_CHC_LANG['language_settings']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['default_language']; ?></td>
    <td>
     <select name="lang">
<?php
	$sprachen = chC_get_available_languages( CHC_ROOT .'/languages' );
	foreach( $sprachen as $lang_code => $lang_name )
	{
		print '      <option value="'. $lang_code .'"';
		if( $lang_code == $_CHC_CONFIG['lang'] )
		{
			print ' selected';
		}
		print '>'. $lang_name ."</option>\n";
	}
?>
     </select>
    </td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['administration_language']; ?></td>
    <td>
     <select name="lang_administration">
<?php
	foreach( $sprachen as $lang_code => $lang_name )
	{
		print '      <option value="'.$lang_code."\"";
		if( $lang_code == $_CHC_CONFIG['lang_administration'] )
		{
			print ' selected';
		}
		print '>'. $lang_name ."</option>\n";
	}
?>
     </select>
    </td>
   </tr>
  </table>
 </fieldset>
 <fieldset>
  <legend><?php print $_CHC_LANG['charset']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['homepage_charset:']; ?></td>
    <td><input type="text" name="homepage_charset" value="<?php print $_CHC_CONFIG['homepage_charset']; ?>" size="30" /></td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>
	<?php
}
elseif( $_GET['sub'] == 'users' )
{
	if( isset( $_POST['submit'] ) )
	{
		if(
			empty( $_POST['admin_name'] )
			|| (
				!(
					empty( $_POST['admin_pw_alt'] )
					&& empty( $_POST['admin_pw_neu1'] )
					&& empty( $_POST['admin_pw_neu2'] )
				)
				&& (
					empty( $_POST['admin_pw_alt'] )
					|| empty( $_POST['admin_pw_neu1'] )
					|| empty( $_POST['admin_pw_neu2'] )
				)
			)
		  )
		{
			$msg_admin = '<span class="error_msg">'. $_CHC_LANG['please_fill_out_each_required_field'] ."</span>\n";
		}
		elseif( !empty( $_POST['admin_pw_alt'] ) && md5( $_POST['admin_pw_alt'] ) != $_CHC_CONFIG['admin_passwort'] )
		{
			$msg_admin = '<span class="error_msg">'. $_CHC_LANG['wrong_password'] ."</span>\n";
		}
		elseif( $_POST['admin_pw_neu1'] != $_POST['admin_pw_neu2'] )
		{
			$msg_admin = '<span class="error_msg">'. $_CHC_LANG['password_repitition_does_not_match'] ."</span>\n";
		}
		else
		{
			chC_set_config(	'admin_name', $_POST['admin_name'] );
			if( !empty( $_POST['admin_pw_neu1'] ) )
			{
				chC_set_config( 'admin_passwort', md5( $_POST['admin_pw_neu1'] ) );
			}
			$msg_admin = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
		}


		$_POST['gast_name'] = trim( $_POST['gast_name'] );
		if(	!(
				empty( $_POST['gast_pw_neu1'] )
				&& empty( $_POST['gast_pw_neu2'] )
			)
			&& (
				empty( $_POST['gast_pw_neu1'] )
				|| empty( $_POST['gast_pw_neu2'] )
			)
		  )
		{
			$msg_gast = '<span class="error_msg">'. $_CHC_LANG['please_fill_out_each_field'] ."</span>\n";
		}
		else
		{
			chC_set_config( 'gast_name', $_POST['gast_name'] );
			if( empty( $_POST['gast_name'] ) )
			{
				chC_set_config( 'gast_passwort', '' );
			}
			elseif( !empty( $_POST['gast_pw_neu1'] ) )
			{
				chC_set_config( 'gast_passwort', md5( $_POST['gast_pw_neu1'] ) );
			}
			$msg_gast = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
		}
	}

	?>
<form method="post" action="index.php?cat=settings&amp;sub=users">
 <fieldset>
  <legend><?php print $_CHC_LANG['administrator']; ?></legend>
  &nbsp;
  <div style="margin-bottom: 20px;">
  <?php print $_CHC_LANG['settings_description_admin_login']; ?>
  </div>
<?php
if( isset( $msg_admin ) )
{
	print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg_admin ."</div>\n";
}
?>
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['name:']; ?> *</td>
    <td><input type="text" name="admin_name" value="<?php print $_CHC_CONFIG['admin_name']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['old_password:']; ?></td>
    <td><input type="password" name="admin_pw_alt" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['new_password:']; ?></td>
    <td><input type="password" name="admin_pw_neu1" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['new_password_(repetition):']; ?></td>
    <td><input type="password" name="admin_pw_neu2" /></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['guest_login']; ?></legend>
  &nbsp;
  <div style="margin-bottom: 20px;">
    <?php print $_CHC_LANG['settings_description_guest_login']; ?>
  </div>
<?php
if( isset( $msg_gast ) )
{
	print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg_gast ."</div>\n";
}
?>
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['name:']; ?></td>
    <td><input type="text" name="gast_name" value="<?php print $_CHC_CONFIG['gast_name']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['new_password:']; ?></td>
    <td><input type="password" name="gast_pw_neu1" value="" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['new_password_(repetition):']; ?></td>
    <td><input type="password" name="gast_pw_neu2" value="" /></td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>

	<?php

}
elseif( $_GET['sub'] == 'counter_settings' )
{
	if( isset( $_POST['submit'] ) )
	{
		chC_set_config( array(
				'user_online_fuer' => (int) $_POST['user_online_fuer'],
				'modus_zaehlsperre' => $_POST['modus_zaehlsperre'],
				'blockzeit' => (int) $_POST['blockzeit'],
				'admin_blocking_cookie' => isset( $_POST['admin_blocking_cookie'] ) ? 1 : 0 ,
				'block_robots' => isset( $_POST['block_robots'] ) ? 1 : 0,
				'default_counter_visibility' => $_POST['default_counter_visibility'],
				'counterstatus_statistikseiten' => intval( $_POST['counterstatus_statistikseiten'] ),
				'robots_von_js_stats_ausschliessen' => isset( $_POST['robots_von_js_stats_ausschliessen'] ) ? 1 : 0
			)
		);
		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}
	?>
<form method="post" action="index.php?cat=settings&amp;sub=counter_settings">
<?php
if( isset( $msg ) )
{
	print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
}
?>
 <fieldset>
  <legend><?php print $_CHC_LANG['counting_settings']; ?></legend>
  &nbsp;
  <table class="options_table" border="0">
   <tr>
    <td class="options_table_left_cell" style="padding-bottom: 6px;"><?php print $_CHC_LANG['description_blocking_mode']; ?></td>
    <td style="padding-bottom: 6px;">
     <input type="radio" name="modus_zaehlsperre" value="intervall" <?php print $_CHC_CONFIG['modus_zaehlsperre'] == 'intervall' ? 'checked="checked"' : ''; ?> />
     <?php print sprintf( $_CHC_LANG['for_x_seconds'], '<input type="text" name="blockzeit" value="'. $_CHC_CONFIG['blockzeit'] .'" size="5" />'); ?><br />
     <input type="radio" name="modus_zaehlsperre" value="restlichen_tag" <?php print $_CHC_CONFIG['modus_zaehlsperre'] == 'restlichen_tag' ? 'checked="checked"' : ''; ?> /> <?php print $_CHC_LANG['until_the_end_of_day']; ?>
    </td>
   </tr>
   <tr>
    <td class="options_table_left_cell" style="padding-bottom: 6px;"><?php print $_CHC_LANG['description_user_online_timespan']; ?></td>
    <td style="padding-bottom: 6px;"><input type="text" name="user_online_fuer" value="<?php print $_CHC_CONFIG['user_online_fuer']; ?>" size="5" /></td>
   </tr>
   <tr>
    <td class="options_table_left_cell" style="padding-bottom: 6px;"><label for="admin_blocking_cookie"><?php print $_CHC_LANG['use_admin_blocking_cookie']; ?></label></td>
    <td style="padding-bottom: 6px;">
     <input type="checkbox" name="admin_blocking_cookie" id="admin_blocking_cookie" value="1" <?php print $_CHC_CONFIG['admin_blocking_cookie'] == '1' ? 'checked="checked"' : ''; ?> />
     <input type="hidden" name="admin_blocking_cookie_change" value="1" />
    </td>
   </tr>
   <tr>
    <td class="options_table_left_cell" style="padding-bottom: 6px;"><label for="block_robots"><?php print $_CHC_LANG['do_not_count_robots']; ?></label></td>
    <td style="padding-bottom: 6px;"><input type="checkbox" name="block_robots" id="block_robots" value="1" <?php print $_CHC_CONFIG['block_robots'] == '1' ? 'checked="checked"' : ''; ?> /></td>
   </tr>
   <tr>
    <td class="options_table_left_cell" style="padding-bottom: 6px;"><label for="robots_von_js_stats_ausschliessen"><?php print $_CHC_LANG['exclude_robots_from_the_javascript_statistic']; ?></label></td>
    <td style="padding-bottom: 6px;"><input type="checkbox" name="robots_von_js_stats_ausschliessen" id="robots_von_js_stats_ausschliessen" value="1" <?php print $_CHC_CONFIG['robots_von_js_stats_ausschliessen'] == '1' ? 'checked="checked"' : ''; ?> /></td>
   </tr>
   <tr>
    <td class="options_table_left_cell" style="padding-bottom: 6px;"><?php print $_CHC_LANG['default_counter_visibility:']; ?></td>
    <td style="padding-bottom: 6px;">
     <select name="default_counter_visibility">
      <option value="1" <?php print $_CHC_CONFIG['default_counter_visibility'] == '1' ? 'selected' : ''; ?>><?php print $_CHC_LANG['visible']; ?></option>
      <option value="0" <?php print $_CHC_CONFIG['default_counter_visibility'] == '0' ? 'selected' : ''; ?>><?php print $_CHC_LANG['invisible']; ?></option>
     </select>
    </td>
   </tr>
   <tr>
    <td class="options_table_left_cell" style="padding-bottom: 6px;"><?php print $_CHC_LANG['counter_status_statistic_pages:']; ?></td>
    <td style="padding-bottom: 6px;">
     <select name="counterstatus_statistikseiten">
      <option value="1" <?php print $_CHC_CONFIG['counterstatus_statistikseiten'] == '1' ? 'selected' : ''; ?>><?php print $_CHC_LANG['active']; ?></option>
      <option value="0" <?php print $_CHC_CONFIG['counterstatus_statistikseiten'] == '0' ? 'selected' : ''; ?>><?php print $_CHC_LANG['inactive']; ?></option>
     </select>
    </td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>
	<?php
}
elseif( $_GET['sub'] == 'records' )
{
	if( isset( $_POST['submit'] ) )
	{
		if( intval( $_POST['timestamp_start_pseudo'] ) == 0 )
		{
			$timestamp_start_pseudo = 0;
		}
		else
		{
			$tmp = explode( '-', $_POST['timestamp_start_pseudo'] );
			$timestamp_start_pseudo = @gmmktime( 0, 0, 0, $tmp[1], $tmp[2], $tmp[0] );
			$timestamp_start_pseudo = ( $timestamp_start_pseudo == FALSE || $timestamp_start_pseudo == -1 ) ? 0 : $timestamp_start_pseudo;
		}
		chC_set_config( 'timestamp_start_pseudo', $timestamp_start_pseudo );



		$data = $_CHC_DB->query(
			'SELECT *
			FROM `'. CHC_TABLE_DATA .'`'
		);
		$data = $_CHC_DB->fetch_assoc( $data );

		if( $_POST['besucher_heute'] > $_POST['max_besucher_pro_tag:anzahl'] )
		{
			$_POST['max_besucher_pro_tag:anzahl'] = $_POST['besucher_heute'];
		}
		if( $_POST['besucher_gestern'] > $_POST['max_besucher_pro_tag:anzahl'] )
		{
			$_POST['max_besucher_pro_tag:anzahl'] = $_POST['besucher_gestern'];
		}
		if( intval( $_POST['max_besucher_pro_tag:timestamp'] ) == 0 )
		{
			$datum_max_besucher_pro_tag = 0;
		}
		else
		{
			$tmp = explode( '-', $_POST['max_besucher_pro_tag:timestamp'] );
			$datum_max_besucher_pro_tag = @gmmktime( 0, 0, 0, $tmp[1], $tmp[2], $tmp[0] );
			$datum_max_besucher_pro_tag = ( $datum_max_besucher_pro_tag == FALSE || $datum_max_besucher_pro_tag == -1 ) ? 0 : $datum_max_besucher_pro_tag;
		}

		if( $_POST['seitenaufrufe_heute'] > $_POST['max_seitenaufrufe_pro_tag:anzahl'] )
		{
			$_POST['max_seitenaufrufe_pro_tag:anzahl'] = $_POST['seitenaufrufe_heute'];
		}
		if( $_POST['seitenaufrufe_gestern'] > $_POST['max_seitenaufrufe_pro_tag:anzahl'] )
		{
			$_POST['max_seitenaufrufe_pro_tag:anzahl'] = $_POST['seitenaufrufe_gestern'];
		}
		if( intval( $_POST['max_seitenaufrufe_pro_tag:timestamp'] ) == 0 )
		{
			$datum_max_seitenaufrufe_pro_tag = 0;
		}
		else
		{
			$tmp = explode( '-', $_POST['max_seitenaufrufe_pro_tag:timestamp'] );
			$datum_max_seitenaufrufe_pro_tag = @gmmktime( 0, 0, 0, $tmp[1], $tmp[2], $tmp[0] );
			$datum_max_seitenaufrufe_pro_tag = ( $datum_max_seitenaufrufe_pro_tag == FALSE || $datum_max_seitenaufrufe_pro_tag == -1 ) ? 0 : $datum_max_seitenaufrufe_pro_tag;
		}

		if( intval( $_POST['max_online:timestamp'] ) == 0 )
		{
			$datum_max_online = 0;
		}
		else
		{
			$tmp = explode( '-', $_POST['max_online:timestamp'] );
			$datum_max_online = @gmmktime( 0, 0, 0, $tmp[1], $tmp[2], $tmp[0] );
			$datum_max_online = ( $datum_max_online == FALSE || $datum_max_online == -1 ) ? 0 : $datum_max_online;
		}

		$_CHC_DB->query(
			'UPDATE `'.CHC_TABLE_DATA.'`
			SET besucher_gesamt = '. intval( $_POST['besucher_gesamt'] ) .',
			besucher_heute = '. intval( $_POST['besucher_heute'] ) .',
			besucher_gestern = '. intval( $_POST['besucher_gestern'] ) .',
			`max_besucher_pro_tag:anzahl` = '. intval( $_POST['max_besucher_pro_tag:anzahl'] ) .',
			`max_besucher_pro_tag:timestamp` = '. intval( $datum_max_besucher_pro_tag ) .',
			seitenaufrufe_gesamt = '. intval( $_POST['seitenaufrufe_gesamt'] ) .',
			seitenaufrufe_heute = '. intval( $_POST['seitenaufrufe_heute'] ) .',
			seitenaufrufe_gestern = '. intval( $_POST['seitenaufrufe_gestern'] ) .',
			`max_seitenaufrufe_pro_tag:anzahl` = '. intval( $_POST['max_seitenaufrufe_pro_tag:anzahl'] ) .',
			`max_seitenaufrufe_pro_tag:timestamp` = '. intval( $datum_max_seitenaufrufe_pro_tag ) .',
			`max_online:anzahl` = '. intval( $_POST['max_online:anzahl'] ) .',
			`max_online:timestamp` = '. intval( $datum_max_online )
		);

		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}

	$data = $_CHC_DB->query(
			'SELECT *
			FROM `'. CHC_TABLE_DATA .'`'
		);
	$data = $_CHC_DB->fetch_assoc( $data );
	?>
<form method="post" action="index.php?cat=settings&amp;sub=records">
	<?php
	if( isset( $msg ) )
	{
		print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
	}
	?>
 <fieldset>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['counter_start:']; ?></td>
    <td><input type="text" name="timestamp_start_pseudo" value="<?php
	print $_CHC_CONFIG['timestamp_start_pseudo'] != '0' ? chC_format_date( 'Y-m-d', $_CHC_CONFIG['timestamp_start_pseudo'], FALSE ) : '';
	?>" /> (<?php print $_CHC_LANG['yyyy-mm-dd']; ?>)</td>
   </tr>
  </table>
 </fieldset>
 <fieldset>
  <legend><?php print $_CHC_LANG['visitors']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['total_visitors:']; ?></td>
    <td><input type="text" name="besucher_gesamt" value="<?php print $data['besucher_gesamt']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['visitors_today:']; ?></td>
    <td><input type="text" name="besucher_heute" value="<?php print $data['besucher_heute']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['visitors_yesterday:']; ?></td>
    <td><input type="text" name="besucher_gestern" value="<?php print $data['besucher_gestern']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['max_visitors_per_day:']; ?></td>
    <td><input type="text" name="max_besucher_pro_tag:anzahl" value="<?php print $data['max_besucher_pro_tag:anzahl']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['max_visitors_per_day_date:']; ?></td>
    <td><input type="text" name="max_besucher_pro_tag:timestamp" value="<?php
	print $data['max_besucher_pro_tag:timestamp'] != '0' ? chC_format_date( 'Y-m-d', $data['max_besucher_pro_tag:timestamp'], FALSE ) : '';
	?>" /> (<?php print $_CHC_LANG['yyyy-mm-dd']; ?>)</td>
   </tr>
  </table>
 </fieldset>
 <fieldset>
  <legend><?php print $_CHC_LANG['page_views']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['total_page_views:']; ?></td>
    <td><input type="text" name="seitenaufrufe_gesamt" value="<?php print $data['seitenaufrufe_gesamt']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['page_views_today:']; ?></td>
    <td><input type="text" name="seitenaufrufe_heute" value="<?php print $data['seitenaufrufe_heute']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['page_views_yesterday:']; ?></td>
    <td><input type="text" name="seitenaufrufe_gestern" value="<?php print $data['seitenaufrufe_gestern']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['max_page_views_per_day:']; ?></td>
    <td><input type="text" name="max_seitenaufrufe_pro_tag:anzahl" value="<?php print $data['max_seitenaufrufe_pro_tag:anzahl']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['max_page_views_per_day_date:']; ?></td>
    <td><input type="text" name="max_seitenaufrufe_pro_tag:timestamp" value="<?php
	print $data['max_seitenaufrufe_pro_tag:timestamp'] != '0' ? chC_format_date( 'Y-m-d', $data['max_seitenaufrufe_pro_tag:timestamp'], FALSE ) : '';
	?>" /> (<?php print $_CHC_LANG['yyyy-mm-dd']; ?>)</td>
   </tr>
  </table>
 </fieldset>
 <fieldset>
  <legend><?php print $_CHC_LANG['simultaneously_online']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['max_visitors_online:']; ?></td>
    <td><input type="text" name="max_online:anzahl" value="<?php print $data['max_online:anzahl']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['max_visitors_online_date:']; ?></td>
    <td><input type="text" name="max_online:timestamp" value="<?php
	print $data['max_online:timestamp'] != '0' ? chC_format_date( 'Y-m-d', $data['max_online:timestamp'], FALSE ) : '';
	?>" /> (<?php print $_CHC_LANG['yyyy-mm-dd']; ?>)</td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>
<?php
}
elseif( $_GET['sub'] == 'statistics_settings' )
{
	if( isset( $_POST['submit'] ) )
	{
		if( $_POST['log_eintraege_loeschen_nach:einheit_administration'] == 'h' )
		{
			$log_eintraege_loeschen_nach = intval( $_POST['log_eintraege_loeschen_nach:wert'] ) * 3600;
		}
		else
		{
			$log_eintraege_loeschen_nach = intval( $_POST['log_eintraege_loeschen_nach:wert'] ) * 86400;
		}

		if( !in_array( $_POST['php_self_oder_request_uri'], array( 'PHP_SELF', 'PHP_SELF + QUERY_STRING', 'REQUEST_URI' ) ) )
		{
			$_POST['php_self_oder_request_uri'] = 'REQUEST_URI';
		}

		chC_set_config(
			array(
				'log_eintraege_loeschen_nach:wert_in_sek' => $log_eintraege_loeschen_nach,
				'log_eintraege_loeschen_nach:einheit_administration' => $_POST['log_eintraege_loeschen_nach:einheit_administration'],

				'min_zeichenlaenge_suchwoerter_suchphrasen' => intval( $_POST['min_zeichenlaenge_suchwoerter_suchphrasen'] ),

				'seitenstatistik_titel_suche' => intval( $_POST['seitenstatistik_titel_suche'] ),
				'php_self_oder_request_uri' => $_POST['php_self_oder_request_uri'],

				'seiten_query_string_bereinigung_modus' => $_POST['seiten_query_string_bereinigung_modus'],
				'seiten_query_string_bereinigung_variablen' => $_POST['seiten_query_string_bereinigung_variablen'],

				'referrer_query_string_entfernen' => isset( $_POST['referrer_query_string_entfernen'] ) ? 1 : 0
			)
		);


		if( isset( $_POST['bereinige_seiten_jetzt'] ) )
		{
			$result = $_CHC_DB->query( 'SELECT wert, homepage_id, titel, anzahl, timestamp, monat FROM `'. CHC_TABLE_PAGES .'`' );
			if( $_CHC_DB->num_rows( $result ) > 0 )
			{
				$seiten = array();
				while( $row = $_CHC_DB->fetch_assoc( $result ) )
				{
					$row['wert'] = chC_page_purge_query_string( $row['wert'], $_CHC_CONFIG['seiten_query_string_bereinigung_modus'], $_CHC_CONFIG['seiten_query_string_bereinigung_variablen'] );

					if( isset( $seiten[$row['homepage_id']][$row['monat']][$row['wert']] ) )
					{
						$seiten[$row['homepage_id']][$row['monat']][$row['wert']]['anzahl'] += $row['anzahl'];
						if( $row['timestamp'] > $seiten[$row['homepage_id']][$row['monat']][$row['wert']]['timestamp'] )
						{
							$seiten[$row['homepage_id']][$row['monat']][$row['wert']]['timestamp'] = $row['timestamp'];
							$seiten[$row['homepage_id']][$row['monat']][$row['wert']]['titel'] = $row['titel'];
						}
					}
					else
					{
						$seiten[$row['homepage_id']][$row['monat']][$row['wert']] = array(
							'seite' => $_CHC_DB->escape_string( $row['wert'] ),
							'homepage_id' => $row['homepage_id'],
							'titel' => $_CHC_DB->escape_string( $row['titel'] ),
							'anzahl' => $_CHC_DB->escape_string( $row['anzahl'] ),
							'timestamp' => $row['timestamp']
						);
					}
				}

				$values = '';
				foreach( $seiten as $id_array )
				{
					foreach( $id_array as $monat => $value )
					{
						foreach( $value as $daten )
						{
							$values .= !empty( $values ) ? ",\n" : '';
							$values .= "('". implode( "', '", $daten ) ."', ". $monat .' )';
						}
					}
				}

				$_CHC_DB->query( 'DELETE FROM `'. CHC_TABLE_PAGES .'`' );
				$_CHC_DB->query(
					'INSERT INTO `'. CHC_TABLE_PAGES .'`
					( wert, homepage_id, titel, anzahl, timestamp, monat )
					VALUES '. $values
				);
			}
		}


		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}

	if( $_CHC_CONFIG['log_eintraege_loeschen_nach:einheit_administration'] == 'h' )
	{
		$log_eintraege_loeschen_nach = $_CHC_CONFIG['log_eintraege_loeschen_nach:wert_in_sek'] / 3600;
	}
	else
	{
		$log_eintraege_loeschen_nach = $_CHC_CONFIG['log_eintraege_loeschen_nach:wert_in_sek'] / 86400;;
	}
	?>
<form method="post" action="index.php?cat=settings&amp;sub=statistics_settings">
<?php
if( isset( $msg ) )
{
	print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
}
?>
 <fieldset>
  <legend><?php print $_CHC_LANG['logs']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['delete_log_entries_after:']; ?></td>
    <td>
     <input type="text" name="log_eintraege_loeschen_nach:wert" value="<?php print $log_eintraege_loeschen_nach; ?>" size="5" />
     <select name="log_eintraege_loeschen_nach:einheit_administration">
      <option value="h" <?php print $_CHC_CONFIG['log_eintraege_loeschen_nach:einheit_administration'] == 'h' ? 'selected' : ''; ?>><?php print $_CHC_LANG['delete_log_entries_after:unit:hours']; ?></option>
      <option value="d" <?php print $_CHC_CONFIG['log_eintraege_loeschen_nach:einheit_administration'] == 'd' ? 'selected' : ''; ?>><?php print $_CHC_LANG['delete_log_entries_after:unit:days']; ?></option>
     </select>
     <?php print $_CHC_LANG['(0_=_never)']; ?>
    </td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['search_keywords_phrases']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['ignore_strings_with_a_length_less_than:']; ?></td>
    <td>
     <?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="min_zeichenlaenge_suchwoerter_suchphrasen" value="'. $_CHC_CONFIG['min_zeichenlaenge_suchwoerter_suchphrasen'] .'" size="5" />' );
     ?>
    </td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['pages_statistic_page_titles']; ?></legend>
  &nbsp;
  <div style="clear: left; margin-bottom: 20px;">
   <?php print $_CHC_LANG['description_(de)activate_search_for_page_titles']; ?>
  </div>
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['search_for_page_titles:']; ?></td>
    <td>
     <input type="radio" name="seitenstatistik_titel_suche" value="1" <?php print $_CHC_CONFIG['seitenstatistik_titel_suche'] == '1' ? 'checked="checked"' : ''; ?> /> <?php print $_CHC_LANG['yes']; ?>
     <input type="radio" name="seitenstatistik_titel_suche" value="0" <?php print $_CHC_CONFIG['seitenstatistik_titel_suche'] == '0' ? 'checked="checked"' : ''; ?> /> <?php print $_CHC_LANG['no']; ?>
    </td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['pages_statistic_data_source']; ?></legend>
  &nbsp;
  <div style="clear: left; margin-bottom: 20px;">
   <?php print $_CHC_LANG['description_pages_statistic_data_source']; ?>
  </div>
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['use_PHP_SELF_or_REQUEST_URI:']; ?></td>
    <td>
     <select name="php_self_oder_request_uri">
      <option value="PHP_SELF" <?php print $_CHC_CONFIG['php_self_oder_request_uri'] == 'PHP_SELF' ? 'selected' : ''; ?>>PHP_SELF</option>
      <option value="PHP_SELF + QUERY_STRING" <?php print $_CHC_CONFIG['php_self_oder_request_uri'] == 'PHP_SELF + QUERY_STRING' ? 'selected' : ''; ?>>PHP_SELF + QUERY_STRING</option>
      <option value="REQUEST_URI" <?php print $_CHC_CONFIG['php_self_oder_request_uri'] == 'REQUEST_URI' ? 'selected' : ''; ?>>REQUEST_URI</option>
     </select>
    </td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['pages_statistic_query_string_cleanup']; ?></legend>
  &nbsp;
  <div style="clear: left; margin-bottom: 20px;">
   <?php print $_CHC_LANG['description_page_query_string_cleanup']; ?>
  </div>
  <div style="margin-bottom: 10px;">
   <input type="radio" name="seiten_query_string_bereinigung_modus" value="alle" <?php print $_CHC_CONFIG['seiten_query_string_bereinigung_modus'] == 'alle' ? 'checked="checked"' : ''; ?> /> <?php print $_CHC_LANG['keep_the_complete_query_string']; ?><br />
   <input type="radio" name="seiten_query_string_bereinigung_modus" value="keine" <?php print $_CHC_CONFIG['seiten_query_string_bereinigung_modus'] == 'keine' ? 'checked="checked"' : ''; ?> /> <?php print $_CHC_LANG['remove_the_complete_query_string']; ?>
  </div>
  <div style="margin-bottom: 20px;">
   <input type="radio" name="seiten_query_string_bereinigung_modus" value="nur" <?php print $_CHC_CONFIG['seiten_query_string_bereinigung_modus'] == 'nur' ? 'checked="checked"' : ''; ?> /> <?php print $_CHC_LANG['only_keep_the_following_variables:']; ?><br />
   <input type="radio" name="seiten_query_string_bereinigung_modus" value="ohne" <?php print $_CHC_CONFIG['seiten_query_string_bereinigung_modus'] == 'ohne' ? 'checked="checked"' : ''; ?> /> <?php print $_CHC_LANG['remove_the_following_variables:']; ?>
  </div>
  <div style="margin-bottom: 30px;">
   <?php print $_CHC_LANG['query_string_variables:']; ?><br />
   <br />
   <textarea name="seiten_query_string_bereinigung_variablen" rows="10" cols="40"><?php print $_CHC_CONFIG['seiten_query_string_bereinigung_variablen']; ?></textarea>
  </div>
  <table class="options_table">
   <tr>
    <td style="width: 30px;"><input type="checkbox" name="bereinige_seiten_jetzt" id="bereinige_seiten_jetzt" value="1" /></td>
    <td><label for="bereinige_seiten_jetzt"><?php print $_CHC_LANG['purge_page_entries_now']; ?></label></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['referrers_statistic_query_string_cleanup']; ?></legend>
  &nbsp;
  <div style="clear: left; margin-bottom: 10px;">
   <?php print $_CHC_LANG['description_remove_referrer_query_string']; ?>
  </div>
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><label for="referrer_query_string_entfernen"><?php print $_CHC_LANG['remove_query_string:']; ?></label></td>
    <td><input type="checkbox" name="referrer_query_string_entfernen" id="referrer_query_string_entfernen" value="1" <?php print $_CHC_CONFIG['referrer_query_string_entfernen'] == '1' ? 'checked="checked"' : ''; ?> /></td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>
	<?php
}
elseif( $_GET['sub'] == '(de)activate_stats' )
{
	if( isset( $_POST['submit'] ) )
	{
		$_POST['status_logs'] = isset( $_POST['status_logs'] ) ? 1 : 0;
		$_POST['status_access'] = isset( $_POST['status_access'] ) ? 1 : 0;
		$_POST['status_referrer'] = isset( $_POST['status_referrer'] ) ? 1 : 0;
		$_POST['status_user_agents'] = isset( $_POST['status_user_agents'] ) ? 1 : 0;
		$_POST['status_einstiegs_ausgangsseiten'] = isset( $_POST['status_einstiegs_ausgangsseiten'] ) ? 1 : 0;
		$_POST['status_einstiegs_ausgangsseiten'] = isset( $_POST['status_seiten'] ) ? $_POST['status_einstiegs_ausgangsseiten'] : 0;
		$_POST['status_seiten'] = isset( $_POST['status_seiten'] ) ? 1 : 0;
		$_POST['status_clh'] = isset( $_POST['status_clh'] ) ? 1 : 0;
		$_POST['status_suchphrasen'] = isset( $_POST['status_suchphrasen'] ) ? 1 : 0;
		$_POST['status_suchphrasen'] = isset( $_POST['status_suchmaschinen_und_suchwoerter'] ) ? $_POST['status_suchphrasen'] : 0;
		$_POST['status_suchmaschinen_und_suchwoerter'] = isset( $_POST['status_suchmaschinen_und_suchwoerter'] ) ? 1 : 0;
		$_POST['status_aufloesungen'] = isset( $_POST['status_aufloesungen'] ) ? 1 : 0;
		$_POST['status_js'] = isset( $_POST['status_js'] ) ? 1 : 0;

		chC_set_config( array(
				'status_logs' => $_POST['status_logs'],
				'status_access' => $_POST['status_access'],
				'status_referrer' => $_POST['status_referrer'],
				'status_user_agents' => $_POST['status_user_agents'],
				'status_seiten' => $_POST['status_seiten'],
				'status_einstiegs_ausgangsseiten' => $_POST['status_einstiegs_ausgangsseiten'],
				'status_clh' => $_POST['status_clh'],
				'status_suchmaschinen_und_suchwoerter' => $_POST['status_suchmaschinen_und_suchwoerter'],
				'status_suchphrasen' => $_POST['status_suchphrasen'],
				'status_aufloesungen' => $_POST['status_aufloesungen'],
				'status_js' => $_POST['status_js'],
			)
		);

		if( $_CHC_CONFIG['status_suchmaschinen_und_suchwoerter'] == '0' && $_CHC_CONFIG['status_suchphrasen'] == '1' )
		{
			chC_set_config( 'status_suchphrasen', 0 );
		}
		if( $_CHC_CONFIG['status_seiten'] == '0' && $_CHC_CONFIG['status_einstiegs_ausgangsseiten'] == '1' )
		{
			chC_set_config( 'status_einstiegs_ausgangsseiten', 0 );
		}

		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}
	?>
<form method="post" action="index.php?cat=settings&amp;sub=(de)activate_stats">
	<?php
	if( isset( $msg ) )
	{
		print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
	}
	?>
	
 <fieldset>
  <legend><?php print $_CHC_LANG['(de)activate_statistics']; ?></legend>
  &nbsp;
  <div style="margin-bottom: 20px;">
  <?php print $_CHC_LANG['description_(de)activate_statistics']; ?>
  </div>
  <table class="options_table">
   <tr>
    <td style="width: 30px;"><input type="checkbox" name="status_logs" id="status_logs" value="1" <?php print ( $_CHC_CONFIG['status_logs'] == '1' ) ? 'checked="checked"' : ''; ?> /></td>
    <td><label for="status_logs"><?php print $_CHC_LANG['log_data']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="status_access" id="status_access" value="1" <?php print ( $_CHC_CONFIG['status_access'] == '1' ) ? 'checked="checked"' : ''; ?> /></td>
    <td><label for="status_access"><?php print $_CHC_LANG['access_statistics']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="status_referrer" id="status_referrer" value="1" <?php print ( $_CHC_CONFIG['status_referrer'] == '1' ) ? 'checked="checked"' : ''; ?> /></td>
    <td><label for="status_referrer"><?php print $_CHC_LANG['referrers']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="status_user_agents" id="status_user_agents" value="1" <?php print ( $_CHC_CONFIG['status_user_agents'] == '1' ) ? 'checked="checked"' : ''; ?> /></td>
    <td><label for="status_user_agents"><?php print $_CHC_LANG['user_agents,browsers,os,robots']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="status_seiten" id="status_seiten" value="1" <?php print ( $_CHC_CONFIG['status_seiten'] == '1' ) ? 'checked="checked"' : ''; ?> /></td>
    <td><label for="status_seiten"><?php print $_CHC_LANG['pages_statistic']; ?></label></td>
   </tr>
   <tr>
    <td>&nbsp;</td>
    <td>
     <input type="checkbox" name="status_einstiegs_ausgangsseiten" id="status_einstiegs_ausgangsseiten" value="1" <?php print ( $_CHC_CONFIG['status_einstiegs_ausgangsseiten'] == '1' ) ? 'checked="checked"' : ''; ?> />
     <label for="status_einstiegs_ausgangsseiten"><?php print $_CHC_LANG['entry_and_exit_pages']; ?></label>
    </td>
   </tr>
   <tr>
    <td><input type="checkbox" name="status_clh" id="status_clh" value="1" <?php print ( $_CHC_CONFIG['status_clh'] == '1' ) ? 'checked="checked"' : ''; ?> /></td>
    <td><label for="status_clh"><?php print $_CHC_LANG['countries_languages_hosts_statistic']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="status_suchmaschinen_und_suchwoerter" id="status_suchmaschinen_und_suchwoerter" value="1" <?php print ( $_CHC_CONFIG['status_suchmaschinen_und_suchwoerter'] == '1' ) ? 'checked="checked"' : ''; ?> /></td>
    <td><label for="status_suchmaschinen_und_suchwoerter"><?php print $_CHC_LANG['search_engines_and_keywords']; ?></label></td>
   </tr>
   <tr>
    <td>&nbsp;</td>
    <td>
     <input type="checkbox" name="status_suchphrasen" id="status_suchphrasen" value="1" <?php print ( $_CHC_CONFIG['status_suchphrasen'] == '1' ) ? 'checked="checked"' : ''; ?> />
     <label for="status_suchphrasen"><?php print $_CHC_LANG['search_phrases']; ?></label>
    </td>
   </tr>
   <tr>
    <td><input type="checkbox" name="status_aufloesungen" id="status_aufloesungen" value="1" <?php print ( $_CHC_CONFIG['status_aufloesungen'] == '1' ) ? 'checked="checked"' : ''; ?> /></td>
    <td><label for="status_aufloesungen"><?php print $_CHC_LANG['screen_resolutions']; ?></label></td>
   </tr>
  <tr>
    <td><input type="checkbox" name="status_js" id="status_js" value="1" <?php print ( $_CHC_CONFIG['status_js'] == '1' ) ? 'checked="checked"' : ''; ?> /></td>
    <td><label for="status_js"><?php print $_CHC_LANG['JavaScript']; ?></label></td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>

	<?php
}
elseif( $_GET['sub'] == 'reset_stats' )
{
	if( isset( $_REQUEST['submit1'] ) && isset( $_POST['stats_to_reset'] ) )
	{
		?>
<form method="post" action="index.php?cat=settings&amp;sub=reset_stats">
 <fieldset>
  <legend><?php print $_CHC_LANG['reset_stats']; ?></legend>
  &nbsp;<br />
		<?php
		print $_CHC_LANG['reset_confirmation']."<br />\n<br />\n";
		foreach( $_POST['stats_to_reset'] as $value )
		{
			print "<input type=\"hidden\" name=\"". $value ."\" value=\"1\" />&bull;&nbsp;&nbsp;". $_CHC_LANG[$value] ."<br />\n";
		}
		?>
  <br />
  <input type="submit" name="submit3" value="<?php print $_CHC_LANG['No']; ?>" />
  <input type="submit" name="submit2" value="<?php print $_CHC_LANG['Yes']; ?>" />
 </fieldset>
</form>
		<?php
	}
	else
	{
		if( isset( $_REQUEST['submit2'] ) )
		{
			if( isset( $_POST['log_data'] ) )
			{
				$_CHC_DB->query( 'DELETE FROM `'. CHC_TABLE_LOG_DATA .'`' );
			}

			if( isset( $_POST['access_statistics'] ) )
			{
				$_CHC_DB->query( 'DELETE FROM `'. CHC_TABLE_ACCESS .'`' );
				$_CHC_DB->query(
					'INSERT INTO `'. CHC_TABLE_ACCESS .'`
					( timestamp, typ, erster_eintrag )
					VALUES
						( '. mktime(
							0,
							0,
							0,
							date( 'n' ),
							date( 'j' ),
							date( 'Y' )
						) .", 'tageszeit_wochentag_start', 0 ),
						( 0, 'tageszeit', 0 ),
						( 0, 'wochentag_1_Mon', 0 ),
						( 0, 'wochentag_2_Tue', 0 ),
						( 0, 'wochentag_3_Wed', 0 ),
						( 0, 'wochentag_4_Thu', 0 ),
						( 0, 'wochentag_5_Fri', 0 ),
						( 0, 'wochentag_6_Sat', 0 ),
						( 0, 'wochentag_7_Sun', 0 ),
						( ". chC_get_timestamp( 'tag' ) .", 'tag', 1 ),
						( ". chC_get_timestamp( 'kw' ) .", 'kw', 1 ),
						( ". chC_get_timestamp( 'monat' ) .", 'monat', 1 ),
						( ". chC_get_timestamp( 'jahr' ) .", 'jahr', 1 )"
				);
				chC_set_config( 'timestamp_start_access', time() );
			}

			if( isset( $_POST['referrers'] ) )
			{
				$_CHC_DB->query( 'DELETE FROM `'.CHC_TABLE_REFERRERS."` WHERE typ = 'referrer'" );
				chC_set_config( 'timestamp_start_referrer', time() );
			}

			if( isset( $_POST['referring_domain'] ) )
			{
				$_CHC_DB->query( 'DELETE FROM `'.CHC_TABLE_REFERRERS."` WHERE typ = 'domain'" );
				chC_set_config( 'timestamp_start_verweisende_domains', time() );
			}

			if( isset( $_POST['user_agents'] ) )
			{
				$_CHC_DB->query( 'DELETE FROM `'.CHC_TABLE_USER_AGENTS."` WHERE typ = 'user_agent'" );
				chC_set_config( 'timestamp_start_user_agents', time() );
			}

			if( isset( $_POST['browsers'] ) )
			{
				$_CHC_DB->query(
					'DELETE FROM `'.CHC_TABLE_USER_AGENTS."`
					WHERE typ = 'browser' OR typ = 'version~browser'"
				);
				chC_set_config( 'timestamp_start_browser', time() );
			}

			if( isset( $_POST['operating_systems'] ) )
			{
				$_CHC_DB->query(
					'DELETE FROM `'.CHC_TABLE_USER_AGENTS."`
					WHERE typ = 'os' OR typ = 'version~os'"
				);
				chC_set_config( 'timestamp_start_os', time() );
			}

			if( isset( $_POST['robots'] ) )
			{
				$_CHC_DB->query(
					'DELETE FROM `'.CHC_TABLE_USER_AGENTS."`
					WHERE typ = 'robot' OR typ = 'version~robot'"
				);
				chC_set_config( 'timestamp_start_robots', time() );
			}

			if( isset( $_POST['pages_statistic'] ) )
			{
				$_CHC_DB->query( 'DELETE FROM `'.CHC_TABLE_PAGES."`" );
				chC_set_config( 'timestamp_start_seiten', time() );
				$_CHC_DB->query(
					'UPDATE `'. CHC_TABLE_COUNTED_USERS .'`
					SET letzte_seite = 0;'
				);
			}

			if( isset( $_POST['downloads'] ) && CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED == TRUE )
			{
				$_CHC_DB->query( 'DELETE FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS ."` WHERE typ = 'download'" );
				$_CHC_DB->query(
					'UPDATE `'.CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."`
					SET
						anzahl = 0,
						timestamp = 0
					WHERE typ = 'download'"
				);
			}

			if( isset( $_POST['hyperlinks'] ) && CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED == TRUE )
			{
				$_CHC_DB->query( 'DELETE FROM `'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS_LOGS ."` WHERE typ = 'hyperlink'" );
				$_CHC_DB->query(
					'UPDATE `'.CHC_TABLE_DOWNLOADS_AND_HYPERLINKS ."`
					SET
						anzahl = 0,
						timestamp = 0
					WHERE typ = 'hyperlink'"
				);
			}

			if( isset( $_POST['countries_statistic'] ) )
			{
				$_CHC_DB->query( 'DELETE FROM `'.CHC_TABLE_LOCALE_INFORMATION."` WHERE typ = 'country'" );
				chC_set_config( 'timestamp_start_laender', time() );
			}

			if( isset( $_POST['languages_statistic'] ) )
			{
				$_CHC_DB->query( 'DELETE FROM `'.CHC_TABLE_LOCALE_INFORMATION."` WHERE typ = 'language'" );
				chC_set_config( 'timestamp_start_sprachen', time() );
			}

			if( isset( $_POST['hosts_statistic'] ) )
			{
				$_CHC_DB->query( 'DELETE FROM `'.CHC_TABLE_LOCALE_INFORMATION."` WHERE typ = 'host_tld'" );
				chC_set_config( 'timestamp_start_hosts_tlds', time() );
			}

			if( isset( $_POST['search_engines'] ) )
			{
				$_CHC_DB->query( 'DELETE FROM `'.CHC_TABLE_SEARCH_ENGINES."` WHERE typ = 'suchmaschine'" );
				chC_set_config( 'timestamp_start_suchmaschinen', time() );
			}

			if( isset( $_POST['search_keywords_phrases'] ) )
			{
				$_CHC_DB->query( 'DELETE FROM `'.CHC_TABLE_SEARCH_ENGINES."` WHERE typ = 'suchwort' OR typ = 'suchphrase'" );
				chC_set_config( 'timestamp_start_suchwoerter_suchphrasen', time() );
			}

			if( isset( $_POST['screen_resolutions'] ) )
			{
				$_CHC_DB->query( 'DELETE FROM `'.CHC_TABLE_SCREEN_RESOLUTIONS."`" );
				chC_set_config( 'timestamp_start_aufloesungen', time() );
			}

			if( isset( $_POST['JavaScript'] ) )
			{
				$_CHC_DB->query(
					'UPDATE `'. CHC_TABLE_DATA .'`
					SET js_alle = 0, js_robots = 0, js_aktiv = 0;'
				);
				chC_set_config( 'timestamp_start_javascript', time() );
			}

			if( isset( $_POST['visitors,page_views_per_day'] ) )
			{
				$_CHC_DB->query(
					'UPDATE `'.CHC_TABLE_DATA.'`
					SET
						`durchschnittlich_pro_tag:timestamp` = '. time() .',
						`durchschnittlich_pro_tag:besucher` = 0,
						`durchschnittlich_pro_tag:seitenaufrufe` = 0'
				);
			}

			if( isset( $_POST['page_views_per_visitor'] ) )
			{
				$_CHC_DB->query(
					'UPDATE `'.CHC_TABLE_DATA.'`
					SET
						`seitenaufrufe_pro_besucher:besucher` = 0,
						`seitenaufrufe_pro_besucher:seitenaufrufe` = 0'
				);
			}

			$_CHC_DB->query(
				'OPTIMIZE TABLES
					`'. CHC_TABLE_LOG_DATA .'`,
					`'. CHC_TABLE_REFERRERS .'`,
					`'. CHC_TABLE_USER_AGENTS .'`,
					`'. CHC_TABLE_LOCALE_INFORMATION .'`,
					`'. CHC_TABLE_SEARCH_ENGINES .'`,
					`'. CHC_TABLE_PAGES .'`,
					`'. CHC_TABLE_DOWNLOADS_AND_HYPERLINKS .'`,
					`'. CHC_TABLE_ACCESS .'`,
					`'. CHC_TABLE_SCREEN_RESOLUTIONS.'`'
			);

			$msg = '<b><i>'. $_CHC_LANG['statistics_were_reset'] .'</i></b>';
		}

		?>
<form method="post" action="index.php?cat=settings&amp;sub=reset_stats" name="form_reset_stats" >
		<?php
		if( isset( $msg ) )
		{
			print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
		}

		$checked = isset( $_GET['check'] ) ? 'checked="checked"' : '';

		?>
 <fieldset>
  <legend><?php print $_CHC_LANG['reset_stats']; ?></legend>
  &nbsp;
  <div style="margin-bottom: 20px;">
  <?php print $_CHC_LANG['description_reset_stats']; ?>
  </div>
  <table class="options_table">
   <tr>
    <td style="width: 30px;"><input type="checkbox" name="stats_to_reset[]" value="log_data" id="log_data" <?php print $checked; ?> /></td>
    <td><label for="log_data"><?php print $_CHC_LANG['log_data']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="access_statistics" id="access_statistics" <?php print $checked; ?> /></td>
    <td><label for="access_statistics"><?php print $_CHC_LANG['access_statistics']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="referrers" id="referrers" <?php print $checked; ?> /></td>
    <td><label for="referrers"><?php print $_CHC_LANG['referrers']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="referring_domain" id="referring_domain" <?php print $checked; ?> /></td>
    <td><label for="referring_domain"><?php print $_CHC_LANG['referring_domains']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="user_agents" id="user_agents" <?php print $checked; ?> /></td>
    <td><label for="user_agents"><?php print $_CHC_LANG['user_agents']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="browsers" id="browsers" <?php print $checked; ?> /></td>
    <td><label for="browsers"><?php print $_CHC_LANG['browsers']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="operating_systems" id="operating_systems" <?php print $checked; ?> /></td>
    <td><label for="operating_systems"><?php print $_CHC_LANG['operating_systems']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="robots" id="robots" <?php print $checked; ?> /></td>
    <td><label for="robots"><?php print $_CHC_LANG['robots']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="pages_statistic" id="pages_statistic" <?php print $checked; ?> /></td>
    <td><label for="pages_statistic"><?php print $_CHC_LANG['pages_statistic']; ?></label></td>
   </tr>
<?php
if( CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED == TRUE )
{
	?>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="downloads" id="downloads" <?php print $checked; ?> /></td>
    <td><label for="downloads"><?php print $_CHC_LANG['downloads']; ?></label></td>
   </tr>
    <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="hyperlinks" id="hyperlinks" <?php print $checked; ?> /></td>
    <td><label for="hyperlinks"><?php print $_CHC_LANG['hyperlinks']; ?></label></td>
   </tr>
	<?php
}
?>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="countries_statistic" id="countries_statistic" <?php print $checked; ?> /></td>
    <td><label for="countries_statistic"><?php print $_CHC_LANG['countries_statistic']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="languages_statistic" id="languages_statistic" <?php print $checked; ?> /></td>
    <td><label for="languages_statistic"><?php print $_CHC_LANG['languages_statistic']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="hosts_statistic" id="hosts_statistic" <?php print $checked; ?> /></td>
    <td><label for="hosts_statistic"><?php print $_CHC_LANG['hosts_statistic']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="search_engines" id="search_engines" <?php print $checked; ?> /></td>
    <td><label for="search_engines"><?php print $_CHC_LANG['search_engines']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="search_keywords_phrases" id="search_keywords_phrases" <?php print $checked; ?> /></td>
    <td><label for="search_keywords_phrases"><?php print $_CHC_LANG['search_keywords_phrases']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="screen_resolutions" id="screen_resolutions" <?php print $checked; ?> /></td>
    <td><label for="screen_resolutions"><?php print $_CHC_LANG['screen_resolutions']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="JavaScript" id="JavaScript" <?php print $checked; ?> /></td>
    <td><label for="JavaScript"><?php print $_CHC_LANG['JavaScript']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="visitors,page_views_per_day" id="visitors_page_views_per_day" <?php print $checked; ?> /></td>
    <td><label for="visitors_page_views_per_day"><?php print $_CHC_LANG['visitors,page_views_per_day']; ?></label></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="stats_to_reset[]" value="page_views_per_visitor" id="page_views_per_visitor" <?php print $checked; ?> /></td>
    <td><label for="page_views_per_visitor"><?php print $_CHC_LANG['page_views_per_visitor']; ?></label></td>
   </tr>
   <tr>
    <td colspan="2" style="padding-top: 15px;">
     <a href="index.php?cat=settings&amp;sub=reset_stats&amp;check=all" onClick="set_checkboxes( document.form_reset_stats.elements['stats_to_reset[]'], true ); return false;"><?php print $_CHC_LANG['check_all']; ?></a>&nbsp;&nbsp;&nbsp;
     <a href="index.php?cat=settings&amp;sub=reset_stats" onClick="set_checkboxes( document.form_reset_stats.elements['stats_to_reset[]'], false ); return false;"><?php print $_CHC_LANG['uncheck_all']; ?></a>
    </td>
   </tr>
   <tr>
    <td colspan="2" style="padding-top: 20px;"><input type="submit" name="submit1" value="<?php print $_CHC_LANG['reset_statistics_now']; ?> "/></td>
   </tr>
  </table>
 </fieldset>
</form>
		<?php
	}
}
elseif( $_GET['sub'] == 'data_cleanup' )
{
	if( isset( $_REQUEST['submit_general_cleanup'] ) )
	{
		chC_general_db_cleanup();
		$_CHC_DB->query(
			'UPDATE `'. CHC_TABLE_DATA .'`
			SET timestamp_letztes_db_aufraeumen = '. CHC_TIMESTAMP
		);
		$msg_general_cleanup = '<b><i>'. $_CHC_LANG['cleanup_performed'] .'</i></b>';
	}
	elseif( isset( $_REQUEST['submit_user_agents_referrers_cleanup'] ) )
	{
		switch( $_POST['typ'] )
		{
			case 'user_agent':	$table = CHC_TABLE_USER_AGENTS; break;
			case 'referrer':	$table = CHC_TABLE_REFERRERS; break;
			case 'domain':	$table = CHC_TABLE_REFERRERS; break;
		}

		$_POST['anzahl'] = intval( $_POST['anzahl'] );
		$_POST['tage'] = intval( $_POST['tage'] );

		$result = $_CHC_DB->query(
			'SELECT
				SUM(anzahl) as anzahl,
				MAX(timestamp) as timestamp
			FROM `'. $table ."`
			WHERE
				typ = '". $_CHC_DB->escape_string( $_POST['typ'] ) ."' AND
				wert != '__chC:more__' AND
				anzahl <= ". $_POST['anzahl'] ." AND
				timestamp <= ". ( CHC_TIMESTAMP - ( $_POST['tage'] * 86400 ) )
		);
		$alte_eintraege = $_CHC_DB->fetch_assoc( $result );

		if( $alte_eintraege['anzahl'] > 0 )
		{
			$_CHC_DB->query(
				'DELETE FROM `'. $table ."`
				WHERE
					typ = '". $_CHC_DB->escape_string( $_POST['typ'] ) ."' AND
					anzahl <= ". $_POST['anzahl'] ." AND
					timestamp <= ". ( CHC_TIMESTAMP - ( $_POST['tage'] * 86400 ) )
			);
			$geloescht = $_CHC_DB->affected_rows();

			$_CHC_DB->query(
				'UPDATE `'. $table .'`
				SET
					anzahl = anzahl + '. $alte_eintraege['anzahl'] .',
					timestamp = IF( timestamp > '. $alte_eintraege['timestamp'] .', timestamp, '. $alte_eintraege['timestamp'] ." )
				WHERE
					typ = '". $_POST['typ'] ."' AND
					wert = '__chC:more__'"
				);
			if( $_CHC_DB->affected_rows() == 0 )
			{
				$_CHC_DB->query(
					'INSERT INTO `'. $table ."`
					( typ, wert, anzahl, timestamp )
					VALUES ( '". $_CHC_DB->escape_string( $_POST['typ'] ) ."', '__chC:more__', ". $alte_eintraege['anzahl'] .", ". $alte_eintraege['timestamp'] ." )"
				);
			}
		}

		if( !isset( $geloescht ) )
		{
			$geloescht = 0;
		}

		$msg_user_agents_referrers_cleanup = '<b><i>'. sprintf( $_CHC_LANG['cleanup_performed_(x_rows_deleted)'], $geloescht ) .'</i></b>';
	}
	elseif( isset( $_REQUEST['submit'] ) )
	{
		chC_set_config( array(
				'regelmaessiges_loeschen:user_agents:aktiviert' => isset( $_POST['rc_user_agents'] ) ? 1 : 0,
				'regelmaessiges_loeschen:user_agents:werte' => intval( $_POST['rc_user_agents_anzahl'] )  .';'. ( intval( $_POST['rc_user_agents_tage'] ) * 86400 ),

				'regelmaessiges_loeschen:referrer:aktiviert' => isset( $_POST['rc_referrer'] ) ? 1 : 0,
				'regelmaessiges_loeschen:referrer:werte' => intval( $_POST['rc_referrer_anzahl'] )  .';'. ( intval( $_POST['rc_referrer_tage'] ) * 86400 ),

				'regelmaessiges_loeschen:verweisende_domains:aktiviert' => isset( $_POST['rc_verweisende_domains'] ) ? 1 : 0,
				'regelmaessiges_loeschen:verweisende_domains:werte' => intval( $_POST['rc_verweisende_domains_anzahl'] )  .';'. ( intval( $_POST['rc_verweisende_domains_tage'] ) * 86400 ),
			)
		);
		$msg_regular_cleanup = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}
	?>
<?php
$anzahl_user_agents = $_CHC_DB->query(
	'SELECT COUNT(wert) AS anzahl
	FROM `'. CHC_TABLE_USER_AGENTS ."`
	WHERE
		typ = 'user_agent'
		AND wert != '__chC:more__'"
);
$anzahl_user_agents = $_CHC_DB->fetch_assoc( $anzahl_user_agents );
$anzahl_user_agents = $anzahl_user_agents['anzahl'];

$anzahl_referrers = $_CHC_DB->query(
	'SELECT COUNT(wert) AS anzahl
	FROM `'. CHC_TABLE_REFERRERS ."`
	WHERE
		typ = 'referrer'
		AND wert != '__chC:more__'"
);
$anzahl_referrers = $_CHC_DB->fetch_assoc( $anzahl_referrers );
$anzahl_referrers = $anzahl_referrers['anzahl'];

$anzahl_referring_domains = $_CHC_DB->query(
	'SELECT COUNT(wert) AS anzahl
	FROM `'. CHC_TABLE_REFERRERS ."`
	WHERE
		typ = 'domain'
		AND wert != '__chC:more__'"
);
$anzahl_referring_domains = $_CHC_DB->fetch_assoc( $anzahl_referring_domains );
$anzahl_referring_domains = $anzahl_referring_domains['anzahl'];


// rc = regular_cleanup ;-)
list( $rc_user_agents_anzahl, $rc_user_agents_tage ) = explode( ';', $_CHC_CONFIG['regelmaessiges_loeschen:user_agents:werte'] );
list( $rc_referrer_anzahl, $rc_referrer_tage ) = explode( ';', $_CHC_CONFIG['regelmaessiges_loeschen:referrer:werte'] );
list( $rc_verweisende_domains_anzahl, $rc_verweisende_domains_tage ) = explode( ';', $_CHC_CONFIG['regelmaessiges_loeschen:verweisende_domains:werte'] );

$rc_user_agents_tage = round( $rc_user_agents_tage / 86400 );
$rc_referrer_tage = round( $rc_referrer_tage / 86400 );
$rc_verweisende_domains_tage = round( $rc_verweisende_domains_tage / 86400 );

?>
<form method="post" action="index.php?cat=settings&amp;sub=data_cleanup">
 <fieldset>
  <legend><?php print $_CHC_LANG['user_agents,referrers_cleanup']; ?></legend>
  &nbsp;
  <div style="margin-bottom: 30px;">
  <?php print $_CHC_LANG['description_user_agents,referrers_cleanup']; ?>
  </div>
  <b><?php print $_CHC_LANG['regular_cleanup'] ?></b><br />
  <br />
<?php
if( isset( $msg_regular_cleanup ) )
{
	print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg_regular_cleanup ."</div>\n";
}
?>
  <table class="options_table">
   <tr>
    <td>&nbsp;</td>
    <td><?php print $_CHC_LANG['max_incidences:']; ?></td>
    <td><?php print $_CHC_LANG['days_passed_since_last_incidence:']; ?></td>
   </tr>
   <tr>
    <td>
     <input type="checkbox" name="rc_user_agents" id="rc_user_agents" value="1" <?php print $_CHC_CONFIG['regelmaessiges_loeschen:user_agents:aktiviert'] == '1' ? 'checked="checked"' : ''; ?> />
     <label for="rc_user_agents"><?php print $_CHC_LANG['user_agents']; ?></label>
    </td>
    <td><input type="text" name="rc_user_agents_anzahl" value="<?php print $rc_user_agents_anzahl; ?>" size="6" /></td>
    <td><input type="text" name="rc_user_agents_tage" value="<?php print $rc_user_agents_tage; ?>" size="6" /></td>
   </tr>
   <tr>
    <td>
     <input type="checkbox" name="rc_referrer" id="rc_referrer" value="1" <?php print $_CHC_CONFIG['regelmaessiges_loeschen:referrer:aktiviert'] == '1' ? 'checked="checked"' : ''; ?> />
     <label for="rc_referrer"><?php print $_CHC_LANG['referrers']; ?></label>
    </td>
    <td><input type="text" name="rc_referrer_anzahl" value="<?php print $rc_referrer_anzahl; ?>" size="6" /></td>
    <td><input type="text" name="rc_referrer_tage" value="<?php print $rc_referrer_tage; ?>" size="6" /></td>
   </tr>
   <tr>
    <td>
     <input type="checkbox" name="rc_verweisende_domains" id="rc_verweisende_domains" value="1" <?php print $_CHC_CONFIG['regelmaessiges_loeschen:verweisende_domains:aktiviert'] == '1' ? 'checked="checked"' : ''; ?> />
     <label for="rc_verweisende_domains"><?php print $_CHC_LANG['referring_domains']; ?></label>
    </td>
    <td><input type="text" name="rc_verweisende_domains_anzahl" value="<?php print $rc_verweisende_domains_anzahl; ?>" size="6" /></td>
    <td><input type="text" name="rc_verweisende_domains_tage" value="<?php print $rc_verweisende_domains_tage; ?>" size="6" /></td>
   </tr>
   <tr>
    <td colspan="4" style="padding-top: 20px;"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></td>
   </tr>
  </table>
  <br />
  <br />
  <br />
  <br />
  <br />
  <b><?php print $_CHC_LANG['immediate_cleanup'] ?></b><br />
  <br />
<?php
if( isset( $msg_user_agents_referrers_cleanup ) )
{
	print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg_user_agents_referrers_cleanup ."</div>\n";
}
?>
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['type:']; ?></td>
    <td>
     <select name="typ">
      <option value="user_agent"><?php print sprintf( $_CHC_LANG['cleanup:type_and_number_of_entries'], $_CHC_LANG['user_agents'], $anzahl_user_agents ); ?></option>
      <option value="referrer"><?php print sprintf( $_CHC_LANG['cleanup:type_and_number_of_entries'], $_CHC_LANG['referrers'], $anzahl_referrers ); ?></option>
      <option value="domain"><?php print sprintf( $_CHC_LANG['cleanup:type_and_number_of_entries'], $_CHC_LANG['referring_domains'], $anzahl_referring_domains ); ?></option>
     </select>
    </td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['max_incidences:']; ?></td>
    <td><input type="text" name="anzahl" value="1" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['days_passed_since_last_incidence:']; ?></td>
    <td><input type="text" name="tage" value="60" /></td>
   </tr>
   <tr>
    <td colspan="2" style="padding-top: 20px;"><input type="submit" name="submit_user_agents_referrers_cleanup" value="<?php print $_CHC_LANG['perform_cleanup']; ?> "/></td>
   </tr>
  </table>
 </fieldset>
</form>
<!--
<br />
<br />
<br />
<form method="post" action="index.php?cat=settings&amp;sub=data_cleanup" name="" >
 <fieldset>
  <legend><?php print $_CHC_LANG['general_cleanup']; ?></legend>
  &nbsp;
  <div style="margin-bottom: 20px;">
  <?php print $_CHC_LANG['description_general_cleanup']; ?>
  </div>
<?php
if( isset( $msg_general_cleanup ) )
{
	print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg_general_cleanup ."</div>\n";
}
?>
  <div style="clear: left;"><input type="submit" name="submit_general_cleanup" value="<?php print $_CHC_LANG['perform_cleanup']; ?> "/></div>
 </fieldset>
</form>
-->
	<?php
}
elseif( $_GET['sub'] == 'blacklists' )
{
	if( isset( $_POST['submit'] ) )
	{
		$array = array(
			'blacklist_ips',
			'blacklist_hosts',
			'blacklist_referrers',
			'blacklist_user_agents'
		);
		foreach( $array as $value )
		{
			$_POST[$value] = trim( $_POST[$value] );
			$_POST[$value] = preg_replace( '/(\r|\n|\r\n)/', '; ', $_POST[$value] );
			$_POST[$value] = preg_replace( '/(; )+$/', '', $_POST[$value] );
			$_POST[$value] = preg_replace( '/(; )+/', '; ', $_POST[$value] );
			chC_set_config( $value, $_POST[$value] );
		}

		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}
	?>
<form method="post" action="index.php?cat=settings&amp;sub=blacklists">
	<?php
	if( isset( $msg ) )
	{
		print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
	}
	?>
 <fieldset>
  <legend><?php print $_CHC_LANG['blacklists']; ?></legend>
  &nbsp;
  <div style="margin-bottom: 30px;">
  <?php print $_CHC_LANG['description_blacklists']; ?>
  </div>
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell" style="vertical-align: top;"><?php print $_CHC_LANG['IPs:']; ?></td>
    <td style="vertical-align: top;"><textarea name="blacklist_ips" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['blacklist_ips'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['hosts:']; ?></td>
    <td style="vertical-align: top;"><textarea name="blacklist_hosts" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['blacklist_hosts'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['user_agents:']; ?></td>
    <td style="vertical-align: top;"><textarea name="blacklist_user_agents" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['blacklist_user_agents'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['referrers:']; ?></td>
    <td style="vertical-align: top;"><textarea name="blacklist_referrers" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['blacklist_referrers'] ); ?></textarea></td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>
	<?php
}
elseif( $_GET['sub'] == 'exclusion_lists' )
{
	if( isset( $_POST['submit'] ) )
	{
		$array = array(
			'exclusion_list_keywords',
			'exclusion_list_search_phrases',
			'exclusion_list_search_engines',
			'exclusion_list_pages',
			'exclusion_list_screen_resolutions',
			'exclusion_list_referrers',
			'exclusion_list_user_agents'
		);
		foreach( $array as $value )
		{
			$_POST[$value] = trim( $_POST[$value] );
			$_POST[$value] = preg_replace( '/(\r|\n|\r\n)/', '; ', $_POST[$value] );
			$_POST[$value] = preg_replace( '/(; )+$/', '', $_POST[$value] );
			$_POST[$value] = preg_replace( '/(; )+/', '; ', $_POST[$value] );
			chC_set_config( $value, $_POST[$value] );
		}

		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}
	?>
<form method="post" action="index.php?cat=settings&amp;sub=exclusion_lists">
	<?php
	if( isset( $msg ) )
	{
		print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
	}
	?>
 <fieldset>
  <legend><?php print $_CHC_LANG['exclusion_lists']; ?></legend>
  &nbsp;
  <div style="margin-bottom: 30px;">
  <?php print $_CHC_LANG['description_exclusion_lists']; ?>
  </div>
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell" style="vertical-align: top;"><?php print $_CHC_LANG['user_agents:']; ?></td>
    <td style="vertical-align: top;"><textarea name="exclusion_list_user_agents" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['exclusion_list_user_agents'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['referrers:']; ?></td>
    <td style="vertical-align: top;"><textarea name="exclusion_list_referrers" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['exclusion_list_referrers'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['pages_(relative_from_hp_root):']; ?></td>
    <td style="vertical-align: top;"><textarea name="exclusion_list_pages" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['exclusion_list_pages'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['search_engines:']; ?></td>
    <td style="vertical-align: top;"><textarea name="exclusion_list_search_engines" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['exclusion_list_search_engines'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['search_keywords:']; ?></td>
    <td style="vertical-align: top;"><textarea name="exclusion_list_keywords" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['exclusion_list_keywords'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['search_phrases:']; ?></td>
    <td style="vertical-align: top;"><textarea name="exclusion_list_search_phrases" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['exclusion_list_search_phrases'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['screen_resolutions:']; ?></td>
    <td style="vertical-align: top;"><textarea name="exclusion_list_screen_resolutions" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['exclusion_list_screen_resolutions'] ); ?></textarea></td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>
	<?php
}
elseif( $_GET['sub'] == 'hideout_lists' )
{
	if( isset( $_POST['submit'] ) )
	{
		$array = array(
			'hideout_list_keywords',
			'hideout_list_search_phrases',
			'hideout_list_search_engines',
			'hideout_list_pages',
			'hideout_list_screen_resolutions',
			'hideout_list_referrers',
			'hideout_list_referring_domains',
			'hideout_list_user_agents',
			'hideout_list_browsers',
			'hideout_list_os',
			'hideout_list_robots'
		);
		foreach( $array as $value )
		{
			$_POST[$value] = trim( $_POST[$value] );
			$_POST[$value] = preg_replace( '/(\r|\n|\r\n)/', '; ', $_POST[$value] );
			$_POST[$value] = preg_replace( '/(; )+$/', '', $_POST[$value] );
			$_POST[$value] = preg_replace( '/(; )+/', '; ', $_POST[$value] );
			chC_set_config( $value, $_POST[$value] );
		}

		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}
	?>
<form method="post" action="index.php?cat=settings&amp;sub=hideout_lists">
	<?php
	if( isset( $msg ) )
	{
		print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
	}
	?>
 <fieldset>
  <legend><?php print $_CHC_LANG['hideout_lists']; ?></legend>
  &nbsp;
  <div style="margin-bottom: 30px;">
   <?php print $_CHC_LANG['description_hideout_lists']; ?>
  </div>
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell" style="vertical-align: top;"><?php print $_CHC_LANG['user_agents:']; ?></td>
    <td style="vertical-align: top;"><textarea name="hideout_list_user_agents" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['hideout_list_user_agents'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['browsers:']; ?></td>
    <td style="vertical-align: top;"><textarea name="hideout_list_browsers" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['hideout_list_browsers'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['operating_systems:']; ?></td>
    <td style="vertical-align: top;"><textarea name="hideout_list_os" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['hideout_list_os'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['robots:']; ?></td>
    <td style="vertical-align: top;"><textarea name="hideout_list_robots" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['hideout_list_robots'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['referrers:']; ?></td>
    <td style="vertical-align: top;"><textarea name="hideout_list_referrers" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['hideout_list_referrers'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['referring_domains:']; ?></td>
    <td style="vertical-align: top;"><textarea name="hideout_list_referring_domains" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['hideout_list_referring_domains'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['pages_(relative_from_hp_root):']; ?></td>
    <td style="vertical-align: top;"><textarea name="hideout_list_pages" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['hideout_list_pages'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['search_engines:']; ?></td>
    <td style="vertical-align: top;"><textarea name="hideout_list_search_engines" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['hideout_list_search_engines'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['search_keywords:']; ?></td>
    <td style="vertical-align: top;"><textarea name="hideout_list_keywords" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['hideout_list_keywords'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['search_phrases:']; ?></td>
    <td style="vertical-align: top;"><textarea name="hideout_list_search_phrases" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['hideout_list_search_phrases'] ); ?></textarea></td>
   </tr>
   <tr>
    <td style="vertical-align: top;"><?php print $_CHC_LANG['screen_resolutions:']; ?></td>
    <td style="vertical-align: top;"><textarea name="hideout_list_screen_resolutions" rows="10" cols="30"><?php print str_replace( '; ', "\n", $_CHC_CONFIG['hideout_list_screen_resolutions'] ); ?></textarea></td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>
	<?php
}
elseif( $_GET['sub'] == 'access_authorisations' )
{
	if( isset( $_REQUEST['submit'] ) )
	{
		$_CHC_CONFIG['statistiken_login_erforderlich'] = '';

		if( isset( $_POST['index'] ) )
		{
			$_CHC_CONFIG['statistiken_login_erforderlich'] .= 'index; index:main; index:pages; index:downloads_and_hyperlinks; index:referrers; index:visitors_details; index:access_statistics; index:all_lists; ';
		}
		elseif( isset( $_POST['index_sub_cat'] ) )
		{
			foreach( $_POST['index_sub_cat'] as $value )
			{
				$_CHC_CONFIG['statistiken_login_erforderlich'] .= 'index:'. $value .'; ';
			}
		}

		if( isset( $_POST['array'] ) )
		{
			foreach( $_POST['array'] as $value )
			{
				$_CHC_CONFIG['statistiken_login_erforderlich'] .= $value .'; ';
			}
		}

		chC_set_config( 'statistiken_login_erforderlich', $_CHC_CONFIG['statistiken_login_erforderlich'] );

		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}
	?>
<form method="post" action="index.php?cat=settings&amp;sub=access_authorisations" name="form_access_authorisations">
 <fieldset>
  <legend><?php print $_CHC_LANG['access_authorisations']; ?></legend>
  &nbsp;
	<?php
	if( isset( $msg ) )
	{
		print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
	}
	?>
  <div style="margin-bottom: 20px;">
  <?php print $_CHC_LANG['description_access_authorisations']; ?>
  </div>
  <div style="margin-bottom: 2px;">
   <div style="float: left; width: 40px;"><input type="checkbox" name="index" id="index" value="index" <?php
	print is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index;' ) ) ? 'checked="checked"' : '';
	?> onClick="if( document.form_access_authorisations.elements['index'].checked == true ) { set_checkboxes( document.form_access_authorisations.elements['index_sub_cat[]'], true ); }" /></div>
   <div><label for="index">stats/index.php</label></div>
  </div>
  <div style="margin-bottom: 2px; clear: left;">
   <div style="float: left; width: 40px; margin-left: 20px;"><input type="checkbox" name="index_sub_cat[]" id="main" value="main" <?php
	print is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index:main;' ) ) ? 'checked="checked"' : '';
	?> /></div>
   <div><label for="main"><?php print $_CHC_LANG['statistics_main_page']; ?></label></div>
  </div>
  <div style="margin-bottom: 2px; clear: left;">
   <div style="float: left; width: 40px; margin-left: 20px;"><input type="checkbox" name="index_sub_cat[]" id="pages" value="pages" <?php
	print is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index:pages;' ) ) ? 'checked="checked"' : '';
	?> /></div>
   <div><label for="pages"><?php print $_CHC_LANG['statistics_pages']; ?></label></div>
  </div>
<?php
if( CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED == TRUE )
{
	?>
  <div style="margin-bottom: 2px; clear: left;">
   <div style="float: left; width: 40px; margin-left: 20px;"><input type="checkbox" name="index_sub_cat[]" id="downloads_and_hyperlinks" value="downloads_and_hyperlinks" <?php
	print is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index:downloads_and_hyperlinks;' ) ) ? 'checked="checked"' : '';
	?> /></div>
   <div><label for="downloads_and_hyperlinks"><?php print $_CHC_LANG['statistics_downloads_and_hyperlinks']; ?></label></div>
  </div>
	<?php
}
?>
  <div style="margin-bottom: 2px; clear: left;">
   <div style="float: left; width: 40px; margin-left: 20px;"><input type="checkbox" disabled="disabled" name="dummy" id="dummy" value="dummy" <?php
	print is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index:referrers;' ) ) ? 'checked="checked"' : '';
	?> /></div>
	<div style="float: left; width: 40px; margin-left: 20px;"><input type="hidden" name="index_sub_cat[]" id="referrers" value="referrers" <?php
	print is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index:referrers;' ) ) ? 'checked="checked"' : '';
	?> /></div>
  <div><label for="referrers"><?php print $_CHC_LANG['statistics_referrers']; ?></label></div>
  </div>
  <div style="margin-bottom: 2px; clear: left;">
   <div style="float: left; width: 40px; margin-left: 20px;"><input type="checkbox" name="index_sub_cat[]" id="visitors_details" value="visitors_details" <?php
	print is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index:visitors_details;' ) ) ? 'checked="checked"' : '';
	?> /></div>
   <div><label for="visitors_details"><?php print $_CHC_LANG['statistics_visitors_details']; ?></label></div>
  </div>
  <div style="margin-bottom: 2px; clear: left;">
   <div style="float: left; width: 40px; margin-left: 20px;"><input type="checkbox" name="index_sub_cat[]" id="access_statistics" value="access_statistics" <?php
	print is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index:access_statistics;' ) ) ? 'checked="checked"' : '';
	?> /></div>
   <div><label for="access_statistics"><?php print $_CHC_LANG['statistics_access_stats']; ?></label></div>
  </div>
  <div style="margin-bottom: 2px; clear: left;">
   <div style="float: left; width: 40px; margin-left: 20px;"><input type="checkbox" name="index_sub_cat[]" id="all_lists" value="all_lists" <?php
	print is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'index:all_lists;' ) ) ? 'checked="checked"' : '';
	?> /></div>
   <div><label for="all_lists"><?php print $_CHC_LANG['all_lists']; ?></label></div>
  </div>
  <div style="margin-bottom: 2px; clear: left;">
   <div style="float: left; width: 40px;"><input type="checkbox" name="array[]" id="online_users" value="online_users" <?php
	print is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'online_users;' ) ) ? 'checked="checked"' : '';
	?> /></div>
   <div><label for="online_users">stats/online_users.php</label></div>
  </div>
  <div style="margin-bottom: 20px; clear: left;">
   <div style="float: left; width: 40px;"><input type="checkbox" name="array[]" id="versions" value="versions" <?php
	print is_int( strpos( $_CHC_CONFIG['statistiken_login_erforderlich'], 'versions;' ) ) ? 'checked="checked"' : '';
	?> /></div>
   <div><label for="versions">stats/versions.php</label></div>
  </div>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>
	<?php
}
elseif( $_GET['sub'] == 'stats_latest_top' )
{
	if( isset( $_POST['submit'] ) )
	{
		chC_set_config(
			array(
				'statistiken_anzahl_top' => (int) $_POST['statistiken_anzahl_top'],
				'wordwrap_top_x' => (int) $_POST['wordwrap_top_x'],

				'statistiken_anzahl_latest' => (int) $_POST['statistiken_anzahl_latest'],
				'wordwrap_latest_x' => (int) $_POST['wordwrap_latest_x']
			)
		);

		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}
	?>
<form method="post" action="index.php?cat=settings&amp;sub=stats_latest_top">
<div style="margin-bottom: 20px;"><?php print $_CHC_LANG['settings_description_latest_top']; ?></div>
<?php
if( isset( $msg ) )
{
	print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
}
?>
 <fieldset>
  <legend><?php print $_CHC_LANG['top_...']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_top" value="<?php print $_CHC_CONFIG['statistiken_anzahl_top']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_top_x" value="'. $_CHC_CONFIG['wordwrap_top_x'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['latest_...']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_latest" value="<?php print $_CHC_CONFIG['statistiken_anzahl_latest']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_latest_x" value="'. $_CHC_CONFIG['wordwrap_latest_x'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>
	<?php
}
elseif( $_GET['sub'] == 'stats_referrers' )
{
	if( isset( $_POST['submit'] ) )
	{
		chC_set_config(
			array(
				'fremde_URLs_verlinken' => isset( $_POST['fremde_URLs_verlinken'] ) ? 1 : 0,

				'statistiken_anzahl_referrer' => (int) $_POST['statistiken_anzahl_referrer'],
				'wordwrap_referrer' => (int) $_POST['wordwrap_referrer'],
				'referrer_kuerzen_nach' => (int) $_POST['referrer_kuerzen_nach'],
				'referrer_kuerzungszeichen' => $_POST['referrer_kuerzungszeichen'],
				'referrer_query_string_entfernen' => isset( $_POST['referrer_query_string_entfernen'] ) ? 1 : 0,

				'statistiken_anzahl_refdomains' => (int) $_POST['statistiken_anzahl_refdomains'],
				'wordwrap_refdomains' => (int) $_POST['wordwrap_refdomains'],

				'statistiken_anzahl_suchmaschinen' => (int) $_POST['statistiken_anzahl_suchmaschinen'],
				'wordwrap_suchmaschinen' => (int) $_POST['wordwrap_suchmaschinen'],

				'statistiken_anzahl_suchwoerter' => (int) $_POST['statistiken_anzahl_suchwoerter'],
				'wordwrap_suchwoerter' => (int) $_POST['wordwrap_suchwoerter'],

				'statistiken_anzahl_suchphrasen' => (int) $_POST['statistiken_anzahl_suchphrasen'],
				'wordwrap_suchphrasen' => (int) $_POST['wordwrap_suchphrasen']
			)
		);

		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}
	?>
<form method="post" action="index.php?cat=settings&amp;sub=stats_referrers">
<div style="margin-bottom: 20px;"><?php print $_CHC_LANG['settings_description_referrers,_search_engines_and_keywords']; ?></div>
<?php
if( isset( $msg ) )
{
	print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
}
?>
 <fieldset>
  <legend><?php print $_CHC_LANG['referrers/referring_domains:common_settings']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><label for="fremde_URLs_verlinken"><?php print $_CHC_LANG['hyperlink_URLs:']; ?></label></td>
    <td><input type="checkbox" name="fremde_URLs_verlinken" id="fremde_URLs_verlinken" value="1" <?php print $_CHC_CONFIG['fremde_URLs_verlinken'] == '1' ? 'checked="checked"' : ''; ?> /></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['referrers']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_referrer" value="<?php print $_CHC_CONFIG['statistiken_anzahl_referrer']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_referrer" value="'. $_CHC_CONFIG['wordwrap_referrer'] .'" />' );
	?></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['abbreviate_referrers_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="referrer_kuerzen_nach" value="'. $_CHC_CONFIG['referrer_kuerzen_nach'] .'" />' );
	?></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['abbreviation_sign:']; ?></td>
    <td><input type="text" name="referrer_kuerzungszeichen" value="<?php print $_CHC_CONFIG['referrer_kuerzungszeichen']; ?>" /></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['referring_domains']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_refdomains" value="<?php print $_CHC_CONFIG['statistiken_anzahl_refdomains']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_refdomains" value="'. $_CHC_CONFIG['wordwrap_refdomains'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['search_engines']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_suchmaschinen" value="<?php print $_CHC_CONFIG['statistiken_anzahl_suchmaschinen']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_suchmaschinen" value="'. $_CHC_CONFIG['wordwrap_suchmaschinen'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['search_keywords']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_suchwoerter" value="<?php print $_CHC_CONFIG['statistiken_anzahl_suchwoerter']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_suchwoerter" value="'. $_CHC_CONFIG['wordwrap_suchwoerter'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['search_phrases']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_suchphrasen" value="<?php print $_CHC_CONFIG['statistiken_anzahl_suchphrasen']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_suchphrasen" value="'. $_CHC_CONFIG['wordwrap_suchphrasen'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>
	<?php
}
elseif( $_GET['sub'] == 'stats_visitors_details' )
{
	if( isset( $_POST['submit'] ) )
	{
		chC_set_config(
			array(
				'statistiken_anzahl_browser' => (int) $_POST['statistiken_anzahl_browser'],
				'wordwrap_browser' => (int) $_POST['wordwrap_browser'],

				'statistiken_anzahl_os' => (int) $_POST['statistiken_anzahl_os'],
				'wordwrap_os' => (int) $_POST['wordwrap_os'],

				'statistiken_anzahl_robots' => (int) $_POST['statistiken_anzahl_robots'],
				'wordwrap_robots' => (int) $_POST['wordwrap_robots'],

				'statistiken_anzahl_user_agents' => (int) $_POST['statistiken_anzahl_user_agents'],
				'wordwrap_user_agents' => (int) $_POST['wordwrap_user_agents'],

				'statistiken_anzahl_aufloesungen' => (int) $_POST['statistiken_anzahl_aufloesungen'],
				'wordwrap_aufloesungen' => (int) $_POST['wordwrap_aufloesungen'],

				'statistiken_anzahl_laender' => (int) $_POST['statistiken_anzahl_laender'],
				'wordwrap_laender' => (int) $_POST['wordwrap_laender'],

				'statistiken_anzahl_hosts_tlds' => (int) $_POST['statistiken_anzahl_hosts_tlds'],
				'wordwrap_hosts_tlds' => (int) $_POST['wordwrap_hosts_tlds'],

				'statistiken_anzahl_sprachen' => (int) $_POST['statistiken_anzahl_sprachen'],
				'wordwrap_sprachen' => (int) $_POST['wordwrap_sprachen']
			)
		);

		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}
	?>
<form method="post" action="index.php?cat=settings&amp;sub=stats_visitors_details">
<div style="margin-bottom: 20px;"><?php print $_CHC_LANG['settings_description_visitors_details']; ?></div>
<?php
if( isset( $msg ) )
{
	print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
}
?>
 <fieldset>
  <legend><?php print $_CHC_LANG['browsers']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_browser" value="<?php print $_CHC_CONFIG['statistiken_anzahl_browser']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_browser" value="'. $_CHC_CONFIG['wordwrap_browser'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['operating_systems']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_os" value="<?php print $_CHC_CONFIG['statistiken_anzahl_os']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_os" value="'. $_CHC_CONFIG['wordwrap_os'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['robots']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_robots" value="<?php print $_CHC_CONFIG['statistiken_anzahl_robots']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_robots" value="'. $_CHC_CONFIG['wordwrap_robots'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['user_agents']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_user_agents" value="<?php print $_CHC_CONFIG['statistiken_anzahl_user_agents']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_user_agents" value="'. $_CHC_CONFIG['wordwrap_user_agents'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['screen_resolutions']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_aufloesungen" value="<?php print $_CHC_CONFIG['statistiken_anzahl_aufloesungen']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_aufloesungen" value="'. $_CHC_CONFIG['wordwrap_aufloesungen'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['countries']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_laender" value="<?php print $_CHC_CONFIG['statistiken_anzahl_laender']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_laender" value="'. $_CHC_CONFIG['wordwrap_laender'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['languages']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_sprachen" value="<?php print $_CHC_CONFIG['statistiken_anzahl_sprachen']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_sprachen" value="'. $_CHC_CONFIG['wordwrap_sprachen'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['hosts_tlds']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_hosts_tlds" value="<?php print $_CHC_CONFIG['statistiken_anzahl_hosts_tlds']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_hosts_tlds" value="'. $_CHC_CONFIG['wordwrap_hosts_tlds'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>
	<?php
}
elseif( $_GET['sub'] == 'stats_pages' )
{
	if( isset( $_POST['submit'] ) )
	{
		chC_set_config(
			array(
				'statistiken_anzahl_seiten' => (int) $_POST['statistiken_anzahl_seiten'],
				'wordwrap_seiten' => (int) $_POST['wordwrap_seiten'],
				'zeige_seitentitel' => isset( $_POST['zeige_seitentitel'] ) ? 1 : 0,

				'show_online_users_ip' => $_POST['show_online_users_ip'],
				'wordwrap_seite_online_users' => (int) $_POST['wordwrap_seite_online_users']
			)
		);

		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}
	?>
<form method="post" action="index.php?cat=settings&amp;sub=stats_pages">
<div style="margin-bottom: 20px;"><?php print $_CHC_LANG['settings_description_pages']; ?></div>
<?php
if( isset( $msg ) )
{
	print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
}
?>
 <fieldset>
  <legend><?php print $_CHC_LANG['pages']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><label for="zeige_seitentitel"><?php print $_CHC_LANG['show_page_title:']; ?></label></td>
    <td><input type="checkbox" name="zeige_seitentitel" id="zeige_seitentitel" value="1" <?php print $_CHC_CONFIG['zeige_seitentitel'] == '1' ? 'checked="checked"' : ''; ?> /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_seiten" value="<?php print $_CHC_CONFIG['statistiken_anzahl_seiten']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_seiten" value="'. $_CHC_CONFIG['wordwrap_seiten'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['currently_online']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td><?php print $_CHC_LANG['online_users_ip_format:']; ?></td>
    <td style="padding-top: 10px; padding-bottom: 10px;">
     <input type="radio" name="show_online_users_ip" value="4" <?php print $_CHC_CONFIG['show_online_users_ip'] == '4' ? 'checked="checked"' : ''; ?> />a.b.c.d<br />
     <input type="radio" name="show_online_users_ip" value="3" <?php print $_CHC_CONFIG['show_online_users_ip'] == '3' ? 'checked="checked"' : ''; ?> />a.b.c.x<br />
     <input type="radio" name="show_online_users_ip" value="2" <?php print $_CHC_CONFIG['show_online_users_ip'] == '2' ? 'checked="checked"' : ''; ?> />a.b.x.x<br />
     <input type="radio" name="show_online_users_ip" value="1" <?php print $_CHC_CONFIG['show_online_users_ip'] == '1' ? 'checked="checked"' : ''; ?> />a.x.x.x<br />
     <input type="radio" name="show_online_users_ip" value="0" <?php print $_CHC_CONFIG['show_online_users_ip'] == '0' ? 'checked="checked"' : ''; ?> /><?php print $_CHC_LANG['do_not_show_IPs']; ?>
    </td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_of_page_name_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_seite_online_users" value="'. $_CHC_CONFIG['wordwrap_seite_online_users'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>
	<?php
}
elseif( $_GET['sub'] == 'logs' )
{
	if( isset( $_POST['submit'] ) )
	{
		chC_set_config(
			array(
				'anzahl_pro_logseite' => intval( $_POST['anzahl_pro_logseite'] ),
				'anordnung_log_eintraege' => $_POST['anordnung_log_eintraege'],
				'logdaten_zeige_seitentitel' => isset( $_POST['logdaten_zeige_seitentitel'] ) ? 1 : 0,
			)
		);
		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}
	?>
<form method="post" action="index.php?cat=settings&amp;sub=logs">
<div style="margin-bottom: 20px;"><?php print $_CHC_LANG['settings_description_logs']; ?></div>
<?php
if( isset( $msg ) )
{
	print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
}
?>
 <fieldset>
  <legend><?php print $_CHC_LANG['logs']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['entries_per_log_page:']; ?></td>
    <td><input type="text" name="anzahl_pro_logseite" value="<?php print $_CHC_CONFIG['anzahl_pro_logseite']; ?>" /></td>
   </tr>
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['display_the_entries_on_each_log_page:']; ?></td>
    <td>
     <select name="anordnung_log_eintraege">
      <option value="ASC" <?php print $_CHC_CONFIG['anordnung_log_eintraege'] == 'ASC' ? 'selected' : ''; ?>><?php print $_CHC_LANG['ascending']; ?></option>
      <option value="DESC" <?php print $_CHC_CONFIG['anordnung_log_eintraege'] == 'DESC' ? 'selected' : ''; ?>><?php print $_CHC_LANG['descending']; ?></option>
     </select>
    </td>
   </tr>
   <tr>
    <td class="options_table_left_cell" style="padding-top: 15px;"><label for="logdaten_zeige_seitentitel"><?php print $_CHC_LANG['show_page_title:']; ?></label></td>
    <td style="padding-top: 15px;"><input type="checkbox" name="logdaten_zeige_seitentitel" id="logdaten_zeige_seitentitel" value="1" <?php print $_CHC_CONFIG['logdaten_zeige_seitentitel'] == '1' ? 'checked="checked"' : ''; ?> /></td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>
	<?php
}
elseif( $_GET['sub'] == 'stats_access' )
{
	if( isset( $_POST['submit'] ) )
	{
		chC_set_config( 'darstellungsart_balkendiagramme_zugriffsstatistiken', $_POST['darstellungsart_balkendiagramme_zugriffsstatistiken'] );
		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}
	?>
<form method="post" action="index.php?cat=settings&amp;sub=stats_access">
<div style="margin-bottom: 20px;"><?php print $_CHC_LANG['settings_description_access_statistics']; ?></div>
<?php
if( isset( $msg ) )
{
	print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
}
?>
 <fieldset>
  <legend><?php print $_CHC_LANG['access_statistics']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['vertical-bar_diagramm_representation:']; ?></td>
    <td>
     <input type="radio" name="darstellungsart_balkendiagramme_zugriffsstatistiken" value="absolut" <?php print $_CHC_CONFIG['darstellungsart_balkendiagramme_zugriffsstatistiken'] == 'absolut' ? 'checked="checked"' : ''; ?> />
      <?php print $_CHC_LANG['description_vertical-bar_diagramm_representation:absolute']; ?><br />
     <input type="radio" name="darstellungsart_balkendiagramme_zugriffsstatistiken" value="relativ" <?php print $_CHC_CONFIG['darstellungsart_balkendiagramme_zugriffsstatistiken'] == 'relativ' ? 'checked="checked"' : ''; ?> />
      <?php print $_CHC_LANG['description_vertical-bar_diagramm_representation:relative']; ?>
    </td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>
	<?php
}
elseif( $_GET['sub'] == 'stats_all_lists' )
{
	if( isset( $_POST['submit'] ) )
	{
		chC_set_config(
			array(
				'statistiken_anzahl_all_lists' => intval( $_POST['statistiken_anzahl_all_lists'] ),
				'wordwrap_all_lists' => intval( $_POST['wordwrap_all_lists'] )
			)
		);
		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}
	?>
<form method="post" action="index.php?cat=settings&amp;sub=stats_all_lists">
<div style="margin-bottom: 20px;"><?php print $_CHC_LANG['settings_description_all_lists']; ?></div>
<?php
if( isset( $msg ) )
{
	print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
}
?>
 <fieldset>
  <legend><?php print $_CHC_LANG['all_lists']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_all_lists" value="<?php print $_CHC_CONFIG['statistiken_anzahl_all_lists']; ?>" /></td>
   </tr>
   <tr>
    <td><?php print $_CHC_LANG['force_wordwrap_after:']; ?></td>
    <td><?php
	print sprintf( $_CHC_LANG['x_signs_(0_=_never)'], '<input type="text" name="wordwrap_all_lists" value="'. $_CHC_CONFIG['wordwrap_all_lists'] .'" />' );
	?></td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>
	<?php
}
elseif( $_GET['sub'] == 'stats_downloads_and_hyperlinks' && CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED == TRUE )
{
	if( isset( $_POST['submit'] ) )
	{
		chC_set_config(
			array(
				'statistiken_anzahl_downloads' => (int) $_POST['statistiken_anzahl_downloads'],
				'statistiken_anzahl_hyperlinks' => (int) $_POST['statistiken_anzahl_hyperlinks']
			)
		);

		$msg = '<b><i>'. $_CHC_LANG['configuration_updated'] .'</i></b>';
	}
	?>
<form method="post" action="index.php?cat=settings&amp;sub=stats_downloads_and_hyperlinks">
<div style="margin-bottom: 20px;"><?php print $_CHC_LANG['settings_description_downloads_and_hyperlinks']; ?></div>
<?php
if( isset( $msg ) )
{
	print '  <div style="margin-bottom: 20px; margin-top: 10px;">'. $msg ."</div>\n";
}
?>
 <fieldset>
  <legend><?php print $_CHC_LANG['downloads']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_downloads" value="<?php print $_CHC_CONFIG['statistiken_anzahl_downloads']; ?>" /></td>
   </tr>
  </table>
 </fieldset>
 <br />
 <br />
 <fieldset>
  <legend><?php print $_CHC_LANG['hyperlinks']; ?></legend>
  &nbsp;
  <table class="options_table">
   <tr>
    <td class="options_table_left_cell"><?php print $_CHC_LANG['number_of_displayed_entries:']; ?></td>
    <td><input type="text" name="statistiken_anzahl_hyperlinks" value="<?php print $_CHC_CONFIG['statistiken_anzahl_hyperlinks']; ?>" /></td>
   </tr>
  </table>
 </fieldset>
 <div class="div_save_settings"><input type="submit" name="submit" value="<?php print $_CHC_LANG['save_settings']; ?> "/></div>
</form>
	<?php
}

?>
</div>