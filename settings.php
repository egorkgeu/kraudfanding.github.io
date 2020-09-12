<?php
include 'header.php';
if (!authCheck()) {
	header('Location: index.php');
}
else{
	$userid = $_COOKIE['userid'];
	$user = sequery("SELECT * FROM users WHERE id=:userid and status=1 LIMIT 1",compact('userid'));
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
		<h2>Настройки профиля</h2>
	</div>
</section>
<section>
	<div class="container mt-5">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div class="main-block">
					<form action="engine.php" method="POST" class="project-form">
						<input type="hidden" name="action" value="edituser">
						<input type="hidden" name="token" value="<?php echo $token; ?>">
						<div class="form-row">
						    <div class="form-group col-md-6">
						      	<label>Имя</label>
						      	<input type="text" name="user-name" class="form-control" placeholder="Введите имя" required="" value="<?php echo $user['name']; ?>">
						    </div>
						    <div class="form-group col-md-6">
						      	<label>Фамилия</label>
						      	<input type="text" class="form-control" name="user-surname" placeholder="Введите фамилию" required="" value="<?php echo $user['surname']; ?>">
						    </div>
					  	</div>
					  	<div class="form-group">
						    <label>Должность</label>
						    <input type="text" class="form-control" name="user-profession" placeholder="Введите должность" value="<?php echo $user['profession']; ?>">
					    	<small class="form-text text-muted">Сервис доступен только для должностных лиц органов исполнительной власти.</small>
					  	</div>
					  	<div class="form-group">
						    <label>Информация о себе</label>
						    <textarea class="form-control" name="user-info" placeholder="Введите информацию о себе" cols="30" rows="10" maxlength="1000" minlength="15"><?php echo $user['info']; ?></textarea>
					    	<small class="form-text text-muted">Короткая информация, описывающая вашу деятельность.</small>
					  	</div>
					  	<div class="form-row">
					  		<div class="form-group col-md-6">
					  			<button type="button" onclick="location.reload()" class="btn btn-danger btn-block">Отмена</button>
					  		</div>
					  		<div class="form-group col-md-6">
					  			<button type="submit" class="btn btn-primary btn-block">Сохранить</button>
					  		</div>
					  	</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
include 'footer.php';
?>