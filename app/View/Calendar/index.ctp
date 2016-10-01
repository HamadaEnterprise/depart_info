<div class="col-sm-10 leftContent">
	<h4><?php echo $thisMonth ?>月開催の催事</h4>
		<div class="row">
		<div class = "monthNav col-sm-6">
		<?php if($_GET['month'] == "last"): ?>
			先月の催事<a href="/calendar?month=this">今月の催事</a><a href="/calendar?month=next">来月の催事</a>
		<?php endif; ?>
		<?php if($_GET['month'] == "this"): ?>
			<a href="/calendar?month=last">先月の催事</a>今月の催事<a href="/calendar?month=next">来月の催事</a>
		<?php endif; ?>
		<?php if($_GET['month'] == "next"): ?>
			<a href="/calendar?month=last">先月の催事</a><a href="/calendar?month=this">今月の催事</a>来月の催事
		<?php endif; ?>
		</div>
		<div class="form-inline col-sm-6">
			<?php echo $this->Form->create(false, array('type' => 'post')); ?>
			<?php echo $this->Form->input('カテゴリー↓', array('type' => 'select','selected' => $selectedCategory[0] ,  'options' => $sortedCategories, 'class' => 'form-control' ,'name' =>'selectedCategory', 'div' => array('class' => 'form-group'))) ?>
			<?php echo $this->Form->input('地域↓', array('type' => 'select', 'selected' => $selectedRegion[0], 'options' => $sortedRegion, 'class' => 'form-control', 'name' => 'selectedRegion', 'div' => array('class' => 'form-group'))); ?>
			<?php echo $this->Form->submit('検索', array('div'=>false,'class' => 'btn-primary','name' => 'delete')); ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
	<table class="table">
		<th>日</th><th>催事情報</th>
		<?php for($day = 1; $day <= intval(strtotime(date('y-m-'.$day).$maxDay)) ; $day++ ): ?>
			<tr>
				<?php if(isset($sortedEvents[$day])):?>
				
					<td><?php echo $day ?>日(<?php echo $weekday[date('w',strtotime(date('y-m-'.$day).$maxDay))]; ?>)</td>
					<td>
						
						<?php foreach ($sortedEvents[$day] as $key => $event):?>
							<a href="<?php echo $event['EventInfo']['event_url'] ?>" target="_blank"><?php echo $event['EventInfo']['name']; ?></a>
							<span class="endDate">(~<?php echo $event['EventInfo']['end_month'] ?>/<?php echo $event['EventInfo']['end_day']; ?></span>
							<a href="<?php echo $event['Depart']['url']; ?>" target="_blank">@<?php echo $event['Depart']['name']; ?>)</a>
							<br>
							<?php if($key == 5): ?>
								<div class="moreInfo">
							<?php endif; ?>
								<?php if($key >= 5 && $event == end($sortedEvents[$day])): ?>
									<span class="moreButton">もっと見る</span><a href="/dayDetail?day=<?php echo $day ?>&month=<?php echo $thisMonth ?>">(全<?php echo count($sortedEvents[$day]) ?>件)</a>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
					</td>
			</tr>
		<?php endfor; ?>


	</table>
</div>

<div class="col-sm-2 rightContent">
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- departInfo -->
	<ins class="adsbygoogle"
	     style="display:block;margin-top: 100px;"
	     data-ad-client="ca-pub-2860154430701982"
	     data-ad-slot="1212603155"
	     data-ad-format="auto"></ins>
	<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
	
</div>
<script type="text/javascript">
	$(function () {
	    $('.moreButton').prevAll().hide();
	    $('.moreButton').click(function () {
	        if ($(this).attr('class') !='moreButton closed') {
	            $(this).prevAll().slideDown('fast');
	            $(this).text('閉じる').addClass('closed');
	        } else {
	            $(this).prevAll().slideUp('fast');
	            $(this).text('もっと見る').removeClass('closed');
	        }
	    });
	});
</script>