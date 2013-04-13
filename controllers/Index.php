<?php
namespace Hawalius\Controllers;

class Index extends \Hawalius\Controller{
	public function index($url = ''){
		$post = $this->app->getModel('post');
		
		$this->view->render('posts.html', array(
			'posts' => $post->many()
		));
	}
}