<?php
namespace Hawalius\Controllers;

class Page extends \Hawalius\Controller{
	public function view($url = ''){
		$page = $this->app->getModel('page');
		
		$p = $page->url($url);
		
		$this->view->render('post.html', array(
			'post' => $p
		));
	}
}