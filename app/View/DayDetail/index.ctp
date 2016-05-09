<div class="col-sm-9 leftContent">
	
	<h5><?php echo $month ?>月<?php echo $day ?>の催事情報</h5>
	<table class="table">
		<tr><th>催事名称</th></tr>
			<?php foreach ($events as $key => $event):?>
				<tr>
					<td><a href="<?php echo $event['EventInfo']['event_url'] ?>" target = "_blank"><?php echo $event['EventInfo']['name'] ?><span class="endDate">(<?php echo $event['EventInfo']['end_month'] ?>/<?php echo $event['EventInfo']['end_day'] ?>まで)</span></a>
					<a href="<?php echo $event['Depart']['url'] ?>" target="_blank">@<?php echo $event['Depart']['name'] ?></a></td>
				</tr>
			<?php endforeach; ?>
	</table>
</div>

<div class="col-sm-3 rightContent">
	<h4>広告</h4>
	
	
</div>