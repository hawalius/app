<?php
namespace Hawalius\Controllers;

class Post extends \Hawalius\Controller{
	public function view($url = ''){
		$post = $this->app->getModel('post');
		
		$p = $post->url($url);
		
		$this->view->render('post.html', [
			'post' => $p
		]);
	}
}