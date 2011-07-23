<?php

/*
 **************************************
 *
 * administration/help.inc.php
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
	$_GET['sub'] = '';
}

?>
<div class="sub_navigation">
 <div class="subcat_settings" style="border-top: 1px solid #000000;">
 &bull;&nbsp;&nbsp;<a href="index.php?cat=help&amp;sub=contact" <?php print ( $_GET['sub'] != 'php'  && $_GET['sub'] != 'js' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['contact']; ?></a><br />
  &bull;&nbsp;&nbsp;<?php print $_CHC_LANG['obtain_inclusion_code:']; ?><br />
  <ul>
   <li><a href="index.php?cat=help&amp;sub=php" <?php print ( $_GET['sub'] == 'php' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['PHP']; ?></a></li>
   <li><a href="index.php?cat=help&amp;sub=js" <?php print ( $_GET['sub'] == 'js' ) ? 'class="current_subpage"' : ''; ?>><?php print $_CHC_LANG['JavaScript']; ?></a></li>
  </ul>
 </div>
</div>
<div class="content" style="width: 535px; margin-left: auto; margin-right: 15px;">
<?php

if( $_GET['sub'] == 'php' )
{
	if( isset( $_POST['submit'] ) )
	{
		$code = "<?php\n";
		$code .= '$chCounter_status = \''. $_POST['status'] ."';\n";
		$code .= '$chCounter_visible = '. $_POST['visible'] .";\n";
		if( !empty( $_POST['page_title'] ) )
		{
			$code .= '$chCounter_page_title = \''. $_POST['page_title'] ."';\n";
		}
		if( !empty( $_POST['template'] ) )
		{
			$code .= "\$chCounter_template = <<<CHC_TEMPLATE\n". $_POST['template'] ."\nCHC_TEMPLATE;\n";
		}
		$code .= 'include( \''. CHC_ROOT ."/counter.php' );\n";
		$code .= "?>";
	}

	?>
<b><?php print $_CHC_LANG['counter_inclusion_via_PHP']; ?></b><br />
<br />
<?php print $_CHC_LANG['description_php_include_code']; ?><br />
<br />
<span style="color: #FF0000;"><?php print $_CHC_LANG['important:']; ?></span>
<ul>
 <li><?php print $_CHC_LANG['notice_file_extension']; ?><br /></li>
 <li><?php print $_CHC_LANG['notice_individual_template_and_indentation']; ?></li>
</ul>
<br />
<br />
<form name="php" action="index.php?cat=help&amp;sub=php" method="post">
  <fieldset style="margin-left: 0px; border: 0px;">
   <legend><?php print $_CHC_LANG['settings']; ?></legend>
   <div style="float: left; margin: 10px 100px 15px 0px;">
    <input type="radio" name="visible" value="1" <?php print ( isset( $_POST['visible'] ) && $_POST['visible'] == '0' ) ? '' : 'checked'; ?> /> <?php echo $_CHC_LANG['visible']; ?><br />
    <input type="radio" name="visible" value="0" <?php print ( isset( $_POST['visible'] ) && $_POST['visible'] == '0' ) ? 'checked' : ''; ?> /> <?php echo $_CHC_LANG['invisible']; ?>
   </div>
   <div>
    <input type="radio" name="status" value="active" <?php print ( isset( $_POST['status'] ) && $_POST['status'] == 'inactive' ) ? '' : 'checked'; ?> /> <?php echo $_CHC_LANG['active']; ?><br />
    <input type="radio" name="status" value="inactive" <?php print ( isset( $_POST['status'] ) && $_POST['status'] == 'inactive' ) ? 'checked' : ''; ?> /> <?php echo $_CHC_LANG['inactive']; ?>
   </div>
   <div style="clear: left; margin-bottom: 15px;">
    <?php echo $_CHC_LANG['optional_page_title:']; ?> <input type="text" name="page_title" value="<?php print isset( $_POST['page_title'] ) ? $_POST['page_title'] : ''; ?>" />
   </div>
   <?php echo $_CHC_LANG['optional_individual_template:']; ?><br />
   <textarea name="template" cols="60" rows="10"><?php print isset( $_POST['template'] ) ? $_POST['template'] : ''; ?></textarea><br />
   <br />
   <input type="submit" name="submit" value="<?php echo $_CHC_LANG['generate_php_code']; ?>" onClick="get_php_code(); return false;" />
  </fieldset>
  <fieldset style="margin-left: 0px; border: 0px;">
   <legend><?php print $_CHC_LANG['generated_code']; ?></legend>
   <textarea name="code" cols="60" rows="10"><?php print isset( $code) ? $code : ''; ?></textarea>
  </fieldset>
 </form>
	<?php
}
elseif( $_GET['sub'] == 'js' )
{
	if( isset( $_POST['submit'] ) )
	{

		if( $_CHC_CONFIG['aktiviere_seitenverwaltung_von_mehreren_domains'] == '1' )
		{
			chC_evaluate( 'homepage', $aktuelle_homepage_id, $aktuelle_homepage_url );
			$aktuelle_counter_url = chC_get_url( 'counter', $aktuelle_homepage_id );
		}
		else
		{
			$aktuelle_counter_url = $_CHC_CONFIG['default_counter_url'];
		}

		$code = "<script type=\"text/javascript\">\n";
		$code .= "// <![CDATA[\n";
		$code .= "// chCounter\n";
		$code .= "// settings:\n";
		$code .= 'cstatus = "'. $_POST['status'] ."\";\n";
		$code .= 'visible = "'. $_POST['visible'] ."\";\n";
		$code .= 'page_title = "'. $_POST['page_title'] ."\";\n";
		$code .= 'url_of_counter_file = "'. $aktuelle_counter_url ."/counter.php\";\n";
		$code .= "\n////////////////\n";
		$code .= "page_url = unescape( location.href );\n";
		$code .= "referrer = ( document.referrer ) ? document.referrer : \"\";\n";
		$code .= "page_title = ( page_title.length == 0 ) ? document.title : page_title;\n";
		$code .= "document.write( \"<script type=\\\"text/javascript\\\" src=\\\"\" );\n";
		$code .= "document.write( encodeURI( url_of_counter_file + \"?chCounter_mode=js&amp;jscode_version=\" + encodeURIComponent(\"". $_CHC_CONFIG['script_version']."\") + \"&amp;status=\" + cstatus + \"&amp;visible=\" + visible + \"&amp;page_title=\" + document.title) );\n";
		$code .= "document.write( encodeURI( \"&amp;page_url=\" + page_url + \"&amp;referrer=\" + referrer + \"&amp;res_width=\" + screen.width + \"&amp;res_height=\" + screen.height ) + \"\\\"><\/\" + \"script>\" );\n";
		$code .= "// ]]>\n";
		$code .= "</script>\n";
		$code .= "<noscript>\n <object data=\"". $aktuelle_counter_url ."/counter.php?chCounter_mode=noscript\" type=\"text/html\"></object>\n";
		$code .= "</noscript>";
	}
	?>
<b><?php print $_CHC_LANG['counter_inclusion_via_JavaScript']; ?></b><br />
<br />
<?php print $_CHC_LANG['description_js_include_code']; ?><br />
<br />
<span style="color: #FF0000;"><?php print $_CHC_LANG['important:']; ?></span>
<ul>
 <li><?php print $_CHC_LANG['notice_advantages_of_including_with_php']; ?><br /></li>
</ul>
<br />
<br />
<form name="js" action="index.php?cat=help&amp;sub=js" method="post">
  <fieldset style="margin-left: 0px; border: 0px;">
   <legend><?php print $_CHC_LANG['settings']; ?></legend>
   <div style="float: left; margin: 10px 100px 15px 0px;">
    <input type="radio" name="visible" value="1" <?php print ( isset( $_POST['visible'] ) && $_POST['visible'] == '0' ) ? '' : 'checked'; ?> /> <?php echo $_CHC_LANG['visible']; ?><br />
    <input type="radio" name="visible" value="0" <?php print ( isset( $_POST['visible'] ) && $_POST['visible'] == '0' ) ? 'checked' : ''; ?> /> <?php echo $_CHC_LANG['invisible']; ?>
   </div>
   <div>
    <input type="radio" name="status" value="active" <?php print ( isset( $_POST['status'] ) && $_POST['status'] == 'inactive' ) ? '' : 'checked'; ?> /> <?php echo $_CHC_LANG['active']; ?><br />
    <input type="radio" name="status" value="inactive" <?php print ( isset( $_POST['status'] ) && $_POST['status'] == 'inactive' ) ? 'checked' : ''; ?> /> <?php echo $_CHC_LANG['inactive']; ?>
   </div>
   <div style="clear: left; margin-bottom: 15px;">
    <?php echo $_CHC_LANG['optional_page_title:']; ?> <input type="text" name="page_title" value="<?php print isset( $_POST['page_title'] ) ? $_POST['page_title'] : ''; ?>" />
   </div>
   <br />
   <input type="submit" name="submit" value="<?php echo $_CHC_LANG['generate_JavaScript_code']; ?>" onClick="get_js_code(); return false;" />
  </fieldset>
  <fieldset style="margin-left: 0px; border: 0px;">
   <legend><?php print $_CHC_LANG['generated_code']; ?></legend>
   <textarea name="code" cols="60" rows="10"><?php print isset( $code) ? htmlentities( $code ) : ''; ?></textarea>
  </fieldset>
 </form>
	<?php
}
else
{
	print $_CHC_LANG['description_support'];
}
?>

</div>
