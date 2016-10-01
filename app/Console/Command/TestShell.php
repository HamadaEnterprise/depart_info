<?php 
App::import('Vendor', 'simple_html_dom');
//App::import('Vendor', 'goutte.phar');
//App::import('Vendor', 'phpQuery-onefile');
require_once 'goutte.phar';
use Goutte\Client;//スラッシュではない。\マーク。
use Symfony\Component\DomCrawler\Crawler;
class TestShell extends AppShell { 
	public $uses = array(
		'Depart',
		'EventInfo',
		'Category',
		'Region',
		'SalesRegion',
		'SalesRegionYearOnYear',
		'SalesItem',
		'SalesItemYearOnYear'
	);
	function main () {
		//$this->log('hogehoge','depart_log');
		$this->getAllEvents(); 
		//$this->out('test.'); // 標準出力には $this->out() を利用。 
	} 
	 
	 function test2 () { 
	    $this->out('test2.'); // 標準出力には $this->out() を利用。 
	 }

 	public function getAllEvents(){
		$this->startGetSogo();
		$this->startGetIsetanData();
		$this->startGetMitsukoshiData();
		$this->startGetTakashimayaData();
		$this->startGetJfrontData();
		$this->startGetTokyu();
		$this->startGetOdakyu();
		$this->startGetkeikyu();
		$this->startGetMatsuya();
		$this->startGetTobu();
		$this->startGetSeibu();
		$this->startGetKeio();
		$this->startGetKeioSakuragaoka();
		$this->categorize();
		$this->getEventInfoTimeStamp();
		exit;
	}

	public function startGetSeibu(){
		$seibuData = array();
		array_push($seibuData, array('url' => 'https://www.sogo-seibu.jp/ikebukuro/topics/?tenpo_id=010&topic_id=19' , 'departId' => '10', 'companyId' => '4', 'styleId' => '7',));
		foreach ($seibuData as $key => $eachSeibu) {
			$this->getSeibuAnchor($eachSeibu);
		}
	
	}

	public function getSeibuAnchor($seibuData){
		$client = new Client();	
		$client->setClient(new \GuzzleHttp\Client([
  		  \GuzzleHttp\RequestOptions::VERIFY => false,
			]));
		$crawler = $client->request('GET', $seibuData['url']);
		
		$crawler->filter('.listInner')->each(function($element,$key)use(&$seibuData){
			$Anchor = $element->filter('a')->attr('href');
			$Anchor = 'https://www.sogo-seibu.jp' . $Anchor;
			$this->getSeibu($seibuData, $Anchor);
        });

	}

	public function getSeibu($seibuData, $Anchor){
		$client = new Client();	
		$client->setClient(new \GuzzleHttp\Client([\GuzzleHttp\RequestOptions::VERIFY => false,]));
		$crawler = $client->request('GET', $Anchor);
		$name = $crawler->filter('.articleTtl01')->text();
		$eventInfo = array();
		$crawler->filter('#tenpoMainInner .sectionRead')->each(function($element,$key)use(&$eventInfo, &$Anchor, &$name, &$seibuData){
			if($key == 0){
				$date = $element->text();
				$date = preg_replace('/[\r\t]/', '', $date);
				//echo $date;
				$date = explode("\n", $date);
				foreach($date as $eachDate){
					if(strstr($eachDate, '会期')){
						$date = $eachDate;
						break;
					}
				}			
				$daysArray = $this->getDayMonth($date);
				array_shift($daysArray);
				$eachEvent = $this->setDays($daysArray, $seibuData);
				$eachEvent['name'] = $name;
				$eachEvent['event_url'] = $Anchor;
				array_push($eventInfo, $eachEvent);
			}
        });
        $this->saveData($eventInfo, '池袋西武');
	}
	public function startGetSogo(){
		$sogoData = array();
		array_push($sogoData, array('url' => 'https://www.sogo-seibu.jp/yokohama/topics/?tenpo_id=511&topic_id=340' , 'departId' => '27', 'companyId' => '4', 'styleId' => '6',));
		foreach ($sogoData as $key => $eachSogo) {
			$this->getSogoAnchor($eachSogo);
		}
	
	}

