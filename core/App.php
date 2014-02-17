<?php
namespace Hawalius;

class App{
	public static $patterns = array(
		':string' => '([a-zA-Z]+)',
		':number' => '([0-9]+)',
		':alpha'  => '([a-zA-Z0-9-_]+)'
	);
	
	/**
		* @param Twig_Hawalius_Environment $view
		* @param array $routes
	**/
	public function __construct(Twig_Hawalius_Environment $view, array $routes){
		$this->view = $view;
		$this->routes = $routes;
	}

	public function run(){
		$uri = $_SERVER['REQUEST_URI'];
		$uri = strtok($uri, '?');
		
		$params = array();
		
		if(array_key_exists($uri, $this->routes)){
			$route = $this->routes[$uri];
			
			if(array_key_exists('method', $route)){
				$method = $route['method'];
			}else{
				$method = 'index';
			}
			
			return $this->route($route['controller'], $method, $params);
		}
		
		$searches = array_keys(self::$patterns);
		$replaces = array_values(self::$patterns);
		
		$numRoutes = count($this->routes);
		$i = 0;
		foreach($this->routes as $pattern => $route){		
			$pattern = strtr($pattern, $this::$patterns);

			if(preg_match('#^/?' . $pattern. '/?$#', $uri, $matches)){
				if(array_key_exists('method', $route)){
					$method = $route['method'];
				}else{
					$method = 'index';
				}
				
				$params = array_slice($matches, 1);
				
				$this->route($route['controller'], $method, $params);
				break;
			}else{
				if($i == $numRoutes - 1){
					$this->route('FourOhFour');
				}
			}
			$i++;
		}
	}
	
	/**
		* @param string $controller Controller to use.
		* @param string $method Method to call.
		* @param array $params Parameters to use.
	**/
	public function route($controller = 'FourOhFour', $method = '', array $params = array()){
		$className = 'Hawalius\\Controllers\\' . ucfirst($controller);
		if(!class_exists($className)){
			$className = 'Hawalius\\Controllers\\FourOhFour';
		}
		
		$controller = new $className($this);

		if(method_exists($className, $method) && is_callable(array($className, $method))){
			call_user_func_array(array($controller, $method), $params);
		}else{
			call_user_func_array(array($controller, 'index'), $params);
		}	
	}
	
	/**
		* @param string $className Controller to include.
	**/
	public function autoload($className = ''){
		preg_match('/([^\\\]+)$/', ltrim($className, '\\'), $match);
		$file = HAWALIUS_PATH . '/app/controllers/' . $match[0] . '.php';
		if(file_exists($file)){
			require $file;
		}
	}
	
	/**
		* @param string $modelName Model to return.
		* @return object
	**/
	public function getModel($modelName = ''){
		if(file_exists(HAWALIUS_PATH . '/app/models/' . $modelName . '.php')){
			require HAWALIUS_PATH . '/app/models/' . $modelName . '.php';
		}
		$modelName = '\\Hawalius\\Models\\' . ucfirst($modelName);
		return new $modelName($this);
	}
}
class Exception extends \Exception{}