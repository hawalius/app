<?php
namespace Hawalius;
class Controller{
	public function __construct($app = NULL){
		$this->app = $app;
		$this->view = $app->view;
		
		$this->view->addFunction('getBlogInfo', new \Twig_Function_Function('getBlogInfo'));
		$this->view->addFunction('getAssetUrl', new \Twig_Function_Function('getAssetUrl'));
		$this->view->addFunction('isExternal', new \Twig_Function_Function('isExternal'));
		$this->view->addFunction('hook', new \Twig_Function_Function('hook'));
	}
	
	public function index(){
	}
}