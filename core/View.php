<?php
namespace Hawalius;
require HAWALIUS_PATH . '/app/vendor/Twig/Autoloader.php';
\Twig_Autoloader::register();

class Twig_Hawalius_Environment extends \Twig_Environment{
	public function render($template, array $vars = array()){
		try{
			return parent::render($template, $vars);
		}catch(Twig_Error_Loader $e) {
			echo '<h2>'.$e->getRawMessage().'</h2>';
		}
	}
}
function loadTwig(){
	global $config;
	if(isset($config['dirs']['theme'])){
		$theme = $config['dirs']['theme'];
	}else{
		$theme = 'default';
	}
	$loader = new \Twig_Loader_Filesystem(HAWALIUS_PATH . '/app/themes/' . $theme);
	$twig = new Twig_Hawalius_Environment($loader, array(
		'cache' => false
	));
	return $twig;
}