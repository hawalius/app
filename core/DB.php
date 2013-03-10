<?php
namespace Hawalius;
use PDO;

class DB extends PDO{

	public $connected = false;
	private $debug = true;

	public function __construct(){
		global $config;
		$dsn = sprintf('%s:dbname=%s;host=%s;charset=UTF-8', $config['db']['type'], $config['db']['database'], $config['db']['host']);
		try{
			parent::__construct($dsn, $config['db']['username'], $config['db']['password'], array(
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_PERSISTENT => true
			));
			$this->connected = true;
		}catch(PDOException $e){
			die('Database is down.');
		}
	}
		
	public function prepare($query, $options = array()){
		global $config;
		try{
			$sth = parent::prepare($query, $options);
		}catch(PDOException $e){
			if($this->debug){
				throw new PDOException($e);
			}
			die('An SQL-error occurred.');
		}
		return $sth;
	}
	
	public function query($query, $options = array()){
		global $config;
		try{
			// This works around an stupid PHP issue
			if($options){
				$sth = parent::query($query, $options);
			}else{
				$sth = parent::query($query);
			}
		}catch(PDOException $e){
			if($this->debug){
				throw new PDOException($e);
			}
			die('An SQL-error occurred.');
		}
		return $sth;
	}
}