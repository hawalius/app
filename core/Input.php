<?php
namespace Hawalius;
class Input{
	/**
		* @param string $param Parameter from GET
		* @param string $filter Filter
	**/
	public static function get($param, $filter = FILTER_SANITIZE_STRING){
		return filter_input(INPUT_GET, $param, $filter);
	}

	/**
		* @param string $param Parameter from POST
		* @param string $filter Filter
	**/
	public static function post($param, $filter = FILTER_SANITIZE_STRING){
		return filter_input(INPUT_POST, $param, $filter);
	}

	/**
		* @param string $param Parameter from FILE
	**/
	public static function file($param){
		return array_key_exists($param, $_FILES) ? $_FILES[$param] : false;
	}

	/**
		* @param string $param Parameter from GET or POST
		* @param string $filter Filter
	**/
	public static function all($param){
		if($get = self::get($param)){
			return $get;
		}

		return self::post($param);
	}
}
