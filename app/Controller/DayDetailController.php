<?php
class DayDetailController extends AppController {

	public $uses = array(
		'EventInfo'
	);
	public function index() {
		$this->set("naviType","calendar");
		$day = $_GET['day'];
		$month = $_GET['month'];

		$events = $this->EventInfo->find('all',
			array(
				'conditions' => array('start_month' => $month,'start_day' => $day )
				)
			);
		$this->set(compact('month', 'day', 'events'));
	}
}