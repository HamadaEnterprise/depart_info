<?php
class CalendarController extends AppController {

	public $uses = array(
		'Depart',
		'EventInfo',
		'Category',
		'Region'
	);

	public function index() {
		//ナビゲーションの設定
		$this->set("naviType","calendar");
		$getMonth = $_GET['month'];
		
		$thisMonth = "";
		$maxDay = "";
		if($getMonth == "this"){
			$thisMonth = date('n');
			$maxDay = "+0 month";
		}elseif($getMonth == "next"){
			$thisMonth = date('n', strtotime('+1 month'));
			$maxDay = "+1 month";
		}elseif($getMonth == "last"){
			$thisMonth = date('n', strtotime('-1 month'));
			$maxDay = "-1 month";
		}
		//カレンダーの設定
		$weekday = array( '日', '月', '火', '水', '木', '金', '土' );
		$this->set(compact("weekday"));
		//催事情報の設定
		$selectedCategory = array(0,1,2,3);
		$selectedRegion = array(0,1,2,3,4);
		if($this->request->isPost()){
			if($this->request->data['selectedCategory'] != 0){
				$selectedCategory = array($this->request->data['selectedCategory']);
			}
			if($this->request->data['selectedRegion'] != 0){
				$selectedRegion = array($this->request->data['selectedRegion']);
			}
		}
		$events = $this->EventInfo->find('all',
			array(
				'conditions' => array('start_month' => $thisMonth, 'EventInfo.is_deleted' => 0, 'category' => $selectedCategory, 'Depart.region' => $selectedRegion)
				)
			);
		
		$sortedEvents = array();

		foreach ($events as $key => $event) {
			if(isset($sortedEvents[$event['EventInfo']['start_day']])){
				array_push($sortedEvents[$event['EventInfo']['start_day']], $events[$key]);
			}else{
				$sortedEvents[$event['EventInfo']['start_day']] = array();
				array_push($sortedEvents[$event['EventInfo']['start_day']], $events[$key]);

			}
		}
		//地域一覧
		$region = $this->Region->find('all');
		$sortedRegion = array();
		foreach($region as $eachRegion){
			$sortedRegion[$eachRegion['Region']['id']] = $eachRegion['Region']['name'];
		}
		//カテゴリーの設定
		$categories = $this->Category->find('all',
			array(
				'conditions' => array('is_deleted' => 0)
				)
			);
		$sortedCategories = array();
		foreach ($categories as $key => $category) {
			$sortedCategories[$category['Category']['id']] = $category['Category']['name'];
		}
		$this->set('title_for_layout', '百貨店催事カレンダー｜デパート情報百貨');
		$this->set(compact('sortedEvents', 'thisMonth', 'sortedCategories', 'selectedCategory', 'sortedRegion', 'selectedRegion', 'maxDay'));

	}
}