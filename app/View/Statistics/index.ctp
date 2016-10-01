<h4>
<div class="form-inline">
<?php echo $this->Form->create(false, array('type' => 'post', 'id' => 'serch-form')); ?>
<?php echo $this->Form->input(false, array('type' => 'select','options' => $months, 'selected' => $selectedMonthID, 'id' => 'month-select', 'class' => 'form-control' ,'name' =>'month', 'div' => array('class' => 'form-group'))) ?>
<?php echo $this->Form->submit('検索', array('div'=>false,'class' => 'btn-primary','name' => 'delete', 'id' => 'serchButton')); ?>
<?php echo $this->Form->end(); ?>
の統計情報
</div>
</h4>
<div class="container">
	<div class="col-sm-6 leftContent">
		<table class = "table table-bordered table-hover">
			<th>地区別</th><th>売上高（千円）</th><th>対前年増減率</th>
			<?php foreach($salesRegion['SalesRegion'] as $key => $hoge): ?>
				<?php if($key == 'month') continue; ?>
				<tr>
					<td><?php echo $key ?></td>
					<td><?php echo number_format($salesRegion['SalesRegion'][$key]) ?></td>
					<td><?php echo $salesRegion['SalesRegionYearOnYear'][$key] ?>%</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<div class="col-sm-6 leftContent">
		<table class = "table table-bordered table-hover">
			<th>商品別</th><th>売上高（千円）</th><th>対前年増減率</th>
			<?php foreach($salesItem['SalesItem'] as $key => $hogehoge): ?>
				<?php if($key == 'month') continue; ?>
				<tr>
					<td><?php echo $key ?></td>
					<td><?php echo number_format($salesItem['SalesItem'][$key]) ?></td>
					<td><?php echo $salesItem['SalesItemYearOnYear'][$key] ?>%</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>
<script type="text/javascript">
	$('#month-select').change(function(){
		$('#serch-form').submit();
	});
</script>