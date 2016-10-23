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
}