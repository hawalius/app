<?php
namespace Hawalius\Controllers;

require HAWALIUS_PATH . '/app/libraries/Auth.php';
class Admin extends \Hawalius\Controller{
	public function index(){
		if(\Hawalius\Auth::guest()){
			redirect('/admin/login');
		}
	}
	public function login(){
		if(!isset($_SERVER['PHP_AUTH_USER'])){
			header('WWW-Authenticate: Basic realm="Hawalius"');
			http_response_code(401);
		}else{
			if(\Hawalius\Auth::login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])){
				redirect('/admin');
			}else{
				echo 'Wrong username or password!';
			}
		}
	}
}