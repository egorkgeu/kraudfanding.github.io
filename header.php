<?php
include 'bt/pdo.php';
session_start();
$_SESSION["token"] = md5(uniqid(rand(), TRUE));
$token = $_SESSION["token"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>SocialStarter</title>
  <link rel="stylesheet" href="bt/css/bootstrap.min.css">
  <link rel="stylesheet" href="bt/css/dropzone.min.css">
  <link rel="stylesheet" href="bt/css/style.css">
  <link rel="stylesheet" href="bt/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Manjari&display=swap" rel="stylesheet">
  <script src="bt/js/jquery-3.0.0.min.js" charset="utf-8"></script>
  <script src="bt/js/popper.min.js" charset="utf-8"></script>
  <script src="bt/js/bootstrap.min.js" charset="utf-8"></script>
  <script src="bt/js/popper.min.js" charset="utf-8"></script>
  <script src="bt/js/jquery.maskedinput.min.js" charset="utf-8"></script>
  <script src="bt/js/dropzone.js" charset="utf-8"></script>
  <style>
  	.navbar-brand{
  		font-family: 'Manjari', sans-serif;
  		font-weight: bold;
  		margin-bottom: -5px;
  		font-size: 30px;
  	}
  	.navbar .nav-link{
  		font-size: 20px;
  	}
  	.navbar-brand span{
  		color: #00aef4;
  	}
  </style>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark navigation">
		<div class="container">
	  		<a class="navbar-brand" href="index.php">Social<span>Starter</span></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
	  		<div class="collapse navbar-collapse" id="navbarNav">
			    <ul class="navbar-nav mr-auto ml-5">
			    	<li class="nav-item">
			        	<a class="nav-link" href="index.php">Главная</a>
			      	</li>
			      	<li class="nav-item">
			        	<a class="nav-link" href="main.php">Просмотр проектов</a>
			      	</li>
			      	<li class="nav-item">
			        	<a class="nav-link" href="newproject.php">Собрать средства</a>
			      	</li>
			    </ul>
			    <form class="form-inline my-2 my-lg-0">
			    	<?php if (authCheck()) {
			    		$id = $_COOKIE['userid'];
			    		$user1 = sequery("SELECT * FROM users WHERE id=:id and status=1 LIMIT 1", compact('id'));
			    		$fullname = $user1['name']." ".$user1['surname'];
			    	?>	
			    	<div class="btn-group">
					  	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <?php echo $fullname; ?>
					  	</button>
					  	<div class="dropdown-menu">
					    	<a class="dropdown-item" href="settings.php">Настройки</a>
					    	<a class="dropdown-item" href="user-projects.php">Проекты</a>
					    	<a class="dropdown-item" href="donates-history.php">Пожертвования</a>
					    	<div class="dropdown-divider"></div>
					    	<a class="dropdown-item logout-btn" href="#">Выход</a>
					  	</div>
					</div>
			    	<?php }else{ ?>
			    	<button onclick="toPage('reg.php')" class="btn btn-success my-2 my-sm-0" type="button">Регистрация</button>
			      	<button class="btn btn-primary my-2 my-sm-0 ml-2" onclick="toPage('auth.php')" type="button">Войти</button>
			      	<?php } ?>
			    </form>
	  		</div>
	  	</div>	
	</nav>
	<script>
		$('.logout-btn').click(function(event) {
			event.preventDefault();
			$.post('engine.php', {action: 'logOut', token: '<?php echo $token; ?>'}, function(data, textStatus, xhr) {
				console.log(data);
				location.reload();
			});
		});
	</script>
	