<?php
namespace Hawalius;

class App{
	public $_controller, $_method;
	
	public function __construct($view){
		global $config;
		$this->view = $view;
	}

	public function run($route = NULL){
		global $config;

		$route = $_SERVER['REQUEST_URI'];
		$request = explode('/', trim($route, '/'));
        
		if(!empty($request[0])){
			$this->_controller = $request[0];
		}else{
			$this->_controller = 'index';
		}
		array_shift($request);

		if(!empty($request[0])){
			$this->_method = $request[0];
		}else{
			$this->_method = 'index';
		}
		array_shift($request);

		$className = 'Hawalius\\Controllers\\' . ucfirst($this->_controller);
		if(!class_exists($className)){
			$className = 'Hawalius\\Controllers\\FourOhFour';
		}

		$controller = new $className($this->view);
		$method = $this->_method;
		
		if(method_exists($className, $method) && is_callable(array($className, $method))){
			call_user_func_array(array($controller, $method), $request);
		}else{
			$controller->index();
		}
	}
	
	public function autoload($className){
		preg_match('/([^\\\]+)$/', ltrim($className, '\\'), $match);
		$file = HAWALIUS_PATH . '/app/controllers/' . $match[0] . '.php';
		if(file_exists($file)){
			require $file;
		}
	}
}