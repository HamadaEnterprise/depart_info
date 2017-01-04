<?php
//App::import('Controller', 'Homes');
class IOSController extends AppController{

	public $uses = array(
		'Depart',
		'EventInfo',
		'GoogleNews'
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

	public function getGoogleNews(){
		$googleNews = $this->GoogleNews->find('all', array(
				'order' => array('GoogleNews.id desc', 'image_src asc'),
				'limit' => 30
			));

		$googleNews = Set::extract('/GoogleNews/.', $googleNews);
		$sort;
		foreach($googleNews as $key => $value){
			$sort[$key] = $value['image_src'];
		}
		array_multisort($sort,SORT_DESC, SORT_STRING, $googleNews);

		header('content-type: application/json; charset=utf-8');
		echo(json_encode($googleNews,JSON_UNESCAPED_UNICODE));
		exit;

	}

	public function xmlTest(){
		$url = "https://news.google.com/news?ned=us&ie=UTF-8&oe=UTF-8&q=%E7%99%BE%E8%B2%A8%E5%BA%97&output=rss&num=30&hl=ja";

		$xml = file_get_contents($url);

		$xmlObject = simplexml_load_string($xml);

		$xmlArray = json_decode( json_encode( $xmlObject ), TRUE );

		foreach($xmlArray["channel"]["item"] as $item){
			preg_match('/<img(?:.*?)src=[\"\'](.*?)[\"\'](?:.*?)>/e', $item['description'], $result);
			$description = strip_tags($item['description']);
			
			$item['description'] = $description;
			if(isset($result[1])){
				$item['image_src'] = "https:" . $result[1];
			}
			
			$this->GoogleNews->create();
			$googleNews = $this->GoogleNews->findByGuid($item['guid']);
        	if($googleNews){
        		$item['id'] = $googleNews['GoogleNews']['id'];
        	}

			$this->GoogleNews->save($item);
		}
		exit;
	}

	public function calendar(){

		$thisMonth = date('n');
		$events = $this->EventInfo->find('all',
			array(
				'conditions' => array('start_month' => $thisMonth, 'EventInfo.is_deleted' => 0),
				'order' => array('start_day' =>'asc')
				)
			);

		$events = Set::extract('/EventInfo/.', $events);

		$sortedEvents = array();

		foreach ($events as $key => $event) {
			if(isset($sortedEvents[$event['start_day']])){
				array_push($sortedEvents[$event['start_day']], $events[$key]);
			}else{
				$sortedEvents[$event['start_day']] = array();
				array_push($sortedEvents[$event['start_day']], $events[$key]);

			}
		}

		// echo "<pre>";
		// print_r($sortedEvents);
		// echo "</pre>";

		header('content-type: application/json; charset=utf-8');
		echo(json_encode($sortedEvents,JSON_UNESCAPED_UNICODE));
		exit;
	}
}