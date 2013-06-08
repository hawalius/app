<?php
namespace Hawalius\Controllers;

class Index extends \Hawalius\Controller{
	public function index($url = ''){
		$post = $this->app->getModel('post');
		$page = $this->app->getModel('page');
		
		$this->view->render('posts.html', [
			'posts' => $post->many(),
			'pages' => $page->many()
		]);
	}
}