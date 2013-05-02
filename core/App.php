<?php
namespace Hawalius;

class App{
	public $_controller, $_method;
	
	public function __construct($view, $routes){
		global $config;
		$this->view = $view;
		$this->routes = $routes;
	}

	public function run(){
		global $config;

		$uri = $_SERVER['REQUEST_URI'];
		$request = explode('/', trim($uri, '/'));
		
		if(count($request) > 2){
			$route = array_slice($request, 0, 2);
		}else{
			$route = $request;
		}
		$params = array_slice($request, 2);
		
		foreach($this->routes as $key => $val){		
			if(strpos($key, ':action') !== false){
				$k = explode('/', $key);
				$i = 0;
				
				foreach($k as $v){
					if($v == ':action'){
						$_route = array_slice($request, 0, $i);
						$_route[$i - 1] = ':action';
						$_params = array_slice($request, $i - 1);
						break;
					}
					$i++;
				}
			}
			
			$r = '/' . implode('/', $route);
			if(isset($_route)){
				$_r = '/' . implode('/', $_route);
				if(preg_match('#^' . $key . '$#', $_r)){
					$r = $_r;
					$params = $_params;
				}
			}
			
			if(preg_match('#^' . $key . '$#', $r)){
				$matches = preg_split('/#/', $val);
				
				if(isset($matches[0])){
					$this->_controller = $matches[0];
				}else{
					$this->_controller = 'index';
				}
				
				if(isset($matches[1])){
					$this->_method = $matches[1];
				}else{
					$this->_method = 'index';
				}
			}
				
		}
		
		if(!isset($this->_controller)){
			$this->_controller = 'FourOhFour';
		}
		
		if(!isset($this->_method)){
			$this->_method = 'index';
		}
		
		$className = 'Hawalius\\Controllers\\' . ucfirst($this->_controller);
		if(!class_exists($className)){
			$className = 'Hawalius\\Controllers\\FourOhFour';
		}

		$controller = new $className($this, $this->view);
		$method = $this->_method;

		if(method_exists($className, $method) && is_callable(array($className, $method))){
			call_user_func_array(array($controller, $method), $params);
		}else{
			call_user_func_array(array($controller, 'index'), $params);
		}	
	}
	
	public function autoload($className){
		preg_match('/([^\\\]+)$/', ltrim($className, '\\'), $match);
		$file = HAWALIUS_PATH . '/app/controllers/' . $match[0] . '.php';
		if(file_exists($file)){
			require $file;
		}
	}
	
	public function getModel($modelName){
		if(file_exists(HAWALIUS_PATH . '/app/models/' . $modelName . '.php')){
			require HAWALIUS_PATH . '/app/models/' . $modelName . '.php';
		}
		$modelName = '\\Hawalius\\Models\\' . ucfirst($modelName);
		return new $modelName($this);
	}
}