<?php
App::import('Controller', 'Homes');
class AdminController extends AppController{

	public $uses = array(
		'Depart',
		'EventInfo'
		);

	public function beforeFilter() {
		parent :: beforeFilter();
		$this->set('naviType', 'nothing');
   }


	public function index() {

		$loginId = 'hoge';
		$loginPassword = 'fuga';

		$this->autoRender = false;
		if (!isset($_SERVER['PHP_AUTH_USER'])) {
			header('WWW-Authenticate: Basic realm="Private Page"');
			header('HTTP/1.0 401 Unauthorized');
			die("id / password Required");
		} else {
			if ($_SERVER['PHP_AUTH_USER'] != $loginId || $_SERVER['PHP_AUTH_PW'] != $loginPassword) {
				header('WWW-Authenticate: Basic realm="Private Page"');
				header('HTTP/1.0 401 Unauthorized');
				die("Invalid id / password combination.  Please try again");
			}
		}

		$departs;
		if(isset($this->request->query['condition'])){
			$originDeparts = $this->Depart->find('all',array(
					'conditions' => array('is_deleted' => 0),
					'fields' => array('id', 'name')
				));
			$departs = array();
			foreach ($originDeparts as $key => $depart) {
				$departs[$depart['Depart']['id']] = $depart['Depart']['name'];
			}
		}else{
			$departs = array('4' => '西武渋谷店', '26' => '西武東戸塚', '33' => '西武小田原店', '35' => 'そごう大宮', '37' => '西武所沢', '38' => 'そごう川口', '39' => 'そごう千葉', '41' => '西武船橋', '44' => 'そごう柏');
	
		}
		
		if($this->Session->read('message')){
			$message = $message = $this->Session->read('message');
			$this ->Session->delete('message');
			$this->set(compact('message'));
		}

		$this->set(compact('departs'));
		$this->render('index');
	}

	public function confirm(){
		$departID = $this->request->data['depart'];
		$depart = $this->Depart->find('first',array(
				'conditions' => array('id' => $departID, 'is_deleted' => 0)
				)
			);
		$departName = $depart['Depart']['name'];
		$startDate = $this->request->data['startDate'];
		$endDate = $this->request->data['endDate'];
		$eventName = $this->request->data['eventName'];

		$message = $this->Session->read('message');
		
		$this->set(compact('departID', 'startDate', 'endDate', 'eventName', 'departName', 'compliteMessage'));

		$this->render('confirm');
	}

	function entryEvent(){
		$departID = $this->request->data['departID'];
		
		$depart = $this->Depart->find('first',array(
				'conditions' => array('id' => $departID, 'is_deleted' => 0)
				)
			);

		$startDate = $this->request->data['startDate'];
		$startDateArray = split('-', $startDate);

		$endDate = $this->request->data['endDate'];
		$endDateArray = split('-', $endDate);

		$event['EventInfo']['start_year'] = $startDateArray[0];
		$event['EventInfo']['start_month'] = $startDateArray[1];
		$event['EventInfo']['start_day'] = $startDateArray[2];

		$event['EventInfo']['end_year'] = $endDateArray[0];
		$event['EventInfo']['end_month'] = $endDateArray[1];
		$event['EventInfo']['end_day'] = $endDateArray[2];

		$event['EventInfo']['name'] = $this->request->data['eventName'];
		$event['EventInfo']['depart_id'] = $depart['Depart']['id'];
		$event['EventInfo']['style_id'] = $depart['Depart']['style'];
		$event['EventInfo']['company_id'] = $depart['Depart']['company_code'];
		$event['EventInfo']['event_url'] = $depart['Depart']['event_template_url'];
		$startTimeStamp = mktime(0,0,0,$event['EventInfo']['start_month'],$event['EventInfo']['start_day'],$event['EventInfo']['start_year']);
		$endTimeStamp = mktime(0,0,0,$event['EventInfo']['end_month'],$event['EventInfo']['end_day'],$event['EventInfo']['end_year']);
		$event['EventInfo']['start_timestamp'] = $startTimeStamp;
		$event['EventInfo']['end_timestamp'] = $endTimeStamp;
		
		$this->categorizeAnEvent($event);

		$HomesController = new HomesController;
		$HomesController->saveData($event, $depart['Depart']['name']);

		$this->Session->write('message', 'イベントを登録しました');
		
		$this->redirect('index');
	}

	function categorizeAnEvent(&$event){
		$foods =array('グルメ','北海道','うまい','大自然','食品','福岡','四国','物産','九州','味','築地','マルシェ','ワイン','菓子','スイーツ','おいしい');
		$fashions = array('ファション','ワコール','サイズ','バーゲン','23区','パンツ','ジュエリー','婦人','紳士','雑貨','ランジェリー','レディス','メンズ','トリンプ','ブランド','バザール','イージーオーダー','ウェディング','ハンドバッグ','アクセサリ','バッグ','振袖','フォーマル','こども服');
		foreach($foods as $food){
			if(strstr($event['EventInfo']['name'], $food)){
				$event['EventInfo']['category'] = '1';
				$event['EventInfo']['categorized'] = '1';
			}
		}
		if(empty($event['EventInfo']['category'])){
			foreach($fashions as $fashion){
				if(strstr($event['EventInfo']['name'], $fashion)){
				$event['EventInfo']['category'] = '2';
				$event['EventInfo']['categorized'] = '1';
				echo "fashion";
				}
			}
		}
		if(empty($event['EventInfo']['category'])){
			$event['EventInfo']['category'] = '3';
			$event['EventInfo']['categorized'] = '1';	
		}
	}
}