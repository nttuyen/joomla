<?php

class Upload
{
	/**
	 * Function to upload multi file
	 * 
	 * @param string 	$field			Field name to upload
	 * @param string 	$uploadPath		Path to upload
	 * @param boolean 	$thumb			Auto generate thumbnail or not
	 * @param string 	$thumbName		If auto generate, this will be used for thumbnail
	 */
	public static function files($field, $uploadPath, $newName = null, $thumb = false, $uploadPathThumbs = null, $thumbName = null)
	{
		$files = JRequest::get('files');
		
		$arrFiles = array();
		
		//rebuild array to re-use function upload::file
		foreach ($files['jform']['error'][$field] as $key => $error)
		{
			if(!$error)
			{
				$arrFiles[$key]['jform']['name'][$field] 		= $files['jform']['name'][$field][$key];
				$arrFiles[$key]['jform']['type'][$field] 		= $files['jform']['type'][$field][$key];
				$arrFiles[$key]['jform']['tmp_name'][$field] 	= $files['jform']['tmp_name'][$field][$key];
				$arrFiles[$key]['jform']['error'][$field] 		= $files['jform']['error'][$field][$key];
				$arrFiles[$key]['jform']['size'][$field] 		= $files['jform']['size'][$field][$key];
			}
		}
		
		$result = array();
		
		foreach ($arrFiles as $key => $file)
		{
			$result[$key] = upload::file($file['jform'], $field, $uploadPath, $newName, $thumb, $uploadPathThumbs, $thumbName);
		}
		
		return $result;
	}
	/**
	 * Function to upload file
	 * 
	 * @param string 	$field			Field name to upload
	 * @param string 	$uploadPath		Path to upload
	 * @param boolean 	$thumb			Auto generate thumbnail or not
	 * @param string 	$thumbName		If auto generate, this will be used for thumbnail
	 */
	public static function file($file, $field, $uploadPath, $newName = null, $thumb = false, $uploadPathThumbs = null, $thumbName = null)
	{
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');		

		//any errors the server registered on uploading
		$fileError = $file['error'][$field];
		if ($fileError > 0)
		{
			switch ($fileError)
			{
				case 1:
					return 'FILE_TO_LARGE_THAN_PHP_INI_ALLOWS' ;

				case 2:
					return 'FILE_TO_LARGE_THAN_HTML_FORM_ALLOWS';

				case 3:
					return 'ERROR_PARTIAL_UPLOAD';

				case 4:
					return 'ERROR_NO_FILE';
			}
		}

		//check for filesize
		$fileSize = $file['size'][$field];
		if($fileSize > 2000000)
		{
			return 'FILE_SIZE_INVALID';
		}

		//check the file extension is ok
		$fileName = $file['name'][$field];
		$uploadedFileNameParts = explode('.',$fileName);
		$uploadedFileExtension = array_pop($uploadedFileNameParts);

		$validFileExts = explode(',', 'jpeg,jpg,png,gif');

		//assume the extension is false until we know its ok
		$extOk = false;

		//go through every ok extension, if the ok extension matches the file extension (case insensitive)
		//then the file extension is ok
		foreach($validFileExts as $key => $value)
		{
			if( preg_match("/$value/i", $uploadedFileExtension ) )
			{
				$extOk = true;
			}
		}

		if ($extOk == false)
		{
			return 'INVALID_EXTENSION';
		}

		//the name of the file in PHP's temp directory that we are going to move to our folder
		$fileTemp = $file['tmp_name'][$field];

		//for security purposes, we will also do a getimagesize on the temp file (before we have moved it
		//to the folder) to check the MIME type of the file, and whether it has a width and height
		$imageinfo = getimagesize($fileTemp);
		
		//print_r($imageinfo); die;

		//we are going to define what file extensions/MIMEs are ok, and only let these ones in (whitelisting), rather than try to scan for bad
		//types, where we might miss one (whitelisting is always better than blacklisting)
		$okMIMETypes = 'image/jpeg,image/pjpeg,image/png,image/x-png,image/gif,image/x-ms-bmp';
		$validFileTypes = explode(",", $okMIMETypes);

		//if the temp file does not have a width or a height, or it has a non ok MIME, return
		if( !is_int($imageinfo[0]) || !is_int($imageinfo[1]) || !in_array($imageinfo['mime'], $validFileTypes) )
		{
			return 'INVALID_FILETYPE';
		}

		//lose any special characters in the filename
		if($newName)
			$fileName = $newName;
		
		$fileName = preg_replace("/[^A-Za-z0-9_.]/", "-", $fileName);

		if(!JFile::upload($fileTemp, $uploadPath . DS . $fileName))
		{
			return 'ERROR_MOVING_FILE';
		}
		else 
		{
			if($thumb)
			{
				//require thumb class
				//require_once('thumbnail.class.php');
				require_once('image.class.php');
				
				/* auto generate thumb */
				//$thumb = new thumbnail($uploadPath . DS . $fileName);
				$thumb = new Image($uploadPath . DS . $fileName);
				
				// generate image_file, set filename to resize
		        //$thumb->size_width($thumbWidth);
		        //$thumb->size_width($thumbHeight);
		        
		        //$thumb->jpeg_quality('100');
		        $thumb->setQuality(100);
		        $thumb->resize(113, 151);
		        
		        if(!$thumbName)
		        	$thumbName = $fileName;
		        	
		        if(!$uploadPathThumbs)
		        	$uploadPathThumbs = $uploadPath . DS . 'thumbs';
		        
		        $thumb->save($uploadPathThumbs . DS . 'thumb_'.$thumbName);
			}
	        
	        return array('result' => 'OK', 'file_name' => $fileName, 'thumb_name' => $thumbName);
		}
	}
}