<?php
/**
 * @version		$Id: default.php 17130 2010-05-17 05:52:36Z eddieajau $
 * @package		Joomla.Site
 * @subpackage	com_je_faq
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script>
	$(document).ready(function() {
		$("#accordion").accordion({ clearStyle: true, collapsible: true, autoHeight: false, navigation: true });
	});
</script>

<style type="text/css">
<!--
.faq-title {
	font-size: 13px;
	font-weight: bold;
	margin: 5px 0;
}
-->
</style>

<h3>Trợ giúp</h3>

<div id="accordion">
<?php foreach($this->items as $item): ?>
	<h3><a class="faq-title" href="#top"><?php echo $item->name;?></a></h3>
	<div>
		<p>
			<?php 
	echo $item->description; ?>
		</p>
	</div>
<?php endforeach; ?>
</div>
