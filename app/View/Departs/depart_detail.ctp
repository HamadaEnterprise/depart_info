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
	
	<ul id="feed"></ul>
	
</div>
<script type="text/javascript">
google.load("feeds", "1");
function initialize() {
	var feedurl = "<?php echo $selectedDepart['Depart']['rss_url'] ?>";
	var feed = new google.feeds.Feed(feedurl);
	feed.setNumEntries(15);
	feed.load(function (result){
		if (!result.error){
			for (var i = 0; i < result.feed.entries.length; i++) {
				var entry = result.feed.entries[i];
				var title = '<li><a href="' + entry.link + '" target="_blank">' + entry.title + '</a></li>';
				//var conte = '<li>' + entry.contentSnippet + '</li>';
				//var dates = '<li>' + entry.publishedDate + '</li>';
				$('#feed').append(title);
			}
		}
	});
}
google.setOnLoadCallback(initialize);
</script>