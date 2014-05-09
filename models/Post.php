<?php
namespace Hawalius\Models;
use Hawalius\SQLQuery;

class Post extends \Hawalius\Model{
	protected $table = 'posts';

	public function many($limit = 10, $showDrafts = false){
		$query = new SQLQuery($this->table);
		$where = array();

		if(!$showDrafts){
			$where['published'] = 1;
		}

		$posts = $query->select('*')
			->where($where)
			->orderBy('time DESC')
			->run()
			->fetchAll();

		return $posts;
	}

	public function drafts(){
		$query = new SQLQuery($this->table);
		$where = array();
		$where['published'] = 0;

		$posts = $query->select('*')
			->where($where)
			->orderBy('time DESC')
			->run()
			->fetchAll();

		return $posts;
	}

	public function published(){
		$query = new SQLQuery($this->table);
		$where = array();
		$where['published'] = 1;

		$posts = $query->select('*')
			->where($where)
			->orderBy('time DESC')
			->run()
			->fetchAll();

		return $posts;
	}

	public function single($id = 0){
		$query = new SQLQuery($this->table);
		$where = array();
		$where['id'] = $id;

		$post = $query->select('*')
			->where($where)
			->run()
			->fetch();

		return $post;
	}

	public function url($url = ''){
		$query = new SQLQuery($this->table);
		$where = array();
		$where['url'] = $url;
		$where['published'] = 1;

		$post = $query->select('*')
			->where($where)
			->run()
			->fetch();

		return $post;
	}

	public function num(){
		$query = new SQLQuery($this->table);;

		$num = $query->select('COUNT(id)')
			->run()
			->fetch();

		return $num['COUNT(id)'];
	}

	public function numPublished(){
		$query = new SQLQuery($this->table);
		$where = array();
		$where['published'] = 1;

		$num = $query->select('COUNT(id)')
			->where($where)
			->run()
			->fetch();

		return $num['COUNT(id)'];
	}

	public function numDrafts(){
		$query = new SQLQuery($this->table);
		$where = array();
		$where['published'] = 0;

		$num = $query->select('COUNT(id)')
			->where($where)
			->run()
			->fetch();

		return $num['COUNT(id)'];
	}

	public function write($title, $content, $url, $author = 0, $publish = 0){
		$query = new SQLQuery($this->table);

		$post = $query->insert(array(
			'title' => $title,
			'content' => $content,
			'url' => $url,
			'author_id' => $author,
			'published' => $publish
		))->run();

		return $post;
	}

	public function edit($id, $title, $content, $url, $author = 0, $publish = 0){
		$query = new SQLQuery($this->table);
		$where = array();
		$where['id'] = $id;

		$post = $query->update(array(
			'title' => $title,
			'content' => $content,
			'author_id' => $author,
			'published' => $publish
			))
			->where($where)
			->run();

		return $post;
	}

	public function delete($id){
		$query = new SQLQuery($this->table);
		$where = array();
		$where['id'] = $id;

		$post = $query->delete()
			->where($where)
			->run();

		return $post;
	}

	public function publish($id){
		$stmt = \Hawalius\DB::prepare('UPDATE ::posts SET published = 1 WHERE id = :id');
		$stmt->bindParam('id', $id, \PDO::PARAM_INT);
		$stmt->execute();

		// Return true for now
		return true;
	}

	public function draft($id){
		$stmt = \Hawalius\DB::prepare('UPDATE ::posts SET published = 0 WHERE id = :id');
		$stmt->bindParam('id', $id, \PDO::PARAM_INT);
		$stmt->execute();

		// Return true for now
		return true;
	}
}
