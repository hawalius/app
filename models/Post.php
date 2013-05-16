<?php
namespace Hawalius\Models;

class Post extends \Hawalius\Model{
	public function many($limit = 10){
		global $DB;
		
		$stmt = $DB->query('SELECT * from ::posts ORDER by time DESC');
		
		return $stmt->fetchAll();
	}
	
	public function drafts(){
		global $DB;
		
		$stmt = $DB->query('SELECT * from ::posts WHERE published = 0 ORDER by time DESC');
		
		return $stmt->fetchAll();
	}
	
	public function published(){
		global $DB;
		
		$stmt = $DB->query('SELECT * from ::posts WHERE published = 1 ORDER by time DESC');
		
		return $stmt->fetchAll();
	}
	
	public function single($id = 0){
		global $DB;
		
		$stmt = $DB->prepare('SELECT * from ::posts WHERE id = :id');
		$stmt->bindParam('id', $id, \PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	
	public function url($url = ''){
		global $DB;
		
		$stmt = $DB->prepare('SELECT * from ::posts WHERE url = :url AND published = 1');
		$stmt->bindParam('url', $url, \PDO::PARAM_STR);
		$stmt->execute();
		
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	
	public function num(){
		global $DB;
	
		$stmt = $DB->prepare('SELECT id from ::posts');
		$stmt->execute();
		
		return $stmt->rowCount();
	}
	
	public function write($title, $content, $url, $author = 0){
		global $DB;
		
		$stmt = $DB->prepare('INSERT ::posts SET title = :title, content = :content, url = :url, author_id = :author');
		$stmt->bindParam('title', $title, \PDO::PARAM_STR);
		$stmt->bindParam('content', $content, \PDO::PARAM_STR);
		$stmt->bindParam('url', $url, \PDO::PARAM_STR);
		$stmt->bindParam('author', $author, \PDO::PARAM_INT);
		$stmt->execute();
		
		// Return true for now
		return true;
	}
	
	public function edit($id, $title, $content, $url, $author = 0){
		global $DB;
		
		$stmt = $DB->prepare('UPDATE ::posts SET title = :title, content = :content, url = :url, author_id = :author WHERE id = :id');
		$stmt->bindParam('id', $id, \PDO::PARAM_INT);
		$stmt->bindParam('title', $title, \PDO::PARAM_STR);
		$stmt->bindParam('content', $content, \PDO::PARAM_STR);
		$stmt->bindParam('url', $url, \PDO::PARAM_STR);
		$stmt->bindParam('author', $author, \PDO::PARAM_INT);
		$stmt->execute();
		
		// Return true for now
		return true;
	}
	
	public function delete($id){
		global $DB;
                
		$stmt = $DB->prepare('DELETE from ::posts WHERE id = :id');
		$stmt->bindParam('id', $id, \PDO::PARAM_INT);
		$stmt->execute();
                
		// Return true for now
		return true;
	}
}