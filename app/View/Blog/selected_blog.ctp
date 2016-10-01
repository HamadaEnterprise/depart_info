
<div class="col-sm-8 leftContent">
	
	<h3 class="title">記事特集</h3>
	<p class = "articleDate"><?php echo $selectedBlog['Blog']['date'] ?> </p>
	<h4 class = "articleTitle"><?php echo $selectedBlog['Blog']['title']; ?></h4>
	<hr width="80%" align="left">
	



	<?php echo $selectedBlog['Blog']['text']; ?>
	


</div>

<div class="col-sm-4 rightContent">
	
	<h4>記事一覧</h4>
	<?php foreach($blogs as $blog): ?>
		<ul>
			<li><a href="/blog/selectedBlog?id=<?php echo $blog['Blog']['id'] ?>"><?php echo $blog['Blog']['title'] ?> </a></li>
		</ul>
	<?php endforeach; ?>	

	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- departInfo -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2860154430701982"
     data-ad-slot="1212603155"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
<style type="text/css">
	h3.title{
		text-align: center;
	}
	h4.articleTitle{
		text-align: left;
		margin-top: 0;
	}
	p.articleDate{
		margin-bottom: 0;
		margin-left: 5px;
	}
	li{
		list-style: none;
	}

</style>
