<style type="text/css" media="screen">
	.jumbotron{
		height: 450px;
	    background: url("images/<?php echo $freeImages[rand(0,count($freeImages))]['Depart']['image_url'] ?>") center 0 no-repeat;
	    background-size: cover;
	}
</style>
</div>
<div class="jumbotron">
  <h1>デパートまとめ</h1>
</div>
<div class="container">
<div class="col-sm-7 leftContent">
	<h4>現在開催中の催事</h4>
	<?php foreach ($events as $key => $event): ?>
		<a href="<?php echo $event['EventInfo']['event_url'] ?>" target="_blank"><?php echo $event['EventInfo']['name']; ?></a>
		<span class="endDate">(~<?php echo $event['EventInfo']['end_month'] ?>/<?php echo $event['EventInfo']['end_day']; ?>まで</span>
		<a href="<?php echo $event['Depart']['url']; ?>" target="_blank">@<?php echo $event['Depart']['name']; ?>)</a>
		<br>
	<?php endforeach; ?>
</div>
<div class="col-sm-5 rightContent">
	<div class="departSales">
		<h4>百貨店売上速報</h4>
		<table class="table table-condensed text-center">
			<tbody>
				<tr>
					<td rowspan="2"></td>
					<th class="text-center" colspan="2"><?php echo substr($latestStatisticsDate,0,4) ?>年<?php echo substr($latestStatisticsDate,5,2); ?>月</th>
				</tr>
				<tr>
					<th class="text-center">売上</th>
					<th class="text-center">前年比</th>
				</tr>
				<tr>
					<td>全国</td>
					<td><?php echo number_format($salesRegion[0]['SalesRegion'][$latestStatisticsDate]) ?>円</td>
					<td><?php echo number_format(($salesRegion[0]['SalesRegion'][$latestStatisticsDate] / $salesRegion[0]['SalesRegion'][$latestStatisticsDate-100] - 1) * 100,1) ?>%</td>
				</tr>
				<tr>
					<td>東京</td>
					<td><?php echo number_format($salesRegion[1]['SalesRegion'][$latestStatisticsDate]) ?>円</td>
					<td><?php echo number_format(($salesRegion[1]['SalesRegion'][$latestStatisticsDate] / $salesRegion[1]['SalesRegion'][$latestStatisticsDate-100] - 1) * 100,1) ?>%</td>
				</tr>
			</tbody>
		</table>
	</div>
	<h4>百貨店TOPニュース</h4>
	
	<ul id="feed"></ul>
	
</div>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("feeds", "1");
function initialize() {
	var feedurl = "https://news.google.com/news?ned=us&ie=UTF-8&oe=UTF-8&q=%E7%99%BE%E8%B2%A8%E5%BA%97&output=rss&num=30&hl=ja";
	var feed = new google.feeds.Feed(feedurl);
	feed.setNumEntries(10);
	feed.load(function (result){
		if (!result.error){
			var imageRss = "";
			var imageLessRss = "";
			for (var i = 0; i < result.feed.entries.length; i++) {
				var entry = result.feed.entries[i];
				var imgsrc = entry.content.match(/src="(.*?)"/igm);
				if(imgsrc){
					imageRss += '<div class = "media"><a class = "media-left" href="' + entry.link + '" target="_blank"><img ' + imgsrc + '></a><div class = "media-body">' + entry.title + '</div></div>';
					console.log(imageRss);
				}else{
					imageLessRss += '<li><a href="' + entry.link + '" target="_blank">' + entry.title + '</a></li>';
				}
                
         
				
			}
			$('#feed').append(imageRss);
			$('#feed').append(imageLessRss);			
		}
	});
}
google.setOnLoadCallback(initialize);
</script>