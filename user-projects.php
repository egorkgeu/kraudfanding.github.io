<?php 
include 'header.php';
if (!authCheck()) {
	header('Location: reg.php');
}
$userid = $_COOKIE['userid'];
$query = sequery("SELECT * FROM projects WHERE userid=:userid and status=1",compact('userid'));
if (count($query) == 0) {
	$query = false;
}
elseif (!isset($query[0]['id'])) {
	$query = array('1' => $query);
}

?>
<section class="title-block">
	<div class="container">
		<h2>Мои проекты</h2>
	</div>
</section>
<div class="container mt-5">
	<div class="row">
		<?php if($query == false){ ?>
			<h3 class="mb-5">У вас пока нет проектов</h3>
		<?php }else{ foreach ($query as $v) {
			/*
			$strquery = "TIMEDIFF(now(),'".$v['data']."')";
			$timediff = sequery("SELECT ".$strquery);
			echo $timediff[$strquery];
			//$ostdays = (int)$v['days'] - $timediff[$strquery];
			*/
			$precents = intdiv((int)$v['donated']*100, (int)$v['summa']);
		?>
		<div class="col-md-4">
			<div onclick="toPage('project.php?id=<?php echo $v["id"]; ?>');" class="card" style="width: 100%;">
			  	<div class="card-img-top" style="background-image: url(catalog/<?php echo $v['video']; ?>);"></div>
			  	<div class="card-body">
			  		<div class="card-wr">
				    	<h5 class="card-title"><?php echo $v['name']; ?></h5>
				    	<p class="card-text"><?php echo $v['description']; ?></p>
				    </div>	
			    	<small><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $v['city']; ?></small><br><br>
			    	<span class="badge badge-primary" style="width: 32%;">Прогресc<br><?php echo $precents; ?>%</span>
			    	<span class="badge badge-success" style="width: 32%;">Собрано<br><?php echo $v['donated']; ?> ₽</span>
			    	<span class="badge badge-danger" style="width: 32%;">Нужно<br><?php echo $v['summa']; ?> ₽</span>
			  	</div>
			</div>
		</div>
		<?php } } ?>
		<div class="col-md-4"></div>
		<div class="col-md-4"></div>
	</div>
</div>
<?php include 'footer.php'; ?>