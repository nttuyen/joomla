
<style>
*{margin:0; padding: 0}

#container {
float: left;
}

#container ul {
float: left;
list-style: none;
}

#container ul li {
float: left;
}

#container li a {
background:#E20090;
color:#EAFFED;
display:block;
padding:5px 20px;
text-decoration:none;
white-space:nowrap;
text-align:left;
font-weight:bold;
}

#container li a:hover {
background:#EF77CB;
color:#3F3F3F;
width:auto;
}

#container li ul{
background:#E20090;
position: absolute;
display: none;
width: 160px;
z-index:9999;
}


#container li:hover ul{
display: block;
}

#container ul li ul li {
width: 160px;
}
#container ul li ul li a{
	font-weight:normal;
	}

</style>

<ul id="top-nav">
	<li><a href="index.php" class="active"><span class="active">Trang chủ</span></a></li>
	<li><a href="#"><span>Thiệp cưới</span></a></li>
	<li><a href="<?php echo JURI::base(); ?>faq.html"><span>Trợ giúp</span></a></li>
	<li><a href="#"><span>Liên hệ</span></a></li>
</ul>
<div style="background:#E20090; overflow:hidden;">
<div id="container">
<ul id="jsddm" class="list-catex">
	<?php foreach($listCategories as $c): ?>
	<li>
		<a href='<?php echo JURI::base(); ?>index.php/news/<?php echo $c->id; ?>-<?php echo isset($c->alias) ? $c->alias : mainHelper::convertUnicode($c->title); ?>.html'>
			<?php echo $c->title; ?>
		</a>
		
		<?php if($c->subCategories): ?>
        
		<ul>
		<?php foreach ($c->subCategories as $sub): ?>
			<li><a href='<?php echo JURI::base(); ?>index.php/news/<?php echo $sub->id; ?>-<?php echo $sub->alias; ?>.html'><?php echo $sub->title; ?></a></li>
		<?php endforeach; ?>
		</ul>
        
		<?php endif; ?>
	</li>
	<?php endforeach; ?>
</ul>
</div></div>
