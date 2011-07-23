<?php

/*
 **************************************
 *
 * administration/index.php
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

header( 'Content-Type: text/html; charset=UTF-8' );
@ini_set( 'arg_separator.output', '&amp;' );
@session_start();

define( 'CHC_ACP', TRUE );
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
require_once( '../includes/functions.inc.php' );

$_CHC_DB = new chC_mysql( $_CHC_DBCONFIG['server'], $_CHC_DBCONFIG['user'], $_CHC_DBCONFIG['password'], $_CHC_DBCONFIG['database'] );


// Konfiguration einholen
$_CHC_CONFIG = chC_get_config();
$_CHC_CONFIG['lang'] = ( isset( $_POST['action'] ) && $_POST['action'] == "config" ) ? $_POST['lang'] : $_CHC_CONFIG['lang'];



// Sprache/Sprachdateien einbinden
if(
	chC_logged_in() == 'admin'
	&& isset( $_GET['cat'] ) && $_GET['cat'] == 'settings'
	&& ( isset( $_POST['lang_administration'] ) || isset( $_POST['lang_administration'] ) )
  )
{
	$available_languages = chC_get_available_languages( CHC_ROOT .'/languages' ); 
	if( isset( $_POST['lang_administration'] ) && isset( $available_languages[$_POST['lang_administration']] ) )
	{
		chC_set_config( 'lang_administration', $_POST['lang_administration'] );
	}
	if( isset( $_POST['lang'] ) && isset( $available_languages[$_POST['lang']] ) )
	{
		chC_set_config( 'lang', $_POST['lang'] );
	}
}
ob_start();
require( '../languages/'. $_CHC_CONFIG['lang_administration'] .'/lang_config.inc.php' );
require( '../languages/'. $_CHC_CONFIG['lang_administration'] .'/main.lang.php' );
require( '../languages/'. $_CHC_CONFIG['lang_administration'] .'/administration.lang.php' );
ob_end_clean();



function login_form()
{
	global $_CHC_LANG;
	return '  <form method="post" action="index.php">
   <input type="hidden" name="login_form" value="1" />
   <table style="text-align: left; margin-left: auto; margin-right: auto;" border="0" cellpadding="0" cellspacing="0">
    <tr>
     <td style="padding: 0px 0px 2px 0px; width: 200px;">'. $_CHC_LANG['your_user_name:'] .'</td>
     <td style="padding: 0px 0px 2px 0px;"><input type="text" name="login_name" value="'. ( isset( $_POST['login_name'] ) ? $_POST['login_name'] : '' ) .'" /></td>
    </tr>
    <tr>
     <td style="padding: 0px 0px 2px 0px; width: 200px;">'. $_CHC_LANG['your_password:'] .'</td>
     <td style="padding: 0px 0px 2px 0px;"><input type="password" name="login_pw" value="" /></td>
    </tr>
    <tr>
     <td style="padding: 0px 0px 2px 0px; width: 200px;"><label for="login_cookie">'. $_CHC_LANG['set_login_cookie'] .'</label></td>
     <td style="padding: 0px 0px 2px 0px;"><input type="checkbox" name="login_cookie" id="login_cookie" value="1" '. ( isset( $_POST['login_cookie'] ) && $_POST['login_cookie'] == '1' ? 'checked' : '' ) .' /></td>
    </tr>
    <tr>
     <td style="padding-top: 20px; text-align: center;" colspan="2"><input type="submit" value="'. $_CHC_LANG['login_now'] .'" /></td>
    </tr>
   </table>
  </form>';
}


// Logout
if( isset( $_POST['logout'] ) )
{
	chC_logout();
	$logout_attempt = TRUE;
}
else
// Login
{
	$login = chC_manage_login( 'admin_required' );
}


# optionales Cookie zum Blocken des Administrators wenn erforderlich löschen oder setzen
if( chC_logged_in() == 'admin' )
{
	# neue Einstellung gesendet. Da die Einstellungen erst später in vieweditconfig geändert werden, kann nicht $_CHC_CONFIG  mit "alter" Einstellung geprüft werden
	if( isset( $_POST['admin_blocking_cookie_change'] ) )
	{
		if( isset( $_POST['admin_blocking_cookie'] ) )
		{
			# Cookie setzen
			setcookie( 'CHC_COUNT_PROTECTION', 'do_not_count_me', time() + 25920000, '/', $_SERVER['SERVER_NAME'], 0 );		
		}
		else
		{
			# Cookie löschen
			setcookie( 'CHC_COUNT_PROTECTION', 'do_not_count_me', time() - 1, '/', $_SERVER['SERVER_NAME'], 0 );		
		}
	}
	# wenn Cookie aktiviert, bei Login erneuern
	elseif( $_CHC_CONFIG['admin_blocking_cookie'] == '1' && isset( $login ) && $login == 'admin' )
	{
			# Cookie setzen
			setcookie( 'CHC_COUNT_PROTECTION', 'do_not_count_me', time() + 25920000, '/', $_SERVER['SERVER_NAME'], 0 );
	}
}

if( !isset( $_GET['cat'] ) )
{
	$_GET['cat'] = '';
}


$title = '';
switch( $_GET['cat'] )
{
	case 'logs':		$title = ' - '. $_CHC_LANG['logs']; break;
	case 'downloads':	$title = ' - '. $_CHC_LANG['downloads']; break;
	case 'hyperlinks':	$title = ' - '. $_CHC_LANG['hyperlinks']; break;
	case 'news':		$title = ' - '. $_CHC_LANG['news']; break;
	case 'help':		$title = ' - '. $_CHC_LANG['help']; break;
	case 'logout':		$title = ' - '. $_CHC_LANG['logout']; break;
	case 'settings':	$title = ' - '. $_CHC_LANG['settings'];
}
$html_title = 'chCounter - '. $_CHC_LANG['administration'] .$title;
$title = 'chCounter '. $_CHC_CONFIG['script_version'] .' - '. $_CHC_LANG['administration'] .$title;


print '<?xml version="1.0" encoding="UTF-8"?>'."\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title><?php print $html_title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="author" content="Bert Körn & Christoph Bachner" />
  <link rel="stylesheet" type="text/css" href="style.css" />
	<meta name="robots" content="noindex,nofollow" /> 
  <?php
	if( chC_logged_in() == 'admin' )
	{
		print '<script type="text/javascript" src="js.php"></script>' ."\n";
	}
	?>
 </head>
 <body>
  <div class="main_box"<?php print ( $_GET['cat'] == 'logs' || $_GET['cat'] == 'downloads' || $_GET['cat'] == 'hyperlinks' ) ? 'style="width: 100%"' : ''; ?>>
   <div class="header"><b><?php print $title; ?></b></div>
   <div class="main_navigation">
    [<a href="index.php?cat=settings"><?php print $_CHC_LANG['settings']; ?></a>]&nbsp;
<?php if( CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED == TRUE )
{
	?>
    [<a href="index.php?cat=downloads"><?php print $_CHC_LANG['downloads']; ?></a>]&nbsp;
    [<a href="index.php?cat=hyperlinks"><?php print $_CHC_LANG['hyperlinks']; ?></a>]&nbsp;
	<?php
}
?>
    [<a href="index.php?cat=logs"><?php print $_CHC_LANG['logs']; ?></a>]&nbsp;
    [<a href="index.php?cat=help"><?php print $_CHC_LANG['help']; ?></a>]&nbsp;
    [<a href="index.php?cat=news"><?php print $_CHC_LANG['news']; ?></a>]&nbsp;
    [<a href="../stats/index.php"><?php print $_CHC_LANG['statistics']; ?></a>]
<?php
if( chC_logged_in() == 'admin' && ! ( isset( $_GET['action'] ) && $_GET['action'] == 'logout' ) )
{
	print '    &nbsp;[<a href="index.php?action=logout">'. $_CHC_LANG['logout'] ."</a>]\n";
}
?>
   </div>
<?php
if( isset( $_GET['action'] ) && $_GET['action'] == 'logout' && ( chC_logged_in() == 'admin' || isset( $logout_attempt ) ) )
{
	print "   <div class=\"content\" style=\"text-align: center;\">\n";
	if( isset( $_POST['logout'] ) )
	{
		if( chC_logged_in() == FALSE )
		{
			print '<div class="centered_message_box" style="text-align:center;">'.$_CHC_LANG['logout_successful'] ."<br />\n<br />\n<br />\n". login_form() ."</div>\n";
		}
		else
		{
			print '<div class="centered_message_box" style="text-align:center;">'.$_CHC_LANG['logout_not_successful']."</div>\n";
		}
	}
	else
	{
		print "<div class=\"centered_message_box\">\n"
			."<form action='index.php?action=logout' method='post'>\n"
			.$_CHC_LANG['logout_affirmation']."<br />\n<br />\n"
			."<input type='submit' name='logout' value='".$_CHC_LANG['logout']."' />\n"
			."</form>\n</div>\n";
	}
	print "   </div>\n";
}
elseif( chC_logged_in() != 'admin' )
{
	?>
<div class="content" style="text-align: center;">
 <div class="centered_message_box" style="text-align: center;">
<?php
	if( $login == -1 )
	{
		print  '<span style="color: #FF0000;">'. $_CHC_LANG['login_invalid_input'] ."</span><br />\n<br />\n";
	}
	print login_form();
	?>
 </div>
</div>
	<?php
}
else
{
	if( is_dir( '../install/' ) )
	{
		print "<div class=\"centered_message_box\" style=\"text-align: left; margin-top: 0px\">\n". $_CHC_LANG['security_alert_install_directory'] ."\n</div>\n";
	}

	if( $_GET['cat'] != 'settings' )
	{
		print "   <div class=\"content\"";
		if( $_GET['cat'] == 'logs' || $_GET['cat'] == 'downloads' || $_GET['cat'] == 'hyperlinks' )
		{
			print ' style="text-align:center; padding: 20px 0px 20px 0px;"';
		}
		print ">\n";
	}

	switch( $_GET['cat'] )
	{
		case 'settings':	require( 'settings.inc.php' ); break;
		case 'logs':		require( 'logs.inc.php' ); break;
		case 'downloads':	require( 'downloads.inc.php' ); break;
		case 'hyperlinks':	require( 'hyperlinks.inc.php' ); break;
		case 'help':		require( 'help.inc.php' ); break;
		case 'news':		require( 'news.inc.php' ); break;
		default:		print '<div class="centered_message_box" style="text-align: center;">'. $_CHC_LANG['welcome_message']. "</div>\n";
	}

	if( $_GET['cat'] != 'settings' )
	{
		print "   </div>\n";
	}
}
?>
   <div class="footer">&nbsp;</div>
  </div>
 </body>
</html>
