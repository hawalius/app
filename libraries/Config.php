<?php
namespace Hawalius;

class Config{
	static public $config = array();

	static public function init(){
		$query = new SQLQuery('config');
		$c = $query->select('*')
			->run();

		while($row = $c->fetchAll()){
			self::$config[$row['name']] = $row['value'];
		}
	}

	static public function set($name, $value = ''){
		self::$config[$name] = $value;

		$query = new SQLQuery('config');
		$where = array();
		$where['name'] = $name;

		$post = $query->update(array(
				'name' => $name,
				'value' => $value
			))
			->where($where)
			->run();

		return self::$config[$name];
	}
}
