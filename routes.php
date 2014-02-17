<?php
$routes = [
	'/' => [
		'controller' => 'index'
	],
	'/install' => [
		'controller' => 'install'
	],
	'/post/:alpha' => [
		'controller' => 'post',
		'method' => 'view'
	],
	'/page/:alpha' => [
		'controller' => 'page',
		'method' => 'view'
	],
	'/admin' => [
		'controller' => 'admin'
	],
	'/admin/login' => [
		'controller' => 'admin',
		'method' =>  'login'
	],
	'/admin/posts' => [
		'controller' => 'admin',
		'method' =>  'posts'
	],
	'/admin/posts/:alpha' => [
		'controller' => 'admin',
		'method' =>  'posts'
	],
	'/admin/posts/:alpha/:number' => [
		'controller' => 'admin',
		'method' =>  'posts'
	],
	'/admin/pages' => [
		'controller' => 'admin',
		'method' =>  'pages'
	],
	'/admin/pages/:alpha' => [
		'controller' => 'admin',
		'method' =>  'pages'
	],
	'/admin/pages/:alpha/:number' => [
		'controller' => 'admin',
		'method' =>  'pages'
	],
	'/admin/settings' => [
		'controller' => 'admin',
		'method' =>  'settings'
	],
	'/admin/logout' => [
		'controller' => 'admin',
		'method' =>  'logout'
	]
];