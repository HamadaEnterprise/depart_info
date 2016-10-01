<style type="text/css" media="screen">
	.jumbotron{
		height: 510px;
	    background: url("images/<?php echo $selectedDepart['Depart']['image_url'] ?>") center 0 no-repeat;
	    background-size: cover;
	}
</style>
</div>
<div class="jumbotron">
  <h1><?php echo $selectedDepart['Depart']['name'] ?></h1>
</div>
<div class="container">
<?php if(!empty($selectedDepart['Depart']['wiki_url'])): ?>
<p class = "photoby"><?php echo $selectedDepart['Depart']['wiki_url'] ?></p>
<?php endif; ?>
<ul class="departDetailList">
	<li>住所：<?php echo $selectedDepart['Depart']['address']; ?></li>
	<li>TEL:<?php echo $selectedDepart['Depart']['tel'] ?></li>
	<li><a href="<?php echo $selectedDepart['Depart']['url'] ?>" target = "_blank"><?php echo $selectedDepart['Depart']['name'] ?>のホームページ</a></li>
</ul>
<div class="col-sm-7 leftContent">
<h5>開催中・開催予定のイベント一覧</h5>
<ul>
	<?php foreach($selectedDepartEvents as $event): ?>
		<li><a href="<?php echo $event['EventInfo']['event_url'] ?>" target = "_blank"><?php echo $event['EventInfo']['name'] ?></a>(<?php echo $event['EventInfo']['start_month'] . '/'. $event['EventInfo']['start_day'] ?>~<?php echo $event['EventInfo']['end_month'] . '/'. $event['EventInfo']['end_day'] ?>)</li>
	<?php endforeach; ?>
</ul>
</div>
<div class="col-sm-5 rightContent">
	<h4><?php echo $selectedDepart['Depart']['name'] ?>TOPニュース</h4>
	
	<ul id="feed">
   <?php
      $rss = simplexml_load_file($selectedDepart['Depart']['rss_url']);
      $imageNews="";
      $stringNews="";
      foreach($rss->channel->item as $item){
        $title = $item->title;
        $date = date("Y年 n月 j日", strtotime($item->pubDate));
        $link = $item->link;
        $description = mb_strimwidth (strip_tags($item->description), 0 , 50, "…Read More", "utf-8");

        preg_match('/<img.*?src=(["\'])(.+?)\1.*?>/i', $item->description, $entryimg);
        $src = null;
        if(isset($entryimg[2]))$src = $entryimg[2];
       


        if($src){
          $imageNews = $imageNews . '<div class = "media"><a class = "media-left" href="' . $link . '" target="_blank"><img src="' . $src . '" alt=""></a><div class = "media-body"><a href="' . $link . '">' . $title. ' </a></div></div>';
        }else{
          $stringNews = $stringNews . '<li><a href="' . $link . '" target="_blank"><span class="title">' . $title. ' ; ?></span></a></li>';
        }
     }
     echo $imageNews . $stringNews;
      ?>
     
      
      

  </ul>
	
</div>

  