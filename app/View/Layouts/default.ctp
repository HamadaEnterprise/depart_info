<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<link rel="icon" type="image/png" href="/images/shopping_icon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<script src="<?php echo $this->Html->url('/js/jquery-1.12.3.min.js'); ?>"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<?php echo $this->Html->script('bootstrap.min'); ?>
	<?php echo $this->fetch('script'); ?>

	<?php echo $this->Html->css('bootstrap.min'); ?>
	<?php //echo $this->Html->css('bootstrap-responsive.min'); ?>
	<?php echo $this->Html->css('default.css'); ?>
<?php
echo $this->fetch('meta');
echo $this->fetch('css');
?>

</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">デパートまとめ</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li <?php if($naviType=="top"):?>class="active"<?php endif;?>><a href="/">Top<span class="sr-only">(current)</span></a></li>
					<li <?php if($naviType=="calendar"):?>class="active"<?php endif;?>><a href="/calendar?month=this">Calendar</a></li>
					<li <?php if($naviType=="statistics"):?>class="active"<?php endif;?>><a href="/statistics">統計情報</a></li>
					<li <?php if($naviType=="departs"):?>class="active"<?php endif;?>><a href="/departs" title="">掲載デパート一覧</a></li>
					<li <?php if($naviType=="blog"):?>class="active"<?php endif;?>><a href="/blog" title="">特集記事</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">

		<?php echo $this->Session->flash(); ?>

		<?php echo $this->fetch('content'); ?>

	</div> <!-- /container -->

	<!-- Le javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script> -->
	<div class="footer">
		<div class="container">
			<div class="disclaimer">
				当サイト管理人は、利用者様が本ホームページに含まれる情報もしくは内容をご利用されたことで直接・間接的に生じた損失に関し一切責任を負いません。必ず、各社ホームページにて最新情報を確認するようお願い致します。</div>
			</div>
		</div>

	</body>
	</html>
