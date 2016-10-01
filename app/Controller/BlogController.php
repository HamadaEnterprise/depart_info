<?php
class BlogController extends AppController {

	public $uses = array(
		'Blog'
	);

	//すべてのファンクションで呼び出される。ナビゲーションを設定する
	function beforeFilter(){
		$this->set("naviType","blog");
	}
	public function index() {
		

		$blogs = $this->Blog->find('all', array(
				'order' => array('date' => 'desc'),
				'limit' => 5
			));
		
		$this->set(compact('blogs'));
	}

	//ブログ記事が選択されたときに呼び出される。当該ブログを取得し、ブログ一覧を取得する。
	public function selectedBlog(){
		$blogId = $_GET['id'];
		$selectedBlog = $this->Blog->find('first', array(
				'conditions' =>array(
					'id' => $blogId
					)
			));
		$blogs = $this->Blog->find('all', array(
				'order' => array('date' => 'desc'),
				'fields' => array('title', 'id'),
				'limit' => 5
			));
		$this->set(compact('selectedBlog', 'blogs'));

	}
}