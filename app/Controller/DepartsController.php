<?php
class DepartsController extends AppController {

	public $uses = array(
		'Depart',
		'EventInfo'
		);
	public function index(){
		$this->set('naviType', 'departs');

		$tokyoDeparts = $this->Depart->find('all', array(
			'conditions' => array('region' => '1', 'is_deleted' => 0),
			'order' => array('style asc')
			));

		$kanagawaDeparts = $this->Depart->find('all', array(
			'conditions' => array('region' => '2', 'is_deleted' => 0),
			'order' => array('style asc')
			));

		$saitamaDeparts = $this->Depart->find('all', array(
			'conditions' => array('region' => '3', 'is_deleted' => 0),
			'order' => array('style asc')
			));

		$chibaDeparts = $this->Depart->find('all', array(
			'conditions' => array('region' => '4', 'is_deleted' => 0),
			'order' => array('style asc')
			));
		$this->set('title_for_layout', '掲載百貨店一覧｜デパート情報百貨');
		$this->set(compact('tokyoDeparts', 'kanagawaDeparts', 'saitamaDeparts', 'chibaDeparts'));
	}

	public function departDetail(){
		$this->set('naviType', 'departs');
		$departId = $_GET['id'];

		$selectedDepart = $this->Depart->find('first', array(
			'conditions' => array('id' => $departId)

			));
		$todayTimestamp = time();
		$selectedDepartEvents = $this->EventInfo->find('all',
			array(
				'conditions' => array('depart_id' => $departId, 'end_timestamp >' => $todayTimestamp, 'EventInfo.is_deleted' => 0),
				'order' => array('start_timestamp' => 'asc')
				)
			);

		$rss = simplexml_load_file($selectedDepart['Depart']['rss_url']);
		foreach($rss->channel->item as $item){
		$title = $item->title;
		$date = date("Y年 n月 j日", strtotime($item->pubDate));
		$link = $item->link;
		$description = mb_strimwidth (strip_tags($item->description), 0 , 50, "…Read More", "utf-8");

		//preg_match('/<img.*>/i', $item->description, $entryimg);
		/*preg_match('/<img.*?src=(["\'])(.+?)\1.*?>/i', $item->description, $entryimg);

		print_r($entryimg[2]) ;
		exit;*/

		/*echo "<pre>";
		print_r($selectedDepart);
		echo "</pre>";
		exit;*/

		$this->set('title_for_layout', $selectedDepart['Depart']['name'] . '｜デパート情報百貨');
		$this->set(compact('selectedDepart', 'selectedDepartEvents'));
		}
	}
}