<?php
namespace Hawalius;

// Fail out if not included from root
if(!defined('HAWALIUS_PATH')){
	header('HTTP/1.1 403 Forbidden', true, 403);
	die();
}

// Compares PHP version against our requirement.
if(!version_compare( PHP_VERSION, '5.4.0', '>=' )){
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

try{
	require HAWALIUS_PATH . '/app/core/DB.php';
	require HAWALIUS_PATH . '/app/core/App.php';
	require HAWALIUS_PATH . '/app/core/Controller.php';
	require HAWALIUS_PATH . '/app/core/View.php';
	require HAWALIUS_PATH . '/app/core/Utils.php';
	
	if(file_exists(HAWALIUS_PATH . '/config.php')){
		require HAWALIUS_PATH . '/config.php';
	}else{
		// Installer stuff
		redirect('/install.php');
	}
	
	$DB = new DB();
	
	$twig = loadTwig();
	
	$app = new App($twig);
	spl_autoload_register(array($app, 'autoload'));
	$app->run();
}catch(\Exception $e){
	http_response_code(503);
	
	die('Hawalius Exception: ' . $e->getMessage());
}