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
	
	public function write($title, $content, $url, $author = 0){
		global $DB;
		$DB->prepare('INSERT ::posts SET title = :title, content = :content, url = :url');
		$stmt->bindParam('title', $title, PDO::PARAM_STR);
		$stmt->bindParam('content', $content, PDO::PARAM_STR);
		$stmt->bindParam('url', $url, PDO::PARAM_STR);
		$stmt->bindParam('author', $author, PDO::PARAM_STR);
		return $stmt;
	}
}