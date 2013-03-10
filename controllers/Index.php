<?php
namespace Hawalius\Controllers;

class Index extends \Hawalius\Controller{
	public function index(){
		$this->view->render('posts.html');
	}
}