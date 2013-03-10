<?php
namespace Hawalius;
class Controller{
	public function __construct($view = NULL){
		$this->view = $view;
		$this->view->addFunction('getBlogInfo', new \Twig_Function_Function('getBlogInfo'));
		$this->view->addFunction('getAssetUrl', new \Twig_Function_Function('getAssetUrl'));
	}
	
	public function index(){
	}
}