	public function getSogoAnchor($sogoData){
		$client = new Client();	
		$client->setClient(new \GuzzleHttp\Client([
  		  \GuzzleHttp\RequestOptions::VERIFY => false,
			]));
		$crawler = $client->request('GET', $sogoData['url']);
		
		$crawler->filter('.listInner')->each(function($element,$key)use(&$sogoData){
			$Anchor = $element->filter('a')->attr('href');
			$Anchor = 'https://www.sogo-seibu.jp' . $Anchor;
			$this->getSogo($sogoData, $Anchor);
        });

	}

	public function getSogo($sogoData, $Anchor){
		$client = new Client();	
		$client->setClient(new \GuzzleHttp\Client([\GuzzleHttp\RequestOptions::VERIFY => false,]));
		$crawler = $client->request('GET', $Anchor);
		$name = $crawler->filter('.articleTtl01')->text();
		$eventInfo = array();
		$crawler->filter('#tenpoMainInner .sectionRead')->each(function($element,$key)use(&$eventInfo, &$Anchor, &$name, &$sogoData){
			if($key == 0){
				$date = $element->text();
				$date = str_replace(array('\r\n','\r','\n'), '\n', $date);
				$date = preg_split("/\R/", trim($date));
				$daysArray = $this->getDayMonth($date[0]);
				if(strlen($daysArray[0]) > 2){
					array_shift($daysArray);
				}	
				$eachEvent = $this->setDays($daysArray, $sogoData);
				if($eachEvent){
					$eachEvent['name'] = $name;
					$eachEvent['event_url'] = $Anchor;
					array_push($eventInfo, $eachEvent);
				}
				
			}
        });
        if(count($eventInfo) != 0){
        	$this->saveData($eventInfo, 'そごう横浜');	
        }     
	}

	public function startGetTokyu(){
		$tokyuData = array();
		array_push($tokyuData, array('url' => 'http://www.tokyu-dept.co.jp/toyoko/event/list.html/' , 'departId' => '7', 'companyId' => '5', 'styleId' => '8',));
		array_push($tokyuData, array('url' => 'http://www.tokyu-dept.co.jp/honten/event/list.html/' , 'departId' => '6', 'companyId' => '5', 'styleId' => '8',));
		array_push($tokyuData, array('url' => 'http://www.tokyu-dept.co.jp/kichijouji/event/list.html/' , 'departId' => '19', 'companyId' => '5', 'styleId' => '8',));
		array_push($tokyuData, array('url' => 'http://www.tokyu-dept.co.jp/tama-plaza/event/list.html/' , 'departId' => '30', 'companyId' => '5', 'styleId' => '8',));

		foreach ($tokyuData as $key => $eachTokyu) {
			$this->getTokyu($eachTokyu);
		}

	}
	function getTokyu($tokyuData){
		$client = new Client();	
		$client->setClient(new \GuzzleHttp\Client([
  		  \GuzzleHttp\RequestOptions::VERIFY => false,
			]));
		$crawler = $client->request('GET',$tokyuData['url']);
		
		$eventInfo = array();
		$crawler->filter('div.news')->each(function($element,$key)use(&$eventInfo,&$tokyuData){
			$name = $element->filter('.text a')->text();
			$url = $element->filter('.text a')->attr('href');
			$url = 'http://www.tokyu-dept.co.jp'.$url;
			$date = $element->filter('.text ul li')->text();
			$date = preg_replace('/[0-9]*時/', '', $date);
			$daysArray = $this->getDayMonth($date);
			
			
			$eachEvent = $this->setDays($daysArray, $tokyuData);
			$eachEvent['name'] = $name;
			$eachEvent['url'] = $url;
			array_push($eventInfo, $eachEvent);
            
        });

        $this->saveData($eventInfo, '東急');
		
	}

	

