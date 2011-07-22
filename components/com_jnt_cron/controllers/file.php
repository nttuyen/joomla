<?php
/**
 * @version		$Id: controller.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_banners
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

require_once JPATH_COMPONENT.DS.'helpers'.DS.'file.process.php';
require_once JPATH_COMPONENT.DS.'helpers'.DS.'ftp.util.php';
/**
 * Banners Controller
 *
 * @package		Joomla.Site
 * @subpackage	com_banners
 * @since		1.5
 */
class Jnt_CronControllerFile extends JController {
    
    
	public function import() {
		$processor = new FileProcessor("D:\\temp\\testv3.blm");
		$processor->process();
		
		JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
		$table = JTable::getInstance('Cron_Data', 'Jnt_CronTable');
		
		$datas = $processor->getData();
		foreach($datas as $data) {
			$table->bind($data);
			$table->id = 0;
			$table->store();
		}
		
		die;
	}
    
    public function download() {
        $ftp = new FtpUtil(array('host' => 'localhost', 'port' => 21, 'user' => 'nttuyen', 'password' => 'adminpass'));
        var_dump($ftp->connect());
        
        $localFolder = JPATH_ROOT.DS.'tmp';
        var_dump($localFolder);
        
        $remoteFile = 'storage/Magazine/Offline/Desktop/19_DItNqttmqlUpYAaZu5Yj/e7lloFNqDvNRv4Zt8roS.zip';
        var_dump($remoteFile);
        
        var_dump($fileName = $ftp->download($remoteFile, $localFolder));
        
        $zip = new ZipArchive();
        var_dump($zip->open($localFolder.DS.$fileName));
        var_dump($zip->extractTo($localFolder.DS.'xxx'));
        
        die;
    }
}