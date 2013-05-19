<?php
namespace Hawalius;

class Plugins{
	public $plugins = array();
	
	public function __construct($view = NULL){
		$this->view = $view;
	}
	
	public function init(){
		global $config;
		
		$plugins = $config['plugins'];
		foreach($plugins as $plugin => $conf){
			$path = HAWALIUS_PATH . '/plugins/' . strtolower($plugin) . '/plugin.php';
			
			if(file_exists($path)){
				require $path;
			}
			
			$class = new \ReflectionClass('\\Hawalius\\Plugins\\' . $plugin);
			$plugin = $class->newInstanceArgs(array($conf));
			if(method_exists($plugin, 'init')){
				$plugin->init($this->view);
			}
			
			array_push($this->plugins, $plugin);
		}
	}
	
	public function hook($name, $value = ''){
		$plugins = $this->plugins;
		foreach($plugins as $plugin){
			if(method_exists($plugin, $name)){
				$value = $plugin->$name($value);
			}
		}
		return $value;
	}
}