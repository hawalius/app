<?php
namespace Hawalius;

class CSRF{
	public static function check(){
		if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['token'])){
			$token = $_POST['token'];
			if($token == CSRF::getToken()){
				CSRF::unsetToken();
				return true;
			}else{
				throw new Exception('Invalid CSRF token.');
			}
		}
	}
	
	public static function getToken(){
		if(isset($_SESSION['csrf_token'])){
			return $_SESSION['csrf_token'];
		}
		
		return $_SESSION['csrf_token'] = base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM));
	}
	
	public static function unsetToken(){
		unset($_SESSION['csrf_token']);
	}
}