	public function startGetIsetanData(){
		$isetanData = array();
		array_push($isetanData, array('url' => 'https://isetan.mistore.jp/store/fuchu/index.html' , 'departId' => '24', 'companyId' => '1', 'styleId' => '2'));
		array_push($isetanData, array('url' => 'http://isetan.mistore.jp/store/tachikawa/event/index.html' , 'departId' => '20', 'companyId' => '1', 'styleId' => '2'));
		array_push($isetanData, array('url' => 'https://isetan.mistore.jp/store/sagamihara/index.html' , 'departId' => '31', 'companyId' => '1', 'styleId' => '2'));
		array_push($isetanData, array('url' => 'https://isetan.mistore.jp/store/shinjuku/event/index.html' , 'departId' => '3', 'companyId' => '1', 'styleId' => '2'));
		array_push($isetanData, array('url' => 'https://isetan.mistore.jp/store/urawa/event/index.html' , 'departId' => '34', 'companyId' => '1', 'styleId' => '2'));
		array_push($isetanData, array('url' => 'https://isetan.mistore.jp/store/matsudo/index.html' , 'departId' => '43', 'companyId' => '1', 'styleId' => '2'));

		foreach ($isetanData as $key => $eachIsetan) {
			$this->getIsetan($eachIsetan);
		}

	}

	public function getIsetan($isetanData){
		$eventInfo = array();
		$html = file_get_html($isetanData['url']);
		foreach($html->find('.table-event-item') as $key=>$element){
			$str =  $element->find('dt')[0]->plaintext;
			//こめじるし足したのは試してないから注意
			$str = preg_replace('/[0-9]*時/', '', $str);
            $daysArray = $this->getDayMonth($str);
			$eachEvent = array();
			$eachEvent = $this->setDays($daysArray, $isetanData);
            $name = preg_replace('/[\n\r\t]/', '', $element->find('dd')[0]->plaintext);
            $eachEvent['name'] = $name;
            array_push($eventInfo, $eachEvent);
		}
		
		$this->saveData($eventInfo, '伊勢丹');

	}

	public function startGetMitsukoshiData(){
		$mitsukoshiData = array();
		array_push($mitsukoshiData, array('url' => 'http://mitsukoshi.mistore.jp/store/nihombashi/event/index.html' , 'departId' => '16', 'companyId' => '1', 'styleId' => '1', 'maxEventNumber' => '11', 'minEventNumber' => '3'));
		array_push($mitsukoshiData, array('url' => 'http://mitsukoshi.mistore.jp/store/ginza/event/index.html' , 'departId' => '17', 'companyId' => '1', 'styleId' => '1', 'maxEventNumber' => '9', 'minEventNumber' => '2'));
		/*array_push($mitsukoshiData, array('url' => 'http://mitsukoshi.mistore.jp/store/ebisu/event/index.html' , 'departId' => '', 'companyId' => '1', 'styleId' => '1'));*/
		array_push($mitsukoshiData, array('url' => 'http://mitsukoshi.mistore.jp/store/chiba/event/index.html' , 'departId' => '40', 'companyId' => '1', 'styleId' => '1', 'maxEventNumber' => '6', 'minEventNumber' => '0'));

		foreach ($mitsukoshiData as $eachMituskoshi) {
			$this->getMitsukoshi($eachMituskoshi);
		}
		

	}

