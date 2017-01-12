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

		$blogsTitle = "デパート情報百貨最新記事一覧";

		$this->set('title_for_layout', $blogsTitle);

		$pastBlogsDate = $this->pastBlogsDate();

		$description = "百貨店に関するニュースを一週間まとめてお届け、それ以外にも売上速報や気になるニュースを取り上げています。";
		
		$this->set(compact('blogs', "blogsTitle", 'pastBlogsDate', 'description'));
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

		$title_for_layout = $selectedBlog['Blog']['title'];

		$description = mb_substr(strip_tags($selectedBlog['Blog']['text']),0 , 125);

		$description = str_replace(PHP_EOL, '', $description);

		$description = str_replace('"', '"', $description);

		$this->set('title_for_layout', $title_for_layout);

		$this->set(compact('selectedBlog', 'blogs', 'pastBlogsDate', 'description'));

	}

	public function pastBlogs(){
		$selectedPastDate = $_GET['date'];

		$blogs = $this->Blog->find('all', array(
				'order' => array('date' => 'desc'),
				'conditions' => array('DATE_FORMAT(date, "%Y-%m")' => $selectedPastDate)
			));

		$blogsTitle = str_replace("-", "年", $selectedPastDate) . "月のデパート情報百貨記事一覧";

		$pastBlogsDate = $this->pastBlogsDate();

		$description = $blogsTitle . "百貨店に関するニュースを一週間まとめてお届け、それ以外にも売上速報や気になるニュースを取り上げています。";

		$this->set(compact('blogs', "blogsTitle", 'pastBlogsDate'));

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

