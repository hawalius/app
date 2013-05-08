<?php
namespace Hawalius\Controllers;

require HAWALIUS_PATH . '/app/libraries/Auth.php';
class Admin extends \Hawalius\Controller{
	public function __construct($app = NULL, $view = NULL){
		parent::__construct($app, $view);
		
		$this->view->addFunction('getUser', new \Twig_Function_Function('\\Hawalius\\Auth::get'));
	}

	public function index(){
		$post = $this->app->getModel('post');
		$page = $this->app->getModel('page');
		if(\Hawalius\Auth::guest()){
			redirect('/admin/login');
		}else{
			$totalposts = $post->num();
			$totalpages = $page->num();
			$this->view->render('admin/loggedin.html', array(
				'posts' => array('total' => $totalposts, 'published' => $totalposts),
				'pages' => array('total' => $totalpages, 'published' => $totalpages)
			));
		}
	}
	
	public function posts($type = '', $id = 0){
		if(\Hawalius\Auth::guest()){
			redirect('/admin');
		}
		
		$post = $this->app->getModel('post');
		
		switch($type){
			case 'write':
				if(isset($_POST['title']) && isset($_POST['content'])){
					$url = slug($_POST['title']);
					if($post->write($_POST['title'], $_POST['content'], $url)){
						redirect('/admin/posts');
					}
				}
				$this->view->render('admin/writepost.html');
			break;
			case 'edit':
				$p = $post->single($id);
				if(is_array($p)){
					if(isset($_POST['title']) && isset($_POST['content'])){
						if($post->edit($id, $_POST['title'], $_POST['content'], $p['url'])){
							redirect('/admin/posts');
						}
					}
					
					$this->view->render('admin/editpost.html', array(
						'post' => $p
					));
				}else{
					redirect('/admin/posts/write');
				}
			break;
			
			case 'delete':
				if($id){
					$p = $post->delete($id);
				}
			break;
			
			default:
				$posts = $post->many(0);

				$this->view->render('admin/manage.html', array(
					'posts' => $posts,
					'showPosts' => 1
				));
			break;
		}
		
	}
	
	public function pages($type = '', $id = 0){
		if(\Hawalius\Auth::guest()){
			redirect('/admin');
		}
		
		$page = $this->app->getModel('page');
		
		switch($type){
			case 'write':
				if(isset($_POST['title']) && isset($_POST['content'])){
					$url = slug($_POST['title']);
					if($page->write($_POST['title'], $_POST['content'], $url)){
						redirect('/admin/pages');
					}
				}
				$this->view->render('admin/writepage.html');
			break;
			case 'edit':
				$p = $page->single($id);
				if(is_array($p)){
					if(isset($_POST['title']) && isset($_POST['content'])){
						if($page->edit($id, $_POST['title'], $_POST['content'], $p['url'])){
							redirect('/admin/pages');
						}
					}
					
					$this->view->render('admin/editpage.html', array(
						'post' => $p
					));
				}else{
					redirect('/admin/pages/write');
				}
			break;
			
			case 'delete':
				if($id){
					$p = $page->delete($id);
				}
			break;
			
			default:
				$pages = $page->many(0);

				$this->view->render('admin/manage.html', array(
					'pages' => $pages,
					'showPages' => 1
				));
			break;
		}
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