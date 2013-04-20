<?php
namespace Hawalius;

abstract class Plugin{
	public function __construct($config = array()){
		$this->config = $config;
	}
}