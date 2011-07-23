<?php

/*
 **************************************
 *
 * administration/js.php
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
@session_start();


define( 'CHC_ROOT', dirname(getcwd() ) );

require_once( '../includes/config.inc.php' );
require_once( '../includes/common.inc.php' );
require_once( '../includes/mysql.class.php' );
require_once( '../includes/functions.inc.php' );

if( chC_logged_in() != 'admin' )
{
	exit;
}

$_CHC_DB = new chC_mysql( $_CHC_DBCONFIG['server'], $_CHC_DBCONFIG['user'], $_CHC_DBCONFIG['password'], $_CHC_DBCONFIG['database'] );

$_CHC_CONFIG = chC_get_config();


if( $_CHC_CONFIG['aktiviere_seitenverwaltung_von_mehreren_domains'] == '1' )
{
	chC_evaluate( 'homepage', $aktuelle_homepage_id, $aktuelle_homepage_url );
	$aktuelle_counter_url = chC_get_url( 'counter', $aktuelle_homepage_id );
}
else
{
	$aktuelle_counter_url = $_CHC_CONFIG['default_counter_url'];
}


?>
function set_checkboxes( array, check )
{
	for( i = 0; i < array.length; i++ )
	{
		array[i].checked = check;
	}
}


function get_php_code()
{
	code = "<" + "?php";

	if( document.php.visible[0].checked == true )
	{
		code += "\n$chCounter_visible = 1;";
	}
	else
	{
		code += "\n$chCounter_visible = 0;";
	}

	if( document.php.status[0].checked == true )
	{
		code += "\n$chCounter_status = 'active';";
	}
	else
	{
		code += "\n$chCounter_status = 'inactive';";
	}

	if( document.php.page_title.value )
	{
		code += "\n$chCounter_page_title = '" + document.php.page_title.value + "';";
	}

	if( document.php.template.value )
	{
		code += "\n$chCounter_template = <<<CHC_TEMPLATE\n" + document.php.template.value + "\nCHC_TEMPLATE;";
	}
	code += "\ninclude( '<?php print addslashes( CHC_ROOT ); ?>/counter.php' );";
	code += "\n?>";
	document.php.code.value = code;
	document.php.code.focus();
}

function get_js_code()
{
	code = "<script type=\"text/javascript\">\n";
	code += "// <![CDATA[\n";
	code += "\/\/ chCounter\n";
	code += "\/\/ settings:\n";
	code += ( document.js.status[1].checked == true ) ? "cstatus = \"inactive\";\n" : "cstatus = \"active\";\n";
	code += ( document.js.visible[1].checked == true ) ? "visible = \"0\";\n" : "visible = \"1\";\n";
	code += "page_title = \"" + ( ( document.js.page_title.value ) ? document.js.page_title.value : "" ) + "\";\n";
	code += "url_of_counter_file = \"<?php print $aktuelle_counter_url; ?>/counter.php\";\n";
	code += "\n\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\n";
	code += "page_url = unescape( location.href );\n";
	code += "referrer = ( document.referrer ) ? document.referrer : \"\";\n";
	code += "page_title = ( page_title.length == 0 ) ? document.title : page_title;\n";
	code += "document.write( \"<script type=\\\"text/javascript\\\" src=\\\"\" );\n";
	code += "document.write( url_of_counter_file + \"?chCounter_mode=js&amp;jscode_version=" + encodeURIComponent("<?php print $_CHC_CONFIG['script_version']; ?>") + "&amp;status=\" + cstatus + \"&amp;visible=\" + visible + \"&amp;page_title=\" + encodeURIComponent( page_title ) );\n";
	code += "document.write( \"&amp;page_url=\" + encodeURIComponent( page_url ) + \"&amp;referrer=\" + encodeURIComponent( referrer ) + \"&amp;res_width=\" + screen.width + \"&amp;res_height=\" + screen.height + \"\\\"><\" + \"\/script>\" );\n";
	code += "// ]]>\n";	
	code += "<\/script>\n";
	code += "<noscript>\n <object data=\"<?php print $aktuelle_counter_url; ?>/counter.php?chCounter_mode=noscript\" type=\"text/html\"" + "><\/object>\n";
	code += "<\/noscript>";
	document.js.code.value = code;
	document.js.code.focus();
}
