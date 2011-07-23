<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<script type="text/javascript">

function slideSwitch() {
    var $active = jQuery('#content_slider_slideshow IMG.active');

    if ( $active.length == 0 ) $active = jQuery('#content_slider_slideshow IMG:last');

    // use this to pull the images in the order they appear in the markup
    var $next =  $active.next().length ? $active.next() : jQuery('#content_slider_slideshow IMG:first');

    $active.addClass('last-active');

    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
}

jQuery().ready(function() {
    setInterval( "slideSwitch()", 5000 );
});

</script>
<div id="content-wrap">
    <div id="content_slider_slideshow">
        <?php $i = 0; ?>
        <?php foreach($arrImg as $img): ?>
        <?php if($img): ?>
        <img src="<?php echo $img; ?>" alt="" <?php if($i == 0): ?>class="active"<?php endif; $i ++; ?> width="374" height="208" />
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="latest-right">
    <ul>
    <?php 
    //latest news, part 2
    $i = 0;
    foreach ($latestContent as $c):
    if ($i >= 3):
    ?>
    <li><a href="index.php/<?php echo $c->id; ?>-<?php echo $c->alias; ?>.html"><?php echo $c->title; ?></a></li>
    <?php 
    endif;
    $i++;
    endforeach;
    ?>
    </ul>
    </div>
<div class="tagline">
	<h3><a href="index.php/<?php echo $contentSliderId; ?>-<?php echo $contentSliderAlias; ?>.html"><?php echo $contentSliderTitle; ?></a></h3>
	<p><?php echo $contentSliderDesc; ?></p>
</div>  
<div class="latest-left">
<ul>
<?php 
//latest news, part 1
$i = 0;
foreach ($latestContent as $c):
if ($i < 3):
?>
<li><a href="index.php/<?php echo $c->id; ?>-<?php echo $c->alias; ?>.html"><?php echo $c->title; ?></a></li>
<?php 
endif;
$i++;
endforeach;
?>
</ul>
</div>  
</div>





















