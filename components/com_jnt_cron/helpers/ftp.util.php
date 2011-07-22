<?php

class FtpUtil {
    protected $host;
    protected $port;
    protected $user;
    protected $password;
    
    protected $debug;
    protected $ftp;
    
    public function __construct($config = array()) {
        $this->host = isset($config['host']) ? $config['host'] : 'localhost';
        $this->port = isset($config['port']) ? (int)$config['port'] : 21;
        $this->user = isset($config['user']) ? $config['user'] : 'root';
        $this->password = isset($config['password']) ? $config['password'] : '';
        $this->debug = isset($config['debug']) ? $config['debug'] : false;
    }
    
    public function __destruct() {
        if($this->ftp) @ftp_close ($this->ftp);
    }
    
    public function connect() {
        if(!$this->ftp = ftp_connect($this->host, $this->port)) {
            return false;
        }
        if(!ftp_login($this->ftp, $this->user, $this->password)) {
            $this->ftp = false;
            return false;
        }
        
        return true;
    }
    
    public function isConnected() {
        return ($this->ftp != false);
    }
    
    public function download($remoteFile, $localFolder) {
        if(!$this->isConnected()) {
            $this->debug('Ftp is not connected');
            return false;
        }
        if(!is_dir($localFolder)) {
            $this->debug('Local path is not folder');
            return false;
        }
        //if(!@ftp_chdir($this->ftp, $remoteFile)) return false;
        
        $pathToFile = split('/', $remoteFile);
        $fileName = $pathToFile[count($pathToFile) - 1];
        if(!$fileName) {
            $this->debug('Remote file is not valid file');
            return false;
        }
        
        $localFilePath = $localFolder.DIRECTORY_SEPARATOR.$fileName;
        
        if(!ftp_get($this->ftp, $localFilePath, $remoteFile, FTP_BINARY)) {
            $this->debug('Ftp get file error');
            return false;
        }
        return $fileName;
    }
    
    public function downloads($remoteFolder, $localFolder) {
        return true;
    }
    
    protected function debug($msg) {
        if(!$this->debug) return;
        print_r($msg);
    }
}
