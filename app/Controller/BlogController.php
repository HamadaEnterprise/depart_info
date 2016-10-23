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

		$blogsTitle = "最新記事一覧";
		
		$this->set(compact('blogs', "blogsTitle"));
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

		$pastBlogsDate = $this->pastBlogsDate();

		// echo "<pre>";
		// print_r($pastBlogsDate);
		// echo "</pre>";
		// exit;

		

		$this->set(compact('selectedBlog', 'blogs', 'pastBlogsDate'));

	}

	public function pastBlogs(){
		$selectedPastDate = $_GET['date'];

		$blogs = $this->Blog->find('all', array(
				'order' => array('date' => 'desc'),
				'conditions' => array('DATE_FORMAT(date, "%Y-%m")' => $selectedPastDate)
			));

		$blogsTitle = str_replace("-", "年", $selectedPastDate) . "月の記事一覧";

		$this->set(compact('blogs', "blogsTitle"));

		$this->render('index');
	}

	private function pastBlogsDate(){
		$pastBlogsDate = $this->Blog->find('all', array(
				'fields' => array('DATE_FORMAT(date, "%Y-%m") as registedTime', 'COUNT(*) as count '),
				'group' => array('DATE_FORMAT(date, "%Y-%m")'),
				'order' => array('registedTime' => 'desc')
			));

		return $pastBlogsDate;
	}
}

