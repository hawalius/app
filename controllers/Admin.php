<?php
namespace Hawalius\Controllers;

require HAWALIUS_PATH . '/app/libraries/Auth.php';
class Admin extends \Hawalius\Controller{
	public function __construct($app = NULL, $view = NULL){
		parent::__construct($app, $view);
		
		$this->view->addFunction('getUser', new \Twig_Function_Function('\\Hawalius\\Auth::get'));
	}

	public function index(){
		if(\Hawalius\Auth::guest()){
			redirect('/admin/login');
		}else{
			redirect('/admin/posts');
		}
	}
	
	public function posts(){
		if(\Hawalius\Auth::guest()){
			redirect('/admin');
		}
		$this->view->render('admin/posts.html');
	}
	
	public function write(){
		
	}
	
	public function manage(){
		
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
	
	public function logout(){
		\Hawalius\Auth::logout();
	}
}