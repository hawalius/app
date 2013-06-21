<?php
namespace Hawalius;

class Themes{
	static public function many(){
		$themes = array();
		foreach(scandir(HAWALIUS_PATH . '/themes') as $file){
			if($file !== '.' && $file !== '..' && $file[0] !== '.'){
				if(!is_file($file)){
					$tmp = array();
					$tmp['name'] = $file;
					if(is_file($file . '/screenshot.png')){
						$tmp['screenshot'] = $file . '/screenshot.png';
					}
					array_push($themes, $tmp);
				}
			}
		}
		return $themes;
	}
}