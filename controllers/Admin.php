<?php
namespace Hawalius\Controllers;

require HAWALIUS_PATH . '/app/libraries/Auth.php';
class Admin extends \Hawalius\Controller{
	public function __construct($app = NULL, $view = NULL){
		parent::__construct($app, $view);
		
		$this->view->addFunction('getToken', new \Twig_Function_Function('\\Hawalius\\CSRF::getToken'));
		$this->view->addFunction('getUser', new \Twig_Function_Function('\\Hawalius\\Auth::get'));
		$this->view->addFunction('getGitRev', new \Twig_Function_Function('getGitRev'));
	}

	public function index(){
		$post = $this->app->getModel('post');
		$page = $this->app->getModel('page');
		
		if(\Hawalius\Auth::guest()){
			redirect('/admin/login');
		}else{
			$totalposts = $post->num();
			$totalpages = $page->num();
			$this->view->render('admin/loggedin.html', [
				'posts' => ['total' => $totalposts, 'published' => $post->numPublished()],
				'pages' => ['total' => $totalpages, 'published' => $page->numPublished()]
			]);
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
					\Hawalius\CSRF::check();
					$url = slug($_POST['title']);
					$author = \Hawalius\Auth::get()['id'];
					if($post->write($_POST['title'], $_POST['content'], $url, $author)){
						redirect('/admin/posts');
					}
				}
				$this->view->render('admin/writepost.html');
			break;
			
			case 'publish':
				if($id){
					if($post->publish($id)){
						redirect('/admin/posts');
					}
				}
			break;
			
			case 'draft':
				if($id){
					if($post->draft($id)){
						redirect('/admin/posts');
					}
				}
			break;
			
			case 'edit':
				$p = $post->single($id);
				if(is_array($p)){
					if(isset($_POST['title']) && isset($_POST['content'])){
						\Hawalius\CSRF::check();
						if($post->edit($id, $_POST['title'], $_POST['content'], $p['url'], $p['author'])){
							redirect('/admin/posts');
						}
					}
					
					$this->view->render('admin/editpost.html', [
						'post' => $p
					]);
				}else{
					redirect('/admin/posts/write');
				}
			break;
			
			case 'delete':
				if(isset($_POST['id'])){
					\Hawalius\CSRF::check();
					$id = $_POST['id'];
					$p = $post->delete($id);
					redirect('/admin/posts');
				}
			break;
			
			default:
				$drafts = $post->drafts();
				$published = $post->published();

				$this->view->render('admin/manage.html', [
					'posts' => ['drafts' => $drafts, 'published' => $published],
					'showPosts' => 1
				]);
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
					\Hawalius\CSRF::check();
					$url = slug($_POST['title']);
					$author = Auth::get()['id'];
					if($page->write($_POST['title'], $_POST['content'], $url, $author)){
						redirect('/admin/pages');
					}
				}
				$this->view->render('admin/writepage.html');
			break;
			
			case 'publish':
				if($id){
					if($page->publish($id)){
						redirect('/admin/pages');
					}
				}
			break;
			
			case 'draft':
				if($id){
					if($page->draft($id)){
						redirect('/admin/pages');
					}
				}
			break;
			
			case 'edit':
				$p = $page->single($id);
				if(is_array($p)){
					if(isset($_POST['title']) && isset($_POST['content'])){
						\Hawalius\CSRF::check();
						if($page->edit($id, $_POST['title'], $_POST['content'], $p['url'], $p['author'])){
							redirect('/admin/pages');
						}
					}
					
					$this->view->render('admin/editpage.html', [
						'post' => $p
					]);
				}else{
					redirect('/admin/pages/write');
				}
			break;
			
			case 'delete':
				if(isset($_POST['id'])){
					\Hawalius\CSRF::check();
					$id = $_POST['id'];
					$p = $page->delete($id);
					redirect('/admin/pages');
				}
			break;
			
			default:
				$drafts = $page->drafts();
				$published = $page->published();

				$this->view->render('admin/manage.html', [
					'pages' => ['drafts' => $drafts, 'published' => $published],
					'showPages' => 1
				]);
			break;
		}
	}
	
	public function settings(){
		$this->view->render('admin/settings.html', [
			'themes' => ['default']
		]);
	}
	
	public function login(){
		if(!\Hawalius\Auth::guest()){
			redirect('/admin');
		}
		
		if(!isset($_POST['username']) || !isset($_POST['password'])){
			$this->view->render('admin/login.html');
		}else{
			\Hawalius\CSRF::check();
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