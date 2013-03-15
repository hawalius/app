<?php
namespace Hawalius\Controllers;

class FourOhFour extends \Hawalius\Controller{
	public function index(){
		http_response_code(404);
		echo '<h1>404 Page not found</h1>';
	}
}