<?php
namespace Hawalius\Models;

class Page extends \Hawalius\Model{
	public function many($limit = 10, $showDrafts = false){
		$query = 'SELECT * from ::pages ';
		if(!$showDrafts){
			$query .= 'WHERE published = 1';
		}
		$query .= ' ORDER by time DESC';
		
		$stmt = $this->db->query($query);
		
		return $stmt->fetchAll();
	}
	public function drafts(){
		$stmt = $this->db->query('SELECT * from ::pages WHERE published = 0 ORDER by time DESC');
		
		return $stmt->fetchAll();
	}
	
	public function published(){
		$stmt = $this->db->query('SELECT * from ::pages WHERE published = 1 ORDER by time DESC');
		
		return $stmt->fetchAll();
	}
	
	public function single($id = 0){
		$stmt = $this->db->prepare('SELECT * from ::pages WHERE id = :id');
		$stmt->bindParam('id', $id, \PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	
	public function url($url = ''){
		$stmt = $this->db->prepare('SELECT * from ::pages WHERE url = :url AND published = 1');
		$stmt->bindParam('url', $url, \PDO::PARAM_STR);
		$stmt->execute();
		
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	
	public function num(){
			$stmt = $this->db->prepare('SELECT id from ::pages');
		$stmt->execute();
		
		return $stmt->rowCount();
	}
	
	public function numPublished(){
		$stmt = $this->db->prepare('SELECT id from ::pages WHERE published = 1');
		$stmt->execute();
		
		return $stmt->rowCount();
	}
	
	public function numDrafts(){
		$stmt = $this->db->prepare('SELECT id from ::pages WHERE published = 0');
		$stmt->execute();
		
		return $stmt->rowCount();
	}
	
	public function write($title, $content, $url, $author = 0, $publish = 0){
		$stmt = $this->db->prepare('INSERT ::pages SET title = :title, content = :content, url = :url, author_id = :author, published = :published');
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
		$stmt = $this->db->prepare('UPDATE ::pages SET title = :title, content = :content, url = :url, author_id = :author WHERE id = :id');
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
		$stmt = $this->db->prepare('DELETE from ::pages WHERE id = :id');
		$stmt->bindParam('id', $id, \PDO::PARAM_INT);
		$stmt->execute();
                
		// Return true for now
		return true;
	}
	
	public function publish($id){
		$stmt = $this->db->prepare('UPDATE ::pages SET published = 1 WHERE id = :id');
		$stmt->bindParam('id', $id, \PDO::PARAM_INT);
		$stmt->execute();
		
		// Return true for now
		return true;
	}
	
	public function draft($id){
		$stmt = $this->db->prepare('UPDATE ::pages SET published = 0 WHERE id = :id');
		$stmt->bindParam('id', $id, \PDO::PARAM_INT);
		$stmt->execute();
		
		// Return true for now
		return true;
	}
}