	public function getMitsukoshi($mitsukoshiData){
		
		$html = file_get_html($mitsukoshiData['url']);
		$classSelector = array('.table-event-month_prev', '.table-event-month_next');

		$beforeName = "";
		//前半分と後半分のカレンダーで２回回す
		foreach ($classSelector as $key => $table){
			$eventInfo = array();
			foreach($html->find($table . ' .table-event-item') as $element){
				
				if(isset($element->find('dd')[0]->plaintext)){
					$name = preg_replace('/[\n\r\t]/', '', $element->find('dd')[0]->plaintext);
					$name = preg_replace('/\s(?=\s)/', '', $name);
					if($beforeName == $name){
						continue;
					}
					if($name != "会場準備" && $name != "催物準備"){
						$str =  $element->find('dt')[0]->plaintext;
						$str = preg_replace('/[0-9]時/', '', $str);
						//エスケープ文字を削除
						$str = preg_replace('/\&.*;/','',$str);
			            $daysArray = $this->getDayMonth($str);
						$eachEvent = $this->setDays($daysArray, $mitsukoshiData);
						if(!$eachEvent){
							continue;
						}
			            $eachEvent['name'] = $name;
					
						$beforeName = $name;

						array_push($eventInfo, $eachEvent);
						if(count($eventInfo) >$mitsukoshiData['maxEventNumber']){
							break;
						}
					}
				}
			
			}
			for($i = 0; $i < $mitsukoshiData['minEventNumber']; $i++ ){
				unset($eventInfo[$i]);
			}
		}
		$this->saveData($eventInfo, '三越');
	}
	public function startGetTakashimayaData(){
		$takashimayaData = array();
		array_push($takashimayaData, array('url' => 'https://www.takashimaya.co.jp/shinjuku/event/index.html' , 'departId' => '5', 'companyId' => '3', 'styleId' => '5'));
		array_push($takashimayaData, array('url' => 'http://www.takashimaya.co.jp/tokyo/event/index.html' , 'departId' => '14', 'companyId' => '3', 'styleId' => '5'));
		array_push($takashimayaData, array('url' => 'http://www.takashimaya.co.jp/tamagawa/event/index.html' , 'departId' => '18', 'companyId' => '3', 'styleId' => '5'));
		array_push($takashimayaData, array('url' => 'http://www.takashimaya.co.jp/tachikawa/event/index.html' , 'departId' => '21', 'companyId' => '3', 'styleId' => '5'));
		array_push($takashimayaData, array('url' => 'http://www.takashimaya.co.jp/yokohama/event/index.html' , 'departId' => '28', 'companyId' => '3', 'styleId' => '5'));
		array_push($takashimayaData, array('url' => 'http://www.takashimaya.co.jp/konandai/event/index.html' , 'departId' => '29', 'companyId' => '3', 'styleId' => '5'));
		array_push($takashimayaData, array('url' => 'http://www.takashimaya.co.jp/omiya/event/index.html' , 'departId' => '35', 'companyId' => '3', 'styleId' => '5'));
		array_push($takashimayaData, array('url' => 'http://www.takashimaya.co.jp/kashiwa/event/index.html' , 'departId' => '45', 'companyId' => '3', 'styleId' => '5'));

		foreach ($takashimayaData as $key => $eachTakashimaya) {
			$this->getTakashimaya($eachTakashimaya);
		}

		

	}

