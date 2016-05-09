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



		/*echo "<pre>";
		print_r($selectedDepart);
		echo "</pre>";
		exit;*/
		$this->set(compact('selectedDepart', 'selectedDepartEvents'));
	}
}