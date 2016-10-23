
<div class="col-sm-8 leftContent">
	
	<h3 class="title"><?php echo $blogsTitle ?></h3>	

	<?php foreach($blogs as $key => $blog): ?>
		<p class = "articleDate"><?php echo $blog['Blog']['date'] ?> </p>
		<h4 class = "articleTitle"><?php echo $blog['Blog']['title']; ?></h4>
		<hr width="80%" align="left">
		<?php echo $blog['Blog']['text']; ?>
		<?php if($key != count($blogs) - 1): ?>
			<p class = "deliminator"><?php echo '* * *' ?></p>
		<?php endif; ?>
	<?php endforeach; ?>


</div>

<div class="col-sm-4 rightContent">
	<div class = "recent-blogs">
		<h4 class = "latest-blogs">記事一覧</h4>
		<?php foreach($blogs as $blog): ?>
			<ul>
				<li><a href="/blog/selectedBlog?id=<?php echo $blog['Blog']['id'] ?>"><?php echo $blog['Blog']['title'] ?> </a></li>
			</ul>
		<?php endforeach; ?>
	</div>
	<div　class = "blog-rankings">
		<table class = "blog-rankings-table">
			<tbody>
				<tr>
					<td><a href="//business.blogmura.com/ryutugyou/ranking.html" target="_blank"><img id = "blogVillage"  src="//business.blogmura.com/ryutugyou/img/ryutugyou88_31.gif" width="88" height="31" border="0" alt="にほんブログ村 企業ブログ 卸売・小売業へ" /></a><br /><a href="//business.blogmura.com/ryutugyou/ranking.html" target="_blank"></a></td>
					<td><a href="http://blog.with2.net/link.php?1869083:1568" title="小売・飲食業 ブログランキングへ" target="_blank"><img id = "blogRanking"  src="http://blog.with2.net/img/banner/c/banner_1/br_c_1568_1.gif" width="110" height="31" border="0" /></a><br /><a href="http://blog.with2.net/link.php?1869083:1568" style="font-size:12px;" target="_blank"></a></td>
				</tr>
			</tbody>
		</table>
	</div>

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
	.deliminator{
		font-size: 200%;
		text-align: center;
	}
	#blogVillage, #blogRanking{
		display: inline;
		margin-bottom: 10px;
	}

</style>