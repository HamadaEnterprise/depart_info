<div class="col-sm-9 leftContent">
	<p class="message"><?php if(isset($message)){echo $message;}; ?></p>
	<h5>管理者ページ</h5>
	<a href="/admin?condition=allDeparts">全デパートを表示する</a>
	<a href="/admin">自動取得できないデパートを表示する</a>

	<div class="form-inline">
			<?php echo $this->Form->create(false, array('type' => 'post', 'id' => 'confirm', 'url' =>array( 'action' => 'confirm'))); ?>
			<?php echo $this->Form->input('更新百貨店', array('type' => 'select','options' => $departs, 'class' => 'form-control' ,'name' =>'depart', 'div' => array('class' => 'form-group'))) ?>
			<?php echo $this->Form->input('eventName', ['label' => 'イベント名']);   ?>
			<?php echo $this->Form->input('startDate', ['label' => '開始日', 'class' => 'datepicker']);   ?>
			<?php echo $this->Form->input('endDate', ['label' => '終了日','class' => 'datepicker']);   ?>
			<?php echo $this->Form->submit('登録', array('div'=>false,'class' => 'btn-primary','name' => 'entrybutton')); ?>
			<?php echo $this->Form->end(); ?>
		</div>
	
</div>

<div class="col-sm-3 rightContent">
	
	
	
</div>
<style type="text/css" media="screen">
	.message{
		color: blue;
	}
</style>
<?php echo $this->Html->css('jquery-ui.min'); ?>
<script src="<?php echo $this->Html->url('/js/jquery-ui-1.12.0.custom/jquery-ui.min.js'); ?>"></script>
<script type="text/javascript">
	 $(function() {
	    $(".datepicker").datepicker({
	    	dateFormat: 'yy-m-d'
	    });
	  });

	 $('#entryForm').submit(function(){
	 	if($("input[name='data[eventName]']").val() =='' || typeof $("input[name='data[eventName]']").val() == 'undefined'){
	 		alert('イベント名を入力してください');
	 		return false;
	 	}else if($("input[name='data[startDate]']").val() =='' || typeof $("input[name='data[startDate]']").val() == 'undefined'){
	 		alert('開始日を入力してください');
	 		return false;
	 	}else if($("input[name='data[endDate]']").val() =='' || typeof $("input[name='data[endDate]']").val() == 'undefined'){
	 		alert('終了日を入力してください');
	 		return false;
	 	}else{
	 		$("#entryForm").submit();
	 	}
	 })



</script>