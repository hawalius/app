<?php
namespace Hawalius;

require HAWALIUS_PATH . '/app/vendor/Twig/lib/Twig/Autoloader.php';
require HAWALIUS_PATH . '/app/vendor/Markdown/Michelf/MarkdownExtra.inc.php';
\Twig_Autoloader::register();

class Twig_Hawalius_Environment extends \Twig_Environment{
	public function render($template, array $vars = array()){
		try{
			echo parent::render($template, $vars);
		}catch(Twig_Error_Loader $e) {
			echo '<h2>'.$e->getRawMessage().'</h2>';
		}
	}
}
function loadTwig(){
	if(isset(config::$config['theme'])){
		$theme = config::$config['theme'];
	}else{
		$theme = 'default';
	}
	$loader = new \Twig_Loader_Filesystem(array(
		HAWALIUS_PATH . '/themes/' . $theme,
		HAWALIUS_PATH . '/themes/default',
		HAWALIUS_PATH . '/app/views'
	));
	$twig = new Twig_Hawalius_Environment($loader, array(
		'cache' => false
	));
	$twig->addFilter(new \Twig_SimpleFilter('markdown', '\\Michelf\\MarkdownExtra::defaultTransform'));
	return $twig;
}
