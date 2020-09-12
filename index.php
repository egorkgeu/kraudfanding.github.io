<?php 
include 'header.php'; 
$project1 = sequery("SELECT * FROM projects WHERE id = 2");
$precents = intdiv((int)$project1['donated']*100, (int)$project1['summa']);
$project1_userid = $project1['userid'];
$user = sequery("SELECT * FROM users WHERE id = :project1_userid", compact('project1_userid'));

$sobrano = sequery("SELECT SUM(donated) FROM projects");
$sobrano = (string)$sobrano['SUM(donated)'];
if (strlen($sobrano) > 6) {
	$sobrano = substr($sobrano, 0, -6)."M";
}
elseif (strlen($sobrano) > 3) {
	$sobrano = substr($sobrano, 0, -3)."K";
}

$usercount = sequery("SELECT MAX(id) FROM users");

$donates = sequery("SELECT MAX(id) FROM donates");


$query = sequery("SELECT * FROM projects ORDER BY id DESC LIMIT 3");
?>
	<style>
		section{
			text-align: center;
			padding: 40px 0;
		}
		section h4{
			font-size: 35px;
		    display: inline-block;
		    margin: 0 auto 40px;
		}
		section .span{
			color: #00aef4;
		}
		section p{
			text-align: justify;
			font-size: 24px;
		}
		.blueline {
		    background-color: #00aef4;
		    width: 63px;
		    height: 3px;
		}
		.stats{
			background-color: #00aef4; 
		}
		.stats .number{
			color: #fff;
			text-align: center;
			font-size: 80px;
		}
		.stats p{
			color: #fff;
			font-size: 25px;
			text-align: center;
			line-height: 29px;
		}

		.project-info{
			background-color: #fff;
			border-radius: 10px;
			padding: 20px;
			text-align: left;
		}
		.project-info h3{
			font-size: 45px;
		}
		.project-info small{
			color: grey;
			font-size: 16px;
		}
		.project-content{
			background-color: #fff;
			border-radius: 10px;
			padding: 20px;
		}
		.project-content h3{
			text-align: left;
		}
		.project-content p{
			font-size: 18px;
			text-align: justify;
			color: #000;
		}
		.project-img{
			width: 100%;
			height: 300px;
			background-color: #fff;
			background-size: cover;
			background-position: center center;
			background-repeat: no-repeat;
		}
		.hidden-input{
			display: none;
		}

		.letsgo{
			background-color: #1a3048; 
		}
		.letsgo h5{
			font-size: 35px;
			color: #fff;
		}
	</style>
	<header>
		<div class="container">
			<h2>Платформа сбора пожертвований для социально-важных проектов</h2><br>
			<!--<h3>Еще один заголовок</h3>-->
			<button onclick="toPage('newproject.php');" class="btn btn-outline-light btn-lg header-start">Начать сбор средств</button>
		</div>
	</header>
	<section class="about">
		<div class="container">
			<h4>О сервисе<div class="blueline"></div></h4>
			<div class="row">
				<div class="col-md-8 offset-md-2">
					<p>Наш сервис <span class="span">предоставляет возможность</span> органам испольнительной власти осуществлять <span class="span">сбор средств</span> для решения <span class="span">социально-важных вопросов</span>. С помощью нашего проекта неравнодушные граждане могут <span class="span">пожертвовать средства</span> для решения <span class="span">важных проблем</span>.</p>
				</div>
			</div>
		</div>
	</section>
	<section class="stats">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<h5 class="number"><?php echo $usercount['MAX(id)']; ?></h5>
					<p>Пользователей<br>зарегистрировано</p>
				</div>
				<div class="col-md-4">
					<h5 class="number"><?php echo $donates['MAX(id)']; ?></h5>
					<p>Пожертвований<br>совершено</p>
				</div>
				<div class="col-md-4">
					<h5 class="number"><?php echo $sobrano; ?></h5>
					<p>Рублей<br>собрано</p>
				</div>
			</div>
		</div>
	</section>
	<section class="primer" style="background-color: #f6f6f6;">
		<div class="container">
			<h4>Интересный проект<div class="blueline"></div></h4>
			<div class="row mt-3">
				<div class="col-md-4">
					<div class="project-info">
						<h3><?php echo $project1['donated']; ?> ₽</h3>
						<p>Собрано из <?php echo $project1['summa']; ?> ₽</p>
						<div class="progress mb-3">
					 	 	<div class="progress-bar w-<?php echo $precents; ?>" role="progressbar" aria-valuenow="<?php echo $precents; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $precents; ?>%;"><?php echo $precents; ?>%</div>
						</div>
						<small><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $project1['city']; ?></small><br>
						<button class="btn btn-block btn-primary mt-3 mb-3 donate-btn">Пожертвовать</button>
						<div class="hidden-input">
							<div class="input-group mb-3">  
							  <input type="number" class="form-control" placeholder="Введите сумму">
							  <div class="input-group-append">
							    <button class="btn btn-primary donate-send" type="button">Отправить</button>
							  </div>
							  <div class="invalid-feedback"></div>
							</div>
						</div>
						<!--
						<?php if ($_COOKIE['userid'] == $query['userid']) { ?>
						<button onclick="toPage('newproject.php?project-id=<?php echo $query['id']; ?>');" class="btn btn-block btn-success mt-3 mb-3">Редактировать</button>
						<?php } ?>
						-->
						<hr>
						<a href="#" class="user-info"><?php echo $user['name']." ".$user['surname']; ?></a><br>
						<span><?php echo $user['profession']; ?></span>
					</div>
				</div>
				<div class="col-md-8">
					<div class="project-content">
						<div class="project-img" style="background-image: url(catalog/<?php echo $project1['video']; ?>);"></div>
						<br>
						<h3><?php echo $project1['name']; ?></h3>
						<br>
						<p><?php echo $project1['description']; ?></p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="letsgo">
		<div class="contaner">
			<h5>Хотите собрать средства? Создайте новый проект!</h5>
			<a href="newproject.php" class="btn btn-primary btn-lg mt-3">Создать проект</a>
		</div>
	</section>
	<section class="lastprojects">
		<div class="container">
			<h4>Последние проекты<div class="blueline"></div></h4>
			<div class="row">
				<?php if (!$query) { ?>
					<h3 style="text-align: center; margin: 0 auto;" class="mt-3">Ничего не найдено</h3>
				<?php }else{ ?>
				<?php foreach ($query as $v) {
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
			</div>
		</div>
	</section>
<script>
	var isshowed = false;
	$('.donate-btn').click(function(event) {
		if (isshowed) {
			$('.hidden-input').slideUp('fast');
			isshowed = false;
		}else{
			$('.hidden-input').slideDown('fast');
			isshowed = true;
		}
		
	});
	$('.donate-send').click(function(event) {
		$('.hidden-input input').removeClass('is-invalid');
		$('.hidden-input .invalid-feedback').hide();
		var donate = $(this).closest('.hidden-input').find('input');
		if (donate.val() == '') {
			donate.addClass('is-invalid');
			$('.hidden-input .invalid-feedback').text('Введите сумму').show();
		}
		else if(Number(donate.val()) < 50){
			donate.addClass('is-invalid');
			$('.hidden-input .invalid-feedback').text('Минимальная сумма 50₽').show();
		}
		else{
			$.post('engine.php', {action: 'sendDonate',token: '<?php echo $token; ?>', project_id: <?php echo $id; ?>, donate: donate.val()}, function(data, textStatus, xhr) {
				alert('Ваш донат отправлен!');
			});
			$('.hidden-input input').removeClass('is-invalid');
			$('.hidden-input .invalid-feedback').hide();
			$('.hidden-input').hide();
		}
	});
</script>	
<?php include 'footer.php'; ?>
