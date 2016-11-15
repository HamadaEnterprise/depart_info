<?php
//App::import('Controller', 'Homes');
class IOSController extends AppController{

	public $uses = array(
		'Depart',
		'EventInfo'
		);


	//今日のイベント情報とデパート一覧を取得してJson形式でecho
	public function index() {

		$todayTimestamp = time();
		$todaysEvents = $this->EventInfo->find('all',
			array(
				'conditions' => array('start_timestamp <' => $todayTimestamp, 'end_timestamp >' => $todayTimestamp, 'EventInfo.is_deleted' => 0),
				'order' => array('style_id' => 'asc')
				)
			);
		$todaysEvents = Set::extract('/EventInfo/.',$todaysEvents);

		$departs = $this->Depart->find('all',
			array(
				'conditions' => array('is_deleted' => 0),
				'fields' => array('id', 'name')
				)
			);

		header('content-type: application/json; charset=utf-8');
		echo(json_encode($todaysEvents,JSON_UNESCAPED_UNICODE));
		//echo(json_encode($departs,JSON_UNESCAPED_UNICODE));
		exit;

	}

	public function xmlTest(){
		$querytag = "https://news.google.com/news?ned=us&ie=UTF-8&oe=UTF-8&q=%E7%99%BE%E8%B2%A8%E5%BA%97&output=rss&num=30&hl=ja";
		$gxml = simplexml_load_file($querytag, NULL, LIBXML_NOCDATA);
		$json = json_encode($gxml, JSON_UNESCAPED_SLASHES);
		echo $json;
		// foreach ($gxml->channel->item as $item) {
		//     echo $item->title;
		//     echo "<br>";
		//     echo $item->description;
		// }
		exit;
	}
}