<?php
include 'header.php';
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$query = sequery("SELECT * FROM projects WHERE id=:id and status=1 LIMIT 1",compact('id'));
	if (count($query) == 0) {
		header('Location: index.php');
	}
}
else{
	header('Location: index.php');
}
$precents = intdiv((int)$query['donated']*100, (int)$query['summa']);
$userid = $query['userid'];
$user = sequery("SELECT * FROM users WHERE id=:userid and status=1 LIMIT 1",compact('userid'));
?>
<style>
	body{
		background-color: #f6f6f6;
	}
	.project-info{
		background-color: #fff;
		border-radius: 10px;
		padding: 20px;
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
	.project-content p{
		font-size: 18px;
		text-align: justify;
	}
	.project-img{
		width: 100%;
		height: 300px;
		background-color: #fff;
		background-size: contain;
		background-position: center center;
		background-repeat: no-repeat;
	}
	.hidden-input{
		display: none;
	}
</style>
<div class="container">
	<div class="row mt-5 mb-5">	
		<div class="col-md-4">
			<div class="project-info">
				<h3><?php echo $query['donated']; ?> ₽</h3>
				<p>Собрано из <?php echo $query['summa']; ?> ₽</p>
				<div class="progress mb-3">
			 	 	<div class="progress-bar w-<?php echo $precents; ?>" role="progressbar" aria-valuenow="<?php echo $precents; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $precents; ?>%;"><?php echo $precents; ?>%</div>
				</div>
				<small><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $query['city']; ?></small><br>
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
				<div class="project-img" style="background-image: url(catalog/<?php echo $query['video']; ?>);"></div>
				<br>
				<h3><?php echo $query['name']; ?></h3>
				<br>
				<p><?php echo $query['description']; ?></p>
			</div>
		</div>
	</div>
</div>
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
<?php
include 'footer.php';
?>