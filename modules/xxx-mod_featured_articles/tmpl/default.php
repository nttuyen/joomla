<?php
/**
 * @version		$Id: default.php 18117 2010-07-13 18:09:01Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	mod_custom
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function() {		
	
	//Execute the slideShow
	slideShow();

});

function slideShow() {

	//Set the opacity of all images to 0
	jQuery('#gallery a').css({opacity: 0.0});
	
	//Get the first image and display it (set it to full opacity)
	jQuery('#gallery a:first').css({opacity: 1.0});
	
	//Set the gallery_caption background to semi-transparent
	jQuery('#gallery .gallery_caption').css({opacity: 0.7});

	//Resize the width of the gallery_caption according to the image width
	jQuery('#gallery .gallery_caption').css({width: jQuery('#gallery a').find('img').css('width')});
	
	//Get the gallery_caption of the first image from REL attribute and display it
	jQuery('#gallery .gallery_content').html(jQuery('#gallery a:first').find('img').attr('rel'))
	.animate({opacity: 0.7}, 400);
	
	//Call the gallery function to run the slideshow, 6000 = change to next image after 6 seconds
	setInterval('gallery()',6000);
	
}

function gallery() {
	
	//if no IMGs have the show class, grab the first image
	var current = (jQuery('#gallery a.show')?  jQuery('#gallery a.show') : jQuery('#gallery a:first'));

	//Get next image, if it reached the end of the slideshow, rotate it back to the first image
	var next = ((current.next().length) ? ((current.next().hasClass('gallery_caption'))? jQuery('#gallery a:first') :current.next()) : jQuery('#gallery a:first'));	
	
	//Get next image gallery_caption
	var gallery_caption = next.find('img').attr('rel');	
	
	//Set the fade in effect for the next image, show class has higher z-index
	next.css({opacity: 0.0})
	.addClass('show')
	.animate({opacity: 1.0}, 1000);

	//Hide the current image
	current.animate({opacity: 0.0}, 1000)
	.removeClass('show');
	
	//Set the opacity to 0 and height to 1px
	jQuery('#gallery .gallery_caption').animate({opacity: 0.0}, { queue:false, duration:0 }).animate({height: '1px'}, { queue:true, duration:300 });	
	
	//Animate the gallery_caption, opacity to 0.7 and heigth to 100px, a slide up effect
	jQuery('#gallery .gallery_caption').animate({opacity: 0.7},100 ).animate({height: '80px'},500 );
	
	//Display the content
	jQuery('#gallery .gallery_content').html(gallery_caption);
	
	
}

</script>
<style type="text/css">
body{
	font-family:arial
}

.clear {
	clear:both
}

#gallery {
	position:relative;
	height:360px;
	overflow: hidden;
    padding-left: 1px;
}
	#gallery a {
		float:left;
		position:absolute;
	}
	
	#gallery a img {
		border:none;
	}
	
	#gallery a.show {
		z-index:500
	}

	#gallery .gallery_caption {
		z-index:600; 
		background-color:#000; 
		color:#ffffff; 
		height:80px;
		position:absolute;
		bottom:0;
	}

	#gallery .gallery_caption .gallery_content {
		margin:5px
	}
	
	#gallery .gallery_caption .gallery_content h3 {
		margin:5;
		margin-bottom: 2px;
		padding:0;
		color:#1DCCEF;
	}	

</style>

<div id="gallery" class="text-align:center">

	<?php foreach($listFeaturedArticles as $key => $article): ?>
	<a href="#" <?php if($key == 0): ?>class="show"<?php endif; ?>>
		<img src="<?php echo $article->images_featured?>" alt="<?php echo $article->title; ?>" width="580" height="360" title="" rel="<h3><?php echo $article->title; ?></h3><?php echo $article->introtext_featured?>" />
	</a>
	<?php endforeach; ?>
	
	<div class="gallery_caption"><div class="gallery_content"></div></div>
</div>
