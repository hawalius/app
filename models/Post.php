<?php
namespace Hawalius\Models;

class Post extends \Hawalius\Model{
	public function many($limit = 10){
		global $DB;
		$result = $DB->query('SELECT * from ::posts');
		return $result->fetchAll();
	}
	
	public function single($id){
		global $DB;
		$DB->prepare('SELECT * from ::posts WHERE id = :id');
		$stmt->bindParam('id', $id, PDO::PARAM_INT);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
}