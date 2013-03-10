<?php
function redirect($location = '/', $statusCode = 302){
	header('Location: ' . $location, true, $statusCode);
}
function getBlogInfo(){
	
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