<?php
class FileProcessor {
	public static $HEADER_DEFINATION = '#HEADER#';
	public static $FIELD_DEFINATION = '#DEFINITION#';
	public static $DATA_DEFINATION = '#DATA#';
	public static $END_DEFINATION = '#END#';
	
	protected $file;
	protected $stream;
	
	protected $version;
	protected $endOfField;
	protected $endOfRow;
	protected $noRows;
	protected $defination;
	protected $data;
	
	public function __construct($file) {
		$this->file = $file;
		
		$this->version = 1;
		$this->endOfField = '';
		$this->endOfRow = "\n";
		$this->noRows = 0;
		$this->defination = array();
		$this->data = array();
	}
	
	public function __destruct() {
	}
	
	public function getFile() {
		return $this->file;
	}
	public function setFile($file) {
		$this->file = $file;
	}
	
	public function getDefination() {
		return $this->defination;
	}
	public function getData() {
		return $this->data;
	}
	
	public function process() {
		if(!$this->processHeader()) return false;
		if(!$this->processDefination()) return false;
		if(!$this->processData()) return false;
		var_dump($this);
		return true;
	}
	
	protected function processHeader() {
		if(!$this->stream = fopen($this->file, 'r')) return false;
		
		$EOF = "\n";
		$ignore = true;
		
		$line = null;
		while($line = stream_get_line($this->stream, 0, $EOF)) {
			$line = trim($line);
			if(empty($line) || ($line != self::$HEADER_DEFINATION && $ignore)) continue;
			if($line[0] == '#' && $line != self::$HEADER_DEFINATION) break;
			$ignore = false;
			
			if(strtolower(substr($line, 0, strlen('Version'))) == 'version') {
				//TODO: version
				$str = split(':', $line);
				$this->version = isset($str[1]) ? (int)trim($str[1]) : 1;
			}
			
			if(strtolower(substr($line, 0, strlen('EOF'))) == 'eof') {
				$str = split(':', $line);
				$eof = isset($str[1]) ? trim($str[1]) : '';
				$eof = trim($eof, "'");
				$this->endOfField = $eof; 
			}
			if(substr($line, 0, strlen('EOR')) == 'EOR') {
				$str = split(':', $line);
				$eor = isset($str[1]) ? trim($str[1]) : '';
				$eor = trim($eor, "'");
				$this->endOfRow = $eor; 
			}
			if(substr($line, 0, strlen('Property Count')) == 'Property Count') {
				$str = split(':', $line);
				$count = isset($str[1]) ? (int)trim($str[1]) : 0;
				$this->noRows = $count; 
			}
		}
		
		fclose($this->stream);
		return true;
	}
	
	protected function processDefination() {
		$this->defination = array();
		if(!$this->stream = fopen($this->file, 'r')) return false;
		
		$line = null;
		while($line = stream_get_line($this->stream, 0, "\n")) {
			$line = trim($line);
			if($line == self::$FIELD_DEFINATION) break;
		}
		$line = trim(stream_get_line($this->stream, 0, $this->endOfRow));
		$line = str_replace($this->endOfField, ';', $line);
		$fields = split(';', $line);
		foreach($fields as $key => $field) {
			if(empty($field)) continue;
			$this->defination[$key] = $field;
		}
		
		fclose($this->stream);
		return true;
	}
	
	protected function processData() {
		$this->data = array();
		if(!$this->stream = fopen($this->file, 'r')) return false;
		
		$line = null;
		while($line = stream_get_line($this->stream, 0, "\n")) {
			$line = trim($line);
			if($line == self::$DATA_DEFINATION) break;
		}
		while($line = stream_get_line($this->stream, 0, $this->endOfRow)) {
			$line = trim($line);
			if($line[0] == '#') break;
			$line = str_replace($this->endOfField, ';', $line);
			$fieldDatas = split(';', $line);
			$row = array();
			foreach($fieldDatas as $key => $value) {
				if(!isset($this->defination[$key])) break;
				$row[$this->defination[$key]] = $value;
			}
			if(count($row) == count($this->defination)){
				array_push($this->data, $row);
			}
		}
		
		fclose($this->stream);
		return true;
	}
}