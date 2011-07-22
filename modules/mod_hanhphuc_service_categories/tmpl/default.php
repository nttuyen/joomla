<?php
/**
 * @version		$Id: default.php 20899 2011-03-07 20:56:09Z ian $
 * @package		Joomla.Site
 * @subpackage	mod_login
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
if(empty($items)) return;
$count = count($items);
$firstLevel = $items[0]->level;
?>
<div class="mod-hanhphuc-service-categories<?php echo $class_sfx?>">
	<!-- <h2>User menu</h2> -->
	<ul>
	<?php
	$output = ''; 
	for($i = 0; $i < $count; $i++) {
		$item = $items[$i];
		$output .= '<li>'."\n";
		$output .= '<a href="'.JRoute::_('index.php?option=com_jnt_hanhphuc&view=services&id='.$item->id).'">'.$item->title.'</a>'."\n";
		//Dong </li> neu phan tu tiep theo ngang hang
		if($i == $count - 1 || $items[$i+1]->level <= $item->level) {
			$output .= '</li>'."\n";
		} 
		//Mo <ul> neu phan tu tiep theo la sub
		if($i < $count - 1 && $items[$i+1]->level > $item->level) {
			$output .= '<ul>'."\n";
		}
		//Dong </ul> neu phan tu tiep theo la parent
		$nextLevel = isset($items[$i+1]) ? $items[$i+1]->level : $firstLevel;
		while($nextLevel < $item->level) {
			$output .= '</ul></li>'."\n";
			$nextLevel++;
		}
	}
	//var_dump($output);
	echo $output;
	?>	
	</ul>
</div>


