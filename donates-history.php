<?php
include 'header.php';
if (!authCheck()) {
	header('Location: index.php');
}
else{
	$userid = $_COOKIE['userid'];
	$query = sequery("SELECT * FROM donates WHERE userid=:userid and status=1",compact('userid'));
}

if (count($query) == 0) {
	$query = false;
}
elseif (!isset($query[0]['id'])) {
	$query = array('1' => $query);
}
?>
<style>
	/*
	body{
		background-color: #f6f6f6;
	}
	.main-block{
		background-color: #fff;
		border-radius: 20px;
		padding: 20px;
	}
	*/
	.project-form label{
		font-size: 22px;
	}
	.project-form small{
		font-size: 14px;
	}
</style>
<section class="title-block">
	<div class="container">
		<h2>История пожертвований</h2>
	</div>
</section>
<section>
	<div class="container mt-5">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<?php if(!$query){ ?>
					<h3>История пожертвований пуста</h3>
				<?php 
				}else{
					foreach ($query as $v) {
					$projectid = $v['projectid'];	
					$project = sequery("SELECT name FROM projects WHERE id=:projectid and status=1",compact('projectid'));
					if (isset($project['name'])) {	
				?>
				<div class="card mb-3">
				  	<h5 class="card-header"><?php echo $project['name']; ?></h5>
				  	<div class="card-body">
					    <h5 class="card-title">Сумма пожертвования: <?php echo $v['donate']; ?>₽</h5>
					    <a href="project.php?id=<?php echo $v['projectid']; ?>" class="btn btn-primary">Перейти на страницу проекта</a>
				  	</div>
				</div>
				<?php } } } ?>
			</div>
		</div>
	</div>
</section>
<?php
include 'footer.php';
?>