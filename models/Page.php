<?php
namespace Hawalius\Models;

class Page extends \Hawalius\Model{
	public function many($limit = 10, $showDrafts = false){
		$query = 'SELECT * from ::pages ';
		if(!$showDrafts){
			$query .= 'WHERE published = 1';
		}
		$query .= ' ORDER by time DESC';
		
		$stmt = \Hawalius\DB::query($query);
		
		return $stmt->fetchAll();
	}
	
	public function drafts(){
		$stmt = \Hawalius\DB::query('SELECT * from ::pages WHERE published = 0 ORDER by time DESC');
		
		return $stmt->fetchAll();
	}
	
	public function published(){
		$stmt = \Hawalius\DB::query('SELECT * from ::pages WHERE published = 1 ORDER by time DESC');
		
		return $stmt->fetchAll();
	}
	
	public function single($id = 0){
		$stmt = \Hawalius\DB::prepare('SELECT * from ::pages WHERE id = :id');
		$stmt->bindParam('id', $id, \PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	
	public function url($url = ''){
		$stmt = \Hawalius\DB::prepare('SELECT * from ::pages WHERE url = :url AND published = 1');
		$stmt->bindParam('url', $url, \PDO::PARAM_STR);
		$stmt->execute();
		
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	
	public function num(){
			$stmt = \Hawalius\DB::prepare('SELECT id from ::pages');
		$stmt->execute();
		
		return $stmt->rowCount();
	}
	
	public function numPublished(){
		$stmt = \Hawalius\DB::prepare('SELECT id from ::pages WHERE published = 1');
		$stmt->execute();
		
		return $stmt->rowCount();
	}
	
	public function numDrafts(){
		$stmt = \Hawalius\DB::prepare('SELECT id from ::pages WHERE published = 0');
		$stmt->execute();
		
		return $stmt->rowCount();
	}
	
	public function write($title, $content, $url, $author = 0, $publish = 0){
		$stmt = \Hawalius\DB::prepare('INSERT ::pages SET title = :title, content = :content, url = :url, author_id = :author, published = :published');
		$stmt->bindParam('title', $title, \PDO::PARAM_STR);
		$stmt->bindParam('content', $content, \PDO::PARAM_STR);
		$stmt->bindParam('url', $url, \PDO::PARAM_STR);
		$stmt->bindParam('author', $author, \PDO::PARAM_INT);
		$stmt->bindParam('published', $publish, \PDO::PARAM_INT);
		$stmt->execute();
		
		// Return true for now
		return true;
	}
	
	public function edit($id, $title, $content, $url, $author = 0){
		$stmt = \Hawalius\DB::prepare('UPDATE ::pages SET title = :title, content = :content, url = :url, author_id = :author WHERE id = :id');
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
		$stmt = \Hawalius\DB::prepare('DELETE from ::pages WHERE id = :id');
		$stmt->bindParam('id', $id, \PDO::PARAM_INT);
		$stmt->execute();
                
		// Return true for now
		return true;
	}
	
	public function publish($id){
		$stmt = \Hawalius\DB::prepare('UPDATE ::pages SET published = 1 WHERE id = :id');
		$stmt->bindParam('id', $id, \PDO::PARAM_INT);
		$stmt->execute();
		
		// Return true for now
		return true;
	}
	
	public function draft($id){
		$stmt = \Hawalius\DB::prepare('UPDATE ::pages SET published = 0 WHERE id = :id');
		$stmt->bindParam('id', $id, \PDO::PARAM_INT);
		$stmt->execute();
		
		// Return true for now
		return true;
	}
}