<?php
namespace Hawalius\Controllers;

require HAWALIUS_PATH . '/app/libraries/Auth.php';
class Admin extends \Hawalius\Controller{
	public function index(){
		if(\Hawalius\Auth::guest()){
			redirect('/admin/login');
		}
		echo 'loggedin';
	}
	public function login(){
		if(!\Hawalius\Auth::guest()){
			redirect('/admin');
		}
		
		if(!isset($_POST['username']) || !isset($_POST['password'])){
			$this->view->render('admin/login.html');
		}else{
			$username = $_POST['username'];
			$password = $_POST['password'];
			if(\Hawalius\Auth::login($username, $password)){
				redirect('/admin');
			}else{
				echo 'Wrong username or password!';
			}
		}
	}
}