<?php
/**
 * Helper class, this class will provide helper function for COM, e.g. upload, echo query ...
 * (Singleton design pattern)
 *
 * @package FCAT
 * @version 1.0.0
 * @author muinx
 * @date 19/08/2009
 */

class mainHelper {
    function __construct() {
        //construct helper
    }
    
    /**
     * singleton design pattern
     *
     */
    function & getInstance() {
        static $instance;
        
        if (!isset($instance)) {
            $c = __CLASS__;
            $instance = new $c;
        } // if
        
        return $instance;
    } // getInstance
    
    function displayChildCate($arrCate = null, $times = 0)
    {
        if ($arrCate != null || !empty($arrCate))
        {
            foreach ($arrCate as $key => $cate)
            {
                $childClass = ($times == 1)? 'child-level_1': 'child-level_0';
                    
                echo '<div class="'. $childClass. ' child_of_'.$cate->parent_id.'">';
                echo '<a href="index.php?option=com_fcat&view=category&cid='. $cate->category_id. '">'. $cate->category_name. '</a>';
                
                if (!empty($cate->child)) {
                    self::displayChildCate($cate->child, 1);
                }
                    
                echo '</div>';
                
            } #for
        } # if 
    }
    
    function getCategories($parentId=0, $id = null, $limitstart=0, $limit=0)
    {
        static $cate = array();
        $db = JFactory::getDBO();
        $query = "SELECT parent_id, category_id, category_name FROM #__fcat_category WHERE published=1 AND parent_id='$parentId' ORDER BY ordering";

        $db->setQuery($query);
        $result = $db->loadObjectList();
        
        foreach($result as $key => &$obj)
        {
            
            if(($obj->category_id == $id || $obj->parent_id == $id) && $id > 0)
                continue;
            $obj->child = self::getCategories($obj->category_id, $id, $limitstart, $limit);
        }
        return $result;
    }
    /**
     * Function return byte from file size
     *
     * @param string $val
     * @return string
     */
    function return_bytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val) - 1]);
        
        switch ($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        
        return $val;
    }
    
    /**
    * Function to eval html string
    * 
    * @param mixed $string
    * @return string that eval
    * 
    * @example 
    * $contents = "<?php for(\$i=0; \$i<10; \$i++) { ?> <div>here is html</div> <?php } ?>";
    * echo eval_html($contents);
    */
    function evalHtml($string) 
    {

        $string = preg_replace("/\?>(.*?)(<\?php|<\?)/si", "echo \"\\1\";",$string);
        $string = str_replace("<?php", "", $string);
        $string = str_replace("?>", "", $string);

        return eval($string);
    }
    
    /**
    * Function to exec query, return true if no error
    * 
    * @param mixed $db
    * @param mixed $query
    * @muinx
    */
    public function doQuery($query='', $queryBatch = false)
    {
    	$db = JFactory::getDbo();
    	
        $db->setQuery($query);
        
        if($queryBatch)
            $db->queryBatch($abortOnError = true);
        else
            $db->query();
        
        if($db->getErrorNum())
        {
            JError::raiseWarning($db->getErrorNum(), 'ERROR: '.$db->getErrorMsg());
            return false;
        }
        
        return true;
    }
    
    /**
    * Function to exec query, return db obj result
    * 
    * @param mixed $db
    * @param mixed $query
    * @muinx
    */
    public function getDbObjResult($query='', $pagination = null)
    {
    	$db = JFactory::getDbo();
    	
        if(!isset($pagination))
        {
            $pagination = new stdClass();
            $pagination->limitstart = 0;
            $pagination->limit = 0;
        }
        
        $db->setQuery($query, $pagination->limitstart, $pagination->limit);
        $result = $db->loadObjectList();
        
        if($db->getErrorNum())
        {
            JError::raiseWarning($db->getErrorNum(), 'ERROR: '.$db->getErrorMsg());
            return;
        }
        return $result;
    }
    
    function removeRecs($cids = null, $table, $key) 
    {
        
        $query = "DELETE FROM ".$table." WHERE ".$key." IN ( $cids )";

        $this->_db->setQuery($query);
        $this->_db->query();

        $errNo = mysql_errno();

        $msg = $this->_db->getErrorMsg();

        return $msg;
    }
    
    
    /**
     * Function upload
     *
     * @param mixed $file - $_FILES
     * @param mixed $filename - file name will be stored
     * @param mixed $pathUpload - path to upload file
     * @param mixed $isUploadImage - true if upload image, other, it will be false
     * @param mixed $allowed_exts - allow extension (array)
     * @author muinx - 20/08/2009
     */
    function upload($file, $filename, $pathUpload, $isUploadImage = true, $allowed_exts = null) {
        global $mainframe;
        
        $maxUploadSize = fCatHelper::return_bytes(ini_get('upload_max_filesize')); //bytes
        
        if ($file['size'] > $maxUploadSize) {
            JError::raiseNotice(100, JText::_('Error. File size is too large. Please upload file is smaller than '.ini_get('upload_max_filesize')));
            return;
        }
        
        $format = 'html';
        $uploadOk = false;
        
        if (!$file['name'])
            return;
        
        // Set FTP credentials, if given
        jimport('joomla.client.helper');
        JClientHelper::setCredentialsFromRequest('ftp');
        $FTPOptions = JClientHelper::getCredentials('ftp');
        
        // Make the filename safe
        jimport('joomla.filesystem.file');
        $file['name'] = JFile::makeSafe($file['name']);
        
        if (isset($file['name']) && ! empty($file['name'])) {
            $ext = strtolower(JFile::getExt($file['name']));
            if (!$allowed_exts) {
                $allowed_exts = array(0=>"jpg", 1=>"jpeg", 2=>"png", 3=>"bmp", 4=>"gif", 5=>"swf", 6=>"flv");
            }

            
            if ($ext == "" || in_array($ext, $allowed_exts, true)) {
                $filepath = JPath::clean($pathUpload.$filename.'.'.$ext);
                
//                if (file_exists($pathUpload.$filename.'.'.$ext))
//                    JFile::delete($pathUpload.$filename.'.'.$ext);
                
                if (JFile::exists($filepath)) {
                    JError::raiseNotice(100, JText::_('Error. File already exists'));
                }
                
                if (JFile::upload($file['tmp_name'], $filepath) == false && $FTPOptions['enabled'] != 1) {
                    JError::raiseWarning(100, JText::_("Error. {$filepath} Unable to upload file"));
                } else {
                    $uploadOk = true;
                    $msg = 'Upload complete';
                    
                    $mainframe->enqueueMessage(JText::_($msg));
                }
            } else {
                JError::raiseNotice(100, JText::_('Upload failed. File extensions restricted'));
            }
        }//end if
        /*
        if ($uploadOk && $isUploadImage) {
            require_once JPATH_COMPONENT.'/components/phpthumb/ThumbLib.inc.php';
            
            try {
                //$thumb = PhpThumbFactory::create(JPath::clean($pathUpload.$filename.'.'.$ext));
                $options['jpegQuality'] = fcatConfigs::_('image.jpeg_quality');
                //$thumb = PhpThumbFactory::create($filepath, $options);
            
            }
            catch(Exception $e) {
                // handle error here however you'd like
                die("ERROR CREATE THUMB");
            }
            
            $maxAllow = explode('###', fcatConfigs::_('image.max_allow'));
            
            //$thumb->resize($maxAllow[0], $maxAllow[1]);
            
            //$new_image = $thumb->saveForce($filepath);
            
            // This may have problem if directory permission is 644 instead of 755
            JFile::write($filepath, $new_image);
        }
        */
        return $filename.'.'.$ext;
    }
	
    /**
    * Function to generate random string
    * 
    * @param mixed $length
    * @author - copy from internet
    */
	function generateString($length = 8) 
    {
	    // start with a blank password
	    $rand_string = "";
	    
	    // define possible characters
	    $possible = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_";
	    
	    // set up a counter
	    $i = 0;
	    
	    // add random characters to $rand_string until $length is reached
	    while ($i < $length) {
	        // pick a random character from the possible ones
	        $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
	        
	        // we don't want this character if it's already in the password
	        if (!strstr($rand_string, $char)) {
	            $rand_string .= $char;
	            $i++;
	        }
	    }
	    
	    // done!
	    return $rand_string;
	}
    
    function readXml($data = null)
    {
        if(!is_object('XMLParser'))
            require_once('xml.class.php');
        
        //get content
        $xmlContent = new XMLParser;
        $xmlContent->xml_data = $data;

        //$xmlContent->xml_attr_varname = "xml_attr";
        //$xmlContent->xml_data_varname = "xml_data";

        //set encoding
        $xmlContent->xml_encoding = "utf-8";

        //parse xml
        $result = $xmlContent->Parse();
        
        return $result;
    }
    
    /**
    * Display flash (swf, flv)
    * 
    * @param mixed $filePath the path to video file
    * @param mixed $width 
    * @param mixed $height
    * @return mixed
    */
    function flashPlayer($filePath = '', $width = 100, $height = 100, $display = '')
    {
        $player = JURI::root().'administrator/components/com_fcat/components/flowplayer/flowplayer-3.1.5.swf';
        if (intval($width) == 0 || intval($height) == 0) 
            $width = $height = '100%'; 
        $html = '
            <object class="fcat-flowplayer" width="'. $width. '" height="'. $height. '" type="application/x-shockwave-flash" data="'. $player .'">
                <param value="true" name="allowfullscreen"/>
                <param value="always" name="allowscriptaccess"/>
                <param value="high" name="quality"/>
                <param value="false" name="cachebusting"/>
                <param value="#000000" name="bgcolor"/>
                <param value=\'config={
                    "clip":{"url":"'. $filePath. '", "autoPlay": false},
                    "playlist":[{"url":"'. $filePath. '"}],
                    "autoBuffering": false
                }\' name="flashvars"/>
            </object>
            '; 
        return $html; 
    }
    /**
     * get file to download
     * @param $file path to file
     */
    function getFile($file)
    {
		    header("Content-type: application/force-download");
		    header("Content-Transfer-Encoding: Binary");
		    header("Content-length: ".filesize($file));
		    header("Content-disposition: attachment; filename=\"".basename($file)."\"");
    }
    
    function convertUnicode($string)
    {
        
        $unicodeChar 	= 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ|é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|ó|ò|ỏ|õ|ọ|ơ|ớ|ờ|ở|ỡ|ợ|ô|ố|ồ|ổ|ỗ|ộ|ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|í|ì|ỉ|ĩ|ị|ý|ỳ|ỷ|ỹ|ỵ|đ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ|Ó|Ò|Ỏ|Õ|Ọ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự|Í|Ì|Ỉ|Ĩ|Ị|Ý|Ỳ|Ỷ|Ỹ|Ỵ|Đ';
        $latinChar	= 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|e|e|e|e|e|e|e|e|e|e|e|o|o|o|o|o|o|o|o|o|o|o|o|o|o|o|o|o|u|u|u|u|u|u|u|u|u|u|u|i|i|i|i|i|y|y|y|y|y|d|A|A|A|A|A|A|A|A|A|A|A|A|A|A|A|A|A|E|E|E|E|E|E|E|E|E|E|E|O|O|O|O|O|O|O|O|O|O|O|O|O|O|O|O|O|U|U|U|U|U|U|U|U|U|U|U|I|I|I|I|I|Y|Y|Y|Y|Y|D';
        
        $arrUnicodeChar 	= explode("|", $unicodeChar);
        $arrLatinChar		= explode("|", $latinChar);
        $string = str_replace($arrUnicodeChar, $arrLatinChar, $string);
        
        $arrSearch = array(" ", "'", '"', ".", ",", "!", "@", "#", '$', '%', '^', '&', '*', '(', ')', '?');
        $arrReplace = array("-","","","","","","","","","","","","","","", '');
        
        $string = str_replace($arrSearch, $arrReplace, $string);
        
        return ucfirst($string);
    }
}

