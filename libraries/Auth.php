<?php
namespace Hawalius;

require_once HAWALIUS_PATH . '/app/vendor/PasswordLib/lib/PasswordLib/PasswordLib.php';
class Auth{
	public static function guest(){
		return isset($_SESSION['user']) == false;
	}

	public static function get(){
		return isset($_SESSION['user']) ? $_SESSION['user'] : [];
	}

	public static function login($username, $password){
		$query = new SQLQuery('users');
		$crypt = new \PasswordLib\PasswordLib;

		$where = array();
		$where['username'] = $username;

		$user = $query->select('*')
			->where($where)
			->run()
			->fetch();

		if($user && $user['password']){
			$isGood = $crypt->verifyPasswordHash($password, $user['password']);
			if($isGood){
				$_SESSION['user'] = [
					'id' => $user['id'],
					'username' => $user['username'],
					'type' => $user['type']
				];
				return true;
			}
		}
		return false;
	}

	public static function logout(){
		@session_destroy();
		redirect('/admin');
	}
}
