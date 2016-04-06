<h5>カレンダーから探す</h5>
<div class="col-sm-9 leftContent">
	<h4>催事カレンダー</h4>
	<p><?php echo $thisMonth ?>月</p>
	<div class="form-inline">
	<?php echo $this->Form->create(false, array('type' => 'post')); ?>
	<?php echo $this->Form->input('カテゴリー', array('type' => 'select','selected' => $selectedCategory[0] ,  'options' => $sortedCategories, 'class' => 'form-control' ,'name' =>'selectedCategory', 'div' => array('class' => 'form-group'))) ?>
	<?php echo $this->Form->input('地域', array('type' => 'select', 'selected' => $selectedRegion[0], 'options' => $sortedRegion, 'class' => 'form-control', 'name' => 'selectedRegion', 'div' => array('class' => 'form-group'))); ?>
	<?php echo $this->Form->submit('検索', array('div'=>false,'class' => 'form-control','name' => 'delete')); ?>
	<?php echo $this->Form->end(); ?>
	</div>
	<table class="table">
		<th>日</th><th>催事情報</th>
		<?php for($day = 1; $day <= intval(strtotime(date('y-m-'.$day).'-2 month')) ; $day++ ): ?>
			<tr>
				<?php if(isset($sortedEvents[$day])):?>
				
					<td><?php echo $day ?>日(<?php echo $weekday[date('w',strtotime(date('y-m-'.$day).'-2 month'))]; ?>)</td>
					<td>
						
						<?php foreach ($sortedEvents[$day] as $key => $event):?>
							<a href="<?php echo $event['EventInfo']['event_url'] ?>" target="_blank"><?php echo $event['EventInfo']['name']; ?></a>
							<span class="endDate">(~<?php echo $event['EventInfo']['end_month'] ?>/<?php echo $event['EventInfo']['end_day']; ?></span>
							<a href="<?php echo $event['Depart']['url']; ?>" target="_blank">@<?php echo $event['Depart']['name']; ?>)</a>
							<br>
							<?php if($key == 5): ?>
								<a href="/dayDetail?day=<?php echo $day ?>&month=<?php echo $thisMonth ?>">もっと見る(全<?php echo count($sortedEvents[$day]) ?>件)</a>
								<?php break; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
					</td>
			</tr>
		<?php endfor; ?>


	</table>
</div>

<div class="col-sm-3 rightContent">
	<h4>広告</h4>
	
	
</div>