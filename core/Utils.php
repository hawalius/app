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
	if(isset($config['theme'])){
		$theme = $config['theme'];
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
/* https://github.com/idiot/feather/blob/master/feather/classes/url.php */
function slugify($url){
	$url = trim($url, '-');
	$url = iconv('utf-8', 'us-ascii//TRANSLIT', $url);
	$url = strtolower($url);
	$url = preg_replace('/[^-\w]+/', '', $url);
        
	return $url;
}