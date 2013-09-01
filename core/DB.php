<?php
namespace Hawalius;
use PDO;

class DB{

	public static $connected = false;
	private static $debug = true;
	private static $prefix;
	private static $instance;
	
	private function __construct(){} 
	
	private function __clonse(){} 
	
	public static function getInstance(){
		global $config;
		$dsn = sprintf('%s:dbname=%s;host=%s;charset=utf8', $config['db']['type'], $config['db']['database'], $config['db']['host']);
		
		self::$prefix = $config['db']['prefix'];
		
		try{
			self::$connected = true;
			self::$instance = new PDO($dsn, $config['db']['username'], $config['db']['password'], [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_PERSISTENT => true
			]);
		}catch(PDOException $e){
			die('Database is down.');
		}
		return self::$instance; 
	}
	
	public static function prepare($query, $options = array()){
		global $config;
		$instance = self::getInstance();
		
		try{
			$sth = call_user_func_array(array($instance, 'prepare'), array(str_replace('::', self::$prefix, $query), $options));
		}catch(PDOException $e){
			if(self::$debug){
				throw new PDOException($e);
			}
			die('An SQL-error occurred.');
		}
		return $sth;
	}
	
	public static function query($query){
		global $config;
		$instance = self::getInstance();

		try{
			$sth = call_user_func_array(array($instance, 'query'), array(str_replace('::', self::$prefix, $query))); 
		}catch(PDOException $e){
			if(self::$debug){
				throw new PDOException($e);
			}
			die('An SQL-error occurred.');
		}
		return $sth;
	}
	
	final public static function __callStatic($method, $arguments) { 
		$instance = self::getInstance(); 
		
		return call_user_func_array(array($instance, $method), $arguments); 
	}
}
