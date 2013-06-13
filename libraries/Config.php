<?php
namespace Hawalius;

class Config{
	static public $config = array();
	
	static public function init(){
		global $DB;
		$stmt = $DB->query('SELECT * from ::config');
		$stmt->execute();
		
		while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
			self::$config[$row['name']] = $row['value'];
		}
	}
}