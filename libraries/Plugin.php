<?php
namespace Hawalius;

abstract class Plugin{
	public function __construct($view = NULL, $config = array()){
		$this->view = $view;
		$this->config = $config;
	}
}