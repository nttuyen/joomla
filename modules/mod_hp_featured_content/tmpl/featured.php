<ul>
<?php 
foreach ($listContent as $c):
?>

<li>
<h4><a href="index.php/<?php echo $c->id; ?>-<?php echo $c->alias; ?>.html"><?php echo $c->title; ?></a></h4>
<span>
	<?php 
		//$content = strip_tags($c->introtext, '<img>'); 
		//$content = mb_substr($content, 0, 200) . ' ...';
		
		//echo $content;
		
		echo mb_substr( strip_tags($c->introtext, '<img>'), 0, 200) . ' ...';
	?>
</span>
</li>

<?php endforeach; ?>
</ul>
