<?php
class StatisticsController  extends AppController {

	public $uses = array(
		'SalesRegion',
		'SalesRegionYearOnYear',
		'SalesItem',
		'SalesItemYearOnYear'
	);


	public function index() {
		//ナビゲーションの設定
		$this->set("naviType","statistics");

		//カラム名の取得
		$regionColumns = array_keys($this->SalesRegion->getColumnTypes());
		$itemColumns = array_keys($this->SalesItem->getColumnTypes());

		$monthRecords = $this->SalesItem->find('all',
				array(
					'fields' => array('SalesItem.month'),
					'order' =>  array('SalesItem.month' =>'desc')
 					)
			);

		$months = array();
		foreach($monthRecords as $item){
			array_push($months, substr($item['SalesItem']['month'], 0,4). '年' . substr($item['SalesItem']['month'], 4,4). '月');
		}

		$selectedMonth;
		$selectedMonthID;
		if(isset($_POST['month'])){
			$selectedMonthID = $_POST['month'];
			$selectedMonth = $months[$selectedMonthID];
		}else{
			$selectedMonthID = 0;
			$selectedMonth = $months[$selectedMonthID];
		}
		$selectedMonth = preg_replace('/[^0-9]/','',$selectedMonth);
		

		//統計情報の取得（地域別）
		$salesRegion = $this->SalesRegion->find('first',
			array(
				'conditions' => array('SalesRegion.month' => $selectedMonth)
				)
			);

		$salesItem = $this->SalesItem->find('first',
			array(
				'conditions' => array('SalesItem.month' => $selectedMonth),
				)
			);

		$this->set('title_for_layout', '全国百貨店売上統計｜デパート情報百貨');
		$this->set(compact('regionColumns', 'itemColumns', 'salesRegion', 'salesItem', 'months', 'selectedMonth', 'selectedMonthID'));

	}
}