	function getTakashimaya($takashimayaData){
		// Change this to point to your newly downloaded CA file
		$caFile = '/path/to/certs/cacert.pem';
		// Create a stream context to pass the relevant SSL information
		$context = stream_context_create(array('ssl' => array(
		    'verify_peer' => false,
		    'verify_peer_name' => false,
		    'allow_self_signed' => false,
		    'cafile' => $caFile,
		)));
		$html = file_get_html($takashimayaData['url'], false, $context);

		$eventInfo = array();
		foreach($html->find('#items li.seg') as $element){
			$name = $element->find('h4')[0]->plaintext;
			$name = preg_replace('/[\n\r\t]/', '', $name);
			$name = preg_replace('/\s(?=\s)/', '', $name);
			$daysString = preg_split("/\R/", $element->find('ul li')[0]->plaintext);
			$daysArray = $this->getDayMonth($daysString[0]);
			$eachEvent = array();
			$eachEvent = $this->setDays($daysArray, $takashimayaData);
			if(!$eachEvent){	
				continue;
			}
            $eachEvent['name'] = $name;
            array_push($eventInfo, $eachEvent);
		}

		$this->saveData($eventInfo, '高島屋');
		
	}
	public function startGetJfrontData(){
		$jfrontData = array();
		array_push($jfrontData, array('url' => 'http://www.daimaru.co.jp/tokyo/event/index.html' , 'departId' => '8', 'companyId' => '2', 'styleId' => '3', 'daimaruFlg' => true));
		array_push($jfrontData, array('url' => 'http://www.matsuzakaya.co.jp/ueno/event/index.html' , 'departId' => '12', 'companyId' => '2', 'styleId' => '4', 'daimaruFlg' => false));

		foreach ($jfrontData as $key => $eachJfront) {
			$this->getJfront($eachJfront);
		}

		

	}
	function getJfront($daimaruData){
		
		$html = file_get_html($daimaruData['url']);
		$eventInfo = array();
		foreach($html->find('.eventTable')[0]->find('tr') as $element){
			$name = $element->find('.eventName')[0]->plaintext;
			$daysArray = $this->getDayMonth($element->find('td')[0]->plaintext);
			//大丸の場合は年号を消す（松坂屋に年号はない）
			if($daimaruData['daimaruFlg']){
				array_shift($daysArray);
			}
			$eachEvent = $this->setDays($daysArray, $daimaruData);
			if(!$eachEvent){	
				continue;
			}
			$eachEvent['name'] = $name;
			//urlが設定されている場合は設定
			if(isset($element->find('.eventName a')[0]->href)){
				$url = $element->find('.eventName a')[0]->href;
				$eachEvent['event_url'] = $url;
			}
			array_push($eventInfo, $eachEvent);
		}
		$this->saveData($eventInfo, '大丸松坂屋');
	}
	public function startGetOdakyu(){
		$odakyuData = array();
		array_push($odakyuData, array('url' => 'http://www.odakyu-dept.co.jp/shinjuku/event/index.html' , 'departId' => '1', 'companyId' => '6', 'styleId' => '9'));
		array_push($odakyuData, array('url' => 'http://www.odakyu-dept.co.jp/machida/event/index.html' , 'departId' => '22', 'companyId' => '6', 'styleId' => '9'));
		array_push($odakyuData, array('url' => 'http://www.odakyu-dept.co.jp/fujisawa/event/index.html' , 'departId' => '32', 'companyId' => '6', 'styleId' => '9'));
		foreach ($odakyuData as $key => $eachOdakyu) {
			$this->getOdakyu($eachOdakyu);
		}

		
	}

	function getOdakyu($odakyuData){
		
		$html = file_get_html($odakyuData['url']);
		$html = $html->find('.tab0');
		$eventInfo = array();
		$beforeName = '';
		foreach($html[0]->find('.calender-area tr') as $key => $element){
			if(isset($element->find('td')[0]->plaintext)){
				//最後に半角スペースが入っているのでtrimしておく
				$name = trim($element->find('td')[0]->plaintext);
				$date = trim($element->find('.period')[0]->plaintext);
				if($name == '閉場' || $name == $beforeName){
					continue;
				}
				$daysArray = $this->getDayMonth($date);
				$eachEvent = $this->setDays($daysArray, $odakyuData);
				$eachEvent['name'] = $name;
				if(isset($element->find('td a')[0])){
					$url = $element->find('td a')[0]->href;
					$eachEvent['event_url'] = 'http://www.odakyu-dept.co.jp' . $url;
				}

				$beforeName = $name;
				array_push($eventInfo, $eachEvent);
			}
			//$this->saveData($eventInfo, '小田急');
			
		}
		$this->saveData($eventInfo, '小田急');
	}
	public function startGetkeikyu(){
		$keikyuData = array();
		array_push($keikyuData, array('url' => 'http://www.keikyu-depart.com/kqdep/calendar/index.html' , 'departId' => '25', 'companyId' => '11', 'styleId' => '15'));
		foreach ($keikyuData as $key => $eachOdakyu) {
			$this->getKeikyu($eachOdakyu);
		}

		
	}

