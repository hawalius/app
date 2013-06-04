<?php
namespace Hawalius;

// Fail out if not included from root
if(!defined('HAWALIUS_PATH')){
	header('HTTP/1.1 403 Forbidden', true, 403);
	die();
}

// Compares PHP version against our requirement.
if(!version_compare(PHP_VERSION, '5.4.0', '>=')){
	die('Hawalius needs PHP 5.4.0 or higher to run. You are currently running PHP ' . PHP_VERSION . '.');
}

if(ENV == 'development'){
	error_reporting(E_ALL | E_STRICT);
	ini_set('display_errors', true);
}else{
	ini_set('display_errors', false);
}

session_start();
ob_start();

date_default_timezone_set('Europe/Paris');

$routes = [
	'/' => 'index',
	'/post/:action' => 'post#view',
	'/page/:action' => 'page#view',
	'/admin' => 'admin',
	'/admin/login' => 'admin#login',
	'/admin/posts' => 'admin#posts',
	'/admin/pages' => 'admin#pages',
	'/admin/settings' => 'admin#settings',
	'/admin/logout' => 'admin#logout'
];

try{
	require HAWALIUS_PATH . '/app/core/DB.php';
	require HAWALIUS_PATH . '/app/core/App.php';
	require HAWALIUS_PATH . '/app/core/Controller.php';
	require HAWALIUS_PATH . '/app/core/Model.php';
	require HAWALIUS_PATH . '/app/core/View.php';
	require HAWALIUS_PATH . '/app/core/Utils.php';
	
	require HAWALIUS_PATH . '/app/libraries/Plugins.php';
	require HAWALIUS_PATH . '/app/libraries/Plugin.php';
	
	if(file_exists(HAWALIUS_PATH . '/config.php')){
		require HAWALIUS_PATH . '/config.php';
	}else{
		// Installer stuff
		redirect('/install.php');
	}
	
	$DB = new DB();
	
	$twig = loadTwig();
	
	$Plugins = new Plugins($twig);
	$Plugins->init();
	
	$app = new App($twig, $DB, $routes);
	spl_autoload_register(array($app, 'autoload'));
	$app->run();
}catch(\Exception $e){
	http_response_code(503);
	
	if(ENV == 'development'){
		die('Hawalius Exception: ' . $e->getMessage());
	}
}