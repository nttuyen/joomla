<?php
$user = $user = JFactory::getUser();
?>
<ul class="menu" style="padding-left: 10px;">
	
<?php
$Itemid = JRequest::getInt('Itemid');
foreach ($apps as $wedding_app)
{
	if($wedding_app->app_show===0 || $wedding_app->app_show==='0')
		continue;
	$title = empty($wedding_app->app_title) ? $wedding_app->title : $wedding_app->app_title;
?>
	<li style="list-style: disc;">
		<a href="<?php echo JRoute::_($wedding_app->edit_url.'&Itemid='.$Itemid);?>"><span><?php echo $title;?></span></a>
	</li>
<?php
}
?>
	<li style="list-style: disc;">
		<a href="<?php echo JURI::base() . $user->username;?>"><span>Website của tôi</span></a>
	</li>
</ul>
