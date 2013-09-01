<?php
namespace Hawalius;

class Config{
	static public $config = array();
	
	static public function init(){
		$stmt = DB::query('SELECT * from ::config');
		$stmt->execute();
		
		while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
			self::$config[$row['name']] = $row['value'];
		}
	}
	
	static public function set($name, $value = ''){	
		self::$config[$name] = $value;	
		
		$stmt = DB::prepare('UPDATE ::config SET value = :value WHERE name = :name');
		
		$stmt->bindParam('name', $name, \PDO::PARAM_STR);
		if(is_int($value)){
			$stmt->bindParam('value', $value, \PDO::PARAM_INT);
		}else{
			$stmt->bindParam('value', $value, \PDO::PARAM_STR);
		}
		$stmt->execute();
	}
}