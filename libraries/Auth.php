<?php
namespace Hawalius;
class Auth{
	public static function guest(){
		return isset($_SESSION['user']) == false;
	}
	
	public static function login(){
		global $DB;
		
	}
}