	function getKeikyu($keikyuData){
		
		$html = file_get_html($keikyuData['url']);
		$eventInfo = array();
		foreach($html->find('a.link-contain') as $key => $element){
			$date = $element->find('li')[0]->plaintext;
			//pタグの中にテキスト全て入ってしまっているので日付でスプリットかけて０番目を取得する
			$splitedInfo = explode($date ,$element->find('p')[0]->plaintext);
			$name = $splitedInfo[0];

			$daysArray = $this->getDayMonth($date);
			
			$eachEvent = $this->setDays($daysArray, $keikyuData);
			$eachEvent['name'] = $name;

			$url = 'http://www.keikyu-depart.com/' . $element->href;
			$eachEvent['event_url'] = $url;
			array_push($eventInfo, $eachEvent);

		}
		$this->saveData($eventInfo, '京急');
	}

	public function startGetMatsuya(){
		$matsuyaData = array();
		array_push($matsuyaData, array('url' => 'http://www.matsuya.com/m_ginza/event/' , 'departId' => '15', 'companyId' => '10', 'styleId' => '14'));
		foreach ($matsuyaData as $key => $eachOdakyu) {
			$this->getMatsuya($eachOdakyu);
		}

		
	}

	function getMatsuya($matsuyaData){
		
		$html = file_get_html($matsuyaData['url']);
		$eventInfo = array();
		foreach($html->find('.item-inner') as $key => $element){
			$dateNameArray;
			if(isset($element->find('.text-bold')[0])){
				$dateAndName = $element->find('.text-bold')[0]->plaintext;
				$dateNameArray = explode("\n", $dateAndName);
			}else{
				$dateAndName = $element->find('p')[1]->plaintext;
				$dateNameArray = explode("\n", $dateAndName);
			}
			if($element->find('a')){
				$url = $element->find('a')[0]->href;
			}

			$daysArray = $this->getDayMonth($dateNameArray[0]);
			//年号を消す
			array_shift($daysArray);

			$eachEvent = $this->setDays($daysArray, $matsuyaData);
			$eachEvent['name'] = $dateNameArray[1];

			//リンクが有る場合
			if($element->find('a')){
				$url = $element->find('a')[0]->href;
				$eachEvent['event_url'] = 'http://www.matsuya.com' . $url;
			}
			array_push($eventInfo, $eachEvent);
		}
		$this->saveData($eventInfo, '松屋');
	}

	function startGetKeio(){
		$keioData = array();
		array_push($keioData, array('url' => 'http://info.keionet.com/shinjuku/ebook/index.html#shi160714_2' , 'departId' => '2', 'companyId' => '7', 'styleId' => '10'));
		foreach ($keioData as $key => $eachKeio) {
			$this->getKeio($eachKeio);
		}
	}

	function getKeio($keioData){
		$html = file_get_html($keioData['url']);
		$eventInfo = array();
		foreach($html->find('.waku640') as $key => $element){
			foreach($element->find('li') as $key2 => $item){
				$title;
				$date;
				$wholeText = $item->plaintext;
				$wholeTextArray = preg_split("/\R/", trim($wholeText));
				if(isset($wholeTextArray[1])){
					$title = $wholeTextArray[0];
					$date = $wholeTextArray[1];	
				}else{
					continue;
				}
				
				$daysArray = $this->getDayMonth($date);
				$eachEvent = $this->setDays($daysArray, $keioData);
				$eachEvent['name'] = $title;

				if(count($eachEvent) == 11){
					array_push($eventInfo, $eachEvent);		
				}
			}
		}
		$this->saveData($eventInfo,'京王百貨店新宿店');
	}

	function startGetKeioSakuragaoka(){
		$keioData = array();
		array_push($keioData, array('url' => 'http://info.keionet.com/seisekisakuragaoka/' , 'departId' => '23', 'companyId' => '7', 'styleId' => '10'));
		foreach ($keioData as $key => $eachKeio) {
			$this->getKeioSakuragaoka($eachKeio);
		}
	}

	function getKeioSakuragaoka($keioData){
		$html = file_get_html($keioData['url']);
		$eventInfo = array();

		$leftRightArray = array('left', 'right');
		foreach($leftRightArray as $class){
			foreach($html->find('.' . $class) as $key => $element){
				foreach($element->find('li') as $key2 => $item){
					$title;
					$date;
					$wholeText = $item->plaintext;
					$wholeTextArray = preg_split("/\R/", trim($wholeText));
					if(isset($wholeTextArray[1])){
						$title = $wholeTextArray[0];
						$date = $wholeTextArray[1];	
					}else{
						continue;
					}
					
					$daysArray = $this->getDayMonth($date);
					$eachEvent = $this->setDays($daysArray, $keioData);
					$eachEvent['name'] = $title;

					if(count($eachEvent) == 11){
						array_push($eventInfo, $eachEvent);		
					}
				}
			}
		}
		$this->saveData($eventInfo, '京王聖蹟桜ヶ丘');
	}
	
	public function startGetTobu(){
		$tobuData = array();
		array_push($tobuData, array('url' => 'http://www.tobu-dept.jp/ikebukuro/event/' , 'departId' => '11', 'companyId' => '9', 'styleId' => '13', 'eventClass' => 'detail_ttl_10f'));
		array_push($tobuData, array('url' => 'http://www.tobu-dept.jp/funabashi/event/' , 'departId' => '42', 'companyId' => '9', 'styleId' => '13', 'eventClass' => 'detail_ttl_f6f'));
		foreach ($tobuData as $key => $eachTobu) {
			$this->getTobuAnchor($eachTobu);
		}

		
	}

	function getTobuAnchor($tobuData){
		
		$html = file_get_html($tobuData['url']);
		foreach($html->find('.f10_thumbnail') as $key => $element){
			$Anchor = $element->find('a')[0]->href;
			$this->getTobu($tobuData, $Anchor);
		}
	}

	function getTobu($tobuData, $Anchor){
		$html = file_get_html($Anchor);
		$eventInfo = array();
		foreach($html->find('.'.$tobuData['eventClass']) as $key => $element){
			$name = $element->find('.ttl')[0]->plaintext;
			$date = $element->find('.txt')[0]->plaintext;
			$date = explode("\n", $date);
			$daysArray = $this->getDayMonth($date[0]);

			$eachEvent = $this->setDays($daysArray, $tobuData);
			if($eachEvent == null){
				continue;
			}
			$eachEvent['name'] = $name;
			$eachEvent['event_url'] = $Anchor;

			array_push($eventInfo, $eachEvent);
		}
		$this->saveData($eventInfo, '東武');
	}

	function categorize(){
		$events = $this->EventInfo->find('all', array(
			'conditions' => array(
				'categorized' => '0',
				'EventInfo.is_deleted' => '0'
				)));

		
		
		$foods =array('グルメ','北海道','うまい','大自然','食品','福岡','四国','物産','九州','味','築地','マルシェ','ワイン','菓子','スイーツ','おいしい');
		$fashions = array('ファション','ワコール','サイズ','バーゲン','23区','パンツ','ジュエリー','婦人','紳士','雑貨','ランジェリー','レディス','メンズ','トリンプ','ブランド','バザール','イージーオーダー','ウェディング','ハンドバッグ','アクセサリ','バッグ','振袖','フォーマル','こども服');
		foreach($events as $key=> $event){
			foreach($foods as $food){
				if(strstr($event['EventInfo']['name'], $food)){
					$events[$key]['EventInfo']['category'] = '1';
					$events[$key]['EventInfo']['categorized'] = '1';
					continue 2;
				}

			}
			foreach($fashions as $fashion){
				if(strstr($event['EventInfo']['name'], $fashion)){
					$events[$key]['EventInfo']['category'] = '2';
					$events[$key]['EventInfo']['categorized'] = '1';
					continue 2;
				}
			}
			$events[$key]['EventInfo']['category'] = '3';
			$events[$key]['EventInfo']['categorized'] = '1';
		}
		
		
		foreach ($events as $key => $event) {
			$this->EventInfo->save($event);
		}
		
	}


	//数字以外の文字列をスペースに置き換え、複数スペースを一つのスペースに置き換え、先頭と末尾のスペースを削除
	function getDayMonth($str){
		$str = preg_replace('/[^0-9]/', ' ', $str);
        $str = preg_replace('/\s(?=\s)/', '', $str);
        $str = trim($str);
        $daysArray = split(' ', $str);
        return $daysArray;
	}

	function setDays($daysArray, $departData){
		$eachEvent = array();
		
		if(count($daysArray) == 4){
        	$eachEvent['start_month'] = $daysArray[0]; 
        	$eachEvent['start_day'] = $daysArray[1]; 
        	$eachEvent['end_month'] = $daysArray[2]; 
        	$eachEvent['end_day'] = $daysArray[3]; 
        }elseif(count($daysArray) == 3){
        	$eachEvent['start_month'] = $daysArray[0]; 
        	$eachEvent['start_day'] = $daysArray[1]; 
        	$eachEvent['end_month'] = $daysArray[0]; 
        	$eachEvent['end_day'] = $daysArray[2]; 
        }else{
        	return null;
        }
        $thisMonth = date('m');
		$thisYear = date('Y');
		$nextYear = date('Y', strtotime('+1 year'));
		$startyear;
		$endYear;
		if($eachEvent['start_month'] <= $eachEvent['end_month']){
			$startYear = $thisYear;
			$endYear = $thisYear;
		}else{
			$startYear = $nextYear;
			$endYear = $nextYear;
		}
		
		$eachEvent['start_year'] = $startYear;
		$eachEvent['end_year'] = $endYear;
        $eachEvent['depart_id'] = $departData['departId'];
        $eachEvent['company_id'] = $departData['companyId'];
        $eachEvent['style_id'] = $departData['styleId'];
        $eachEvent['event_url'] = $departData['url'];
        return $eachEvent;
	}

	function saveData($eventInfo, $departName){
		$totalAffectedRows = 0;
		foreach($eventInfo as $data){
        	$this->EventInfo->create(false);
        	$eventName = $this->EventInfo->findByName($data['name']);
        	if($eventName){
        		$data['id'] = $eventName['EventInfo']['id'];
        	}
			$this->EventInfo->save($data);
			$count = $this->EventInfo->getAffectedRows();
			$totalAffectedRows += $count;
    	}
    	$this->log($departName. 'の更新件数は'. $totalAffectedRows. "でした\n", 'depart_log');
	}

	function endKey($array){
	    end($array);
	    return key($array);
	}
	function getEventInfoTimeStamp(){
		$events = $this->EventInfo->find('all',
			array(
				'conditions' => array('EventInfo.is_deleted' => 0)
				)
			);
		
		$updatedEvents = array();
		foreach($events as $event){
			$startTimeStamp = mktime(0,0,0,$event['EventInfo']['start_month'],$event['EventInfo']['start_day'],$event['EventInfo']['start_year']);
			$endTimeStamp = mktime(0,0,0,$event['EventInfo']['end_month'],$event['EventInfo']['end_day'],$event['EventInfo']['end_year']);
			$event['EventInfo']['start_timestamp'] = $startTimeStamp;
			$event['EventInfo']['end_timestamp'] = $endTimeStamp;
			array_push($updatedEvents, $event['EventInfo']);
		}
		/*echo "<pre>";
		print_r($updatedEvents);
		echo "</pre>";*/
		$this->saveData($updatedEvents, 'タイムスタンプ更新');
		exit;
	}
}