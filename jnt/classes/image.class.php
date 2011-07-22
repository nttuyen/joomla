<?php
/**
 * 
 * Example
 
$image = new Image('images/page21.jpg');
$image->setQuality(100);
$image->resize(113, 151);
$image->save('images/page21s-thumb.jpg' );
$image->output();
*/


class Image {
   
	private $image;
	
	private $info;	
   	
   	private $filePath;
   	
   	private $quality = 100;
   
   	public function __construct($filePath) {
   		$this->filePath		= $filePath;
   		$this->info 		= $this->getInfo();
   		$this->createImage();
   	}
   	
   	public function setQuality($quality) {
   		$this->quality = $quality;
   	}
   	
   	public function getQuality() {
   		if (empty($this->quality)) {
   			return 95;
   		} else {
   			if ($this->quality < 0 || $this->quality > 100) {
   				return 95;
   			}
   			return $this->quality;
   		}
   	}
   	
	public function getWidth() {
    	return imagesx($this->image);
   	}
   
   	public function getHeight() {
    	return imagesy($this->image);
   	}
   	
   	public function getInfo() {
   		$details = FALSE;
	  	$data = getimagesize($this->filePath);
	
	  	if (isset($data) && is_array($data)) {
	    	$extensions = array('1' => 'gif', '2' => 'jpg', '3' => 'png');
	    	$extension 	= isset($extensions[$data[2]]) ?  $extensions[$data[2]] : '';
	    	$details 	= array(
	      		'width'     => $data[0],
	      		'height'    => $data[1],
	      		'extension' => $extension,
	    		'image_type' => $data[2],
	      		'mime_type' => $data['mime'],
	    	);
	  	}	
	  	return $details;
   	}
   	
   	public function createImage() {
   		   			
   		switch ($this->info['image_type']) {
   			case IMAGETYPE_JPEG:
   				$this->image = imagecreatefromjpeg($this->filePath);
   				break;
   			case IMAGETYPE_GIF:
   				$this->image = imagecreatefromgif($this->filePath);
   				break;
   			case IMAGETYPE_PNG:
   				$this->image = imagecreatefrompng($this->filePath);
   				break;
   		}
   		
   	}  
   
   	public function save($save = null, $destroy = false, $permissions = null) {
   		
   		if (empty($save)) 
   			$save = strtolower("./thumb.".$this->info["extension"]);
   			
   		$quality = $this->getQuality();
   		
   		clearstatcache();
   		
   		switch ($this->info['image_type']) {
   			case IMAGETYPE_JPEG:
   				imagejpeg($this->image, $save, $quality);
   				break;
   			case IMAGETYPE_GIF:
   				imagegif($this->image, $save);
   				break;
   			case IMAGETYPE_PNG:
   				imagepng($this->image, $save, $quality);
   				break;
   		}
      	   
      	if( $permissions != null) {
        	chmod($save, $permissions);
      	}
      	
      	if ($destroy === true)
	      	imagedestroy($this->image);
      
   	}
   
   	public function output() {
   		
   		@Header("Content-Type: " . $this->info['mime_type']);
   		
   		switch ($this->info['image_type']) {
   			case IMAGETYPE_JPEG:
   				imagejpeg($this->image);
   				break;
   			case IMAGETYPE_GIF:
   				imagegif($this->image);
   				break;
   			case IMAGETYPE_PNG:
   				imagepng($this->image);
   				break;
   		}
   	}
   	
	function resize($width, $height) {
    	$newImage = $this->createImageTmp($width, $height);      
      	imagecopyresampled($newImage, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      	$this->image = $newImage;
   }
   
	public function createImageTmp($width, $height) {
		$res	= imagecreatetruecolor($width, $height);
		$image 	= $this->image;
	  	if ($image->info['extension'] == 'gif') {
	  		// Grab transparent color index from image resource.
	    	$transparent = imagecolortransparent($image->resource);
	
	    	if ($transparent >= 0 && $transparent < imagecolorstotal($image->resource)) {
	      		// 	The original must have a transparent color, allocate to the new image.
	      		$transparent_color = imagecolorsforindex($image->resource, $transparent);
	      		$transparent = imagecolorallocate($res, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
	
	      		// Flood with our new transparent color.
	      		imagefill($res, 0, 0, $transparent);
	      		imagecolortransparent($res, $transparent);
	    	}
	  	} elseif ($image->info['extension'] == 'png') {
		    imagealphablending($res, FALSE);
		    $transparency = imagecolorallocatealpha($res, 0, 0, 0, 127);
		    imagefill($res, 0, 0, $transparency);
		    imagealphablending($res, TRUE);
		    imagesavealpha($res, TRUE);
	  	} else {
	    	imagefill($res, 0, 0, imagecolorallocate($res, 255, 255, 255));
	  	}
	  	return $res;
	}     
}
?>