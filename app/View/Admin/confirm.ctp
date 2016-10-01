<style type="text/css" media="screen">
	ul{
		list-style: none;
	}
</style>

<div class="col-sm-9 leftContent">
	<h5>催事登録確認画面</h5>
	<p>以下の内容で登録してよろしいですか？</p>
	<table class="table">
		<tr>
			<th>イベント名</th>
			<td><?php echo $eventName; ?></td>
		</tr>
		<tr>
			<th>デパート名</th>
			<td><?php echo $departName; ?></td>
		</tr>
		<tr>
			<th>開始日</th>
			<td><?php echo $startDate; ?></td>
		</tr>
		<tr>
			<th>終了日</th>
			<td><?php echo $endDate; ?></td>
		</tr>

	</table>
	
	<div class="form-inline">
			<?php echo $this->Form->create(false, array('type' => 'post', 'id' => 'confirm', 'url' =>array( 'action' => 'entryEvent'))); ?>
			<?php echo $this->Form->hidden('') ?>
			<?php echo $this->Form->hidden('eventName', array('value' => $eventName)); ?>
			<?php echo $this->Form->hidden('startDate',array('value' => $startDate) ); ?>
			<?php echo $this->Form->hidden('endDate', array('value' => $endDate)); ?>
			<?php echo $this->Form->hidden('departID', array('value' => $departID)); ?>
			<?php echo $this->Form->submit('登録', array('div'=>false,'class' => 'btn-primary','name' => 'entrybutton')); ?>
			<?php echo $this->Form->end(); ?>
		</div>
	
</div>

<div class="col-sm-3 rightContent">
	
	
	
</div>
