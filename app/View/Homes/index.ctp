<style type="text/css" media="screen">
	.jumbotron{
		height: 450px;
	    background: url("images/<?php echo $freeImages[rand(0,count($freeImages))]['Depart']['image_url'] ?>") center 0 no-repeat;
	    background-size: cover;
	}
	li{
		list-style: none;
	}
	.blog{
		font-size: 120%
	}
	ul{
		padding-left: 0;
	}
	#twitter{
		margin-left: 0;
	}
</style>
</div>
<div class="jumbotron">
  <h1>デパート情報百貨｜百貨店キュレーションサイト</h1>
</div>
<div class="container">
<div class="col-sm-7 leftContent">
	<h4>特集記事</h4>
	<?php foreach($blogs as $blog): ?>
		<ul>
			<li><?php echo $blog['Blog']['date'] ?>&nbsp;&nbsp;<a href="/blog/selectedBlog?id=<?php echo $blog['Blog']['id'] ?>"><?php echo $blog['Blog']['title'] ?> </a></li>
		</ul>
	<?php endforeach; ?>

	<h4>現在開催中の催事</h4>
	<?php $currentDepart = ""; ?>
	<?php foreach ($events as $key => $event): ?>
		<?php if($currentDepart != $event['Depart']['name']): ?>
		<p class="depart-title">--<?php echo  $event['Depart']['name'];?>--</p>
		<?php $currentDepart = $event['Depart']['name'];?>
		<?php endif; ?>
		<a href="<?php echo $event['EventInfo']['event_url'] ?>" target="_blank"><?php echo $event['EventInfo']['name']; ?></a>
		<span class="endDate">(~<?php echo $event['EventInfo']['end_month'] ?>/<?php echo $event['EventInfo']['end_day']; ?>まで)</span>
		<br>
	<?php endforeach; ?>
	
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

</div>
<div class="col-sm-5 rightContent">
	<div class="departSales">
		<h4>百貨店売上速報</h4>
		<table class="table table-condensed text-center">
			<tbody>
				<tr>
					<td rowspan="2"></td>
					<th class="text-center" colspan="2"><?php echo substr($salesRegion['SalesRegion']['month'],0,4) ?>年<?php echo substr($salesRegion['SalesRegion']['month'],4); ?>月</th>
				</tr>
				<tr>
					<th class="text-center">売上</th>
					<th class="text-center">前年比</th>
				</tr>
				<tr>
					<td>全国</td>
					<td><?php echo number_format($salesRegion['SalesRegion']['全国']) ?>円</td>
					<td><?php echo $salesRegion['SalesRegionYearOnYear']['全国']?>%</td>
				</tr>
				<tr>
					<td>東京</td>
					<td><?php echo number_format($salesRegion['SalesRegion']['東京']) ?>円</td>
					<td><?php echo $salesRegion['SalesRegionYearOnYear']['東京']?>%</td>
				</tr>
			</tbody>
		</table>
		<span class="note">※店舗数調整後　（　）が調整前 <a href="/statistics">もっとみる</a></span>
	</div>
	<div class = "ad">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- 横長スモール -->
		<ins class="adsbygoogle"
		     style="display:inline-block;width:320px;height:100px"
		     data-ad-client="ca-pub-2860154430701982"
		     data-ad-slot="7020132753"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</div>
	<h4 style="clear:both;">百貨店TOPニュース</h4>
	
	<ul id="feed"></ul>
	<div id = "twitter">
		<a class="twitter-timeline" data-width="300" data-height="800" data-theme="light" href="https://twitter.com/departinformat1/lists/departs">A Twitter List by departinformat1</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
	</div>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- departInfo -->
	<div class = "ad">
		<ins class="adsbygoogle"
		     style="display:block"
		     data-ad-client="ca-pub-2860154430701982"
		     data-ad-slot="1212603155"
		     data-ad-format="auto"></ins>
	</div>
</div>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("feeds", "1");
function initialize() {
	var feedurl = "https://news.google.com/news?ned=us&ie=UTF-8&oe=UTF-8&q=%E7%99%BE%E8%B2%A8%E5%BA%97&output=rss&num=30&hl=ja";
	var feed = new google.feeds.Feed(feedurl);
	feed.setNumEntries(12);
	feed.load(function (result){
		if (!result.error){
			var imageRss = "";
			var imageLessRss = "";
			for (var i = 0; i < result.feed.entries.length; i++) {
				var entry = result.feed.entries[i];
				var imgsrc = entry.content.match(/src="(.*?)"/igm);
				if(imgsrc){
					imageRss += '<div class = "media"><a class = "media-left" href="' + entry.link + '" target="_blank"><img ' + imgsrc + '></a><div class = "media-body"><a class = "media-left" href="' + entry.link + '" target="_blank">' + entry.title + '</a></div></div>';
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