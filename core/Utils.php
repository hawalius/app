<?php
function redirect($location = '/', $statusCode = 302){
	header('Location: ' . $location, true, $statusCode);
}
function getBlogInfo(){
	global $config;
	return array(
		'name' => isset($config['blog']['name']) ? $config['blog']['name'] : 'Hawalius blog',
		'slogan' => isset($config['blog']['slogan']) ? $config['blog']['slogan'] : 'Just a blog'
	);
}
function getAssetUrl(){
	global $config;
	if(array_key_exists('theme', \Hawalius\Config::$config)){
		$theme = \Hawalius\Config::$config['theme'];
	}else{
		$theme = 'default';
	}
	return '/themes/' . $theme;
}
function isExternal($url){
	$urlHost = parse_url($url, PHP_URL_HOST);
	$baseUrlHost = parse_url($_SERVER['SERVER_NAME'], PHP_URL_HOST);
	return $urlHost !== $baseUrlHost || !empty($urlHost);
}
function slug($str, $separator = '-') {
	$str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
	// replace non letter or digits by separator
	$str = preg_replace('#[^\\pL\d]+#u', $separator, $str);

	return trim(strtolower($str), $separator);
}
function hook($name, $value = ''){
	global $Plugins;
	
	return $Plugins->hook($name, $value);
}
function getVersion(){
	return VERSION;
}
function getGitRev(){
	return exec('git rev-parse --short HEAD');
}