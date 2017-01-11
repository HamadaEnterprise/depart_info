<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<link rel="icon" type="image/png" href="/images/shopping_icon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php if(isset($description)){echo $description;} ?>">
	<meta name="author" content="">
	<meta name="google-site-verification" content="R5GY4ONzEG1-mxUE769ypqvgzzdpZTEEFm4cCfPA1A4" />
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
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-80445148-1', 'auto');
  ga('send', 'pageview');

</script>
<style type="text/css">
	.collapse.in{
		background-color: rgb(255,255,255);
	}
</style>

</head>

<body>
<div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="../" class="navbar-brand">デパート	情報百貨</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
            <li <?php if($naviType=="top"):?>class="active"<?php endif;?>><a href="/">トップ<span class="sr-only">(current)</span></a></li>
			<li <?php if($naviType=="calendar"):?>class="active"<?php endif;?>><a href="/calendar?month=this">催事カレンダー</a></li>
			<li <?php if($naviType=="statistics"):?>class="active"<?php endif;?>><a href="/statistics">統計情報</a></li>
			<li <?php if($naviType=="departs"):?>class="active"<?php endif;?>><a href="/departs" title="">掲載デパート一覧</a></li>
			<li <?php if($naviType=="blog"):?>class="active"<?php endif;?>><a href="/blog" title="">特集記事</a></li>
          </ul>
        </div>
      </div>
    </div>
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
