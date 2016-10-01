<h5>掲載デパート一覧</h5>
	
	<div class = "departList">
		<div class="col-sm-6 leftContent">
			<p>-- 東京都の掲載百貨店一覧 --</p>
			<ul>
				<?php foreach($tokyoDeparts as $depart): ?>
					<li><a href="departDetail?id=<?php echo $depart['Depart']['id'];?>"><?php echo $depart['Depart']['name'] ?></a></li>
				<?php endforeach; ?>

			</ul>
		</div>
		<div class="col-sm-6 leftContent">
			<p>-- 神奈川県の掲載百貨店一覧 --</p>
			<ul>
				<?php foreach($kanagawaDeparts as $depart): ?>
					<li><a href="departDetail?id=<?php echo $depart['Depart']['id'];?>"><?php echo $depart['Depart']['name'] ?></a></li>
				<?php endforeach; ?>

			</ul>
			<p>-- 埼玉県の掲載百貨店一覧 --</p>
			<ul>
				<?php foreach($saitamaDeparts as $depart): ?>
					<li><a href="departDetail?id=<?php echo $depart['Depart']['id'];?>"><?php echo $depart['Depart']['name'] ?></a></li>
				<?php endforeach; ?>

			</ul>
			<p>-- 千葉県の掲載百貨店一覧 --</p>
			<ul>
				<?php foreach($chibaDeparts as $depart): ?>
					<li><a href="departDetail?id=<?php echo $depart['Depart']['id'];?>"><?php echo $depart['Depart']['name'] ?></a></li>
				<?php endforeach; ?>

			</ul>
		</div>
	</div>