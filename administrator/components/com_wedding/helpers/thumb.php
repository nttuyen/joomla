<?php
class manThumb
{
	public static $_allowMime = array('image/png', 'image/jpeg', 'image/gif');
	public static $_maxWidth = 3072;
	public static $_maxHeight = 3072;
	public static $_e_mime = 4110;
	public static $_e_size = 4111;
	public static $_e_src = 4112;
	
	function resize($file, $width = 0, $height = 0, $adaptive = false)
	{
		$imgInfo = getimagesize($file);	
		if( !in_array($imgInfo['mime'], self::$_allowMime) )
		{
			throw new Exception('MIME '.$imgInfo['mime'].' is not allowed', self::$_e_mime);
			return;
		}
		
		/*
		if($imgInfo[0] > self::$_maxWidth || $imgInfo[1] > self::$_maxHeight)
		{
			throw new Exception("Image size is too big. Allow image size is ".self::$_maxWidth."x".self::$_maxHeight.". Uploaded image size is {$imgInfo[0]}x{$imgInfo[1]}", self::$_e_size);
			return;
		}
		*/
		
		if($imgInfo[0] <= 0 || $imgInfo[1] <= 0)
		{
			throw new Exception('Uploaded Image size is invalid, please try again', self::$_e_src);
			return ;
		}		
		
		if($imgInfo['mime']=='image/jpeg')
		{
			$gd = imagecreatefromjpeg($file);
		}
		else if($imgInfo['mime']=='image/png')
		{
			$gd = imagecreatefrompng($file);
		}
		else if($imgInfo['mime']=='image/gif')
		{
			$gd = imagecreatefromgif($file);
		}
		
		if($width<=0 && $height <= 0)
		{
			return $gd;
		}		
		else if($width > 0 && $height <= 0)
		{
			$p = & self::widthResize($gd, $width, $imgInfo[0], $imgInfo[1]);
		}
		else if($width <= 0 && $height > 0)
		{
			$p = & self::heightResize($gd, $height, $imgInfo[0], $imgInfo[1]);
		}
		else if($width > 0 && $height > 0 && $adaptive)
		{
			$p = & self::adaptiveResize($gd, $width, $height, $imgInfo[0], $imgInfo[1]);
		}
		else
		{
			$p = self::resizeAndCrop($gd, $width, $height, $imgInfo[0], $imgInfo[1]);
		}
		return $p;		
	}
	
	private function adaptiveResize($gd, $width, $height, $src_width, $src_height)
	{
		$dest = imagecreatetruecolor($width, $height);
		imagecopyresampled($dest, $gd, 0, 0, 0, 0, $width, $height, $src_width, $src_height);
		return $dest;
	}
	
	private function widthResize($gd, $width, $src_width, $src_height)
	{
		if($width > $src_width) return $gd;
		
		$ratio = (float)($width/$src_width);
		$height = (int)($ratio*$src_height);
		
		$dest = imagecreatetruecolor($width, $height);
		imagecopyresampled($dest, $gd, 0, 0, 0, 0, $width, $height, $src_width, $src_height);
		return $dest;
	}
	
	private function heightResize($gd, $height, $src_width, $src_height)
	{
		if($height > $src_height) return $gd;
		
		$ratio = (float)($height/$src_height);
		$width = (int)($ratio*$src_width);
		
		$dest = imagecreatetruecolor($width, $height);
		imagecopyresampled($dest, $gd, 0, 0, 0, 0, $width, $height, $src_width, $src_height);
		return $dest;
	}
	
	private function resizeAndCrop($gd, $width, $height, $src_width, $src_height)
	{
		if($width > $src_width && $height > $src_height) return $gd;
		
		$w_ratio = (float)($width/$src_width);
		$h_ratio = (float)($height/$src_height);
		$w = true;
		
		if($w_ratio > $h_ratio)
		{
			$resize_w = $width;
			$resize_h = $w_ratio*$src_height;
		}
		else
		{
			$w = false;
			$resize_h = $height;
			$resize_w = $h_ratio*$src_width;
		}
		
		$r = imagecreatetruecolor($resize_w, $resize_h);
		imagecopyresampled($r, $gd, 0, 0, 0, 0, $resize_w, $resize_h, $src_width, $src_height);

		$p = imagecreatetruecolor($width, $height);
		if($w)
		{
			$src = (int)( ($resize_h-$height) / 2 );
			imagecopyresampled($p, $r, 0, 0, 0, $src, $width, $height, $width, $height);
		}
		else
		{
			$src = (int)( ($resize_w-$width) / 2 );
			imagecopyresampled($p, $r, 0, 0, $src, 0, $width, $height, $width, $height);
		}		
		return $p;
	}
}
