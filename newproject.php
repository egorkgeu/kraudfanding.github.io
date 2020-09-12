<?php 
include 'header.php';
if (!authCheck()) {
	header('Location: reg.php');
}
/*
if (isset($_GET['project-id'])) {
	$projectid = $_GET['project-id'];
	$query = sequery("SELECT * FROM projects WHERE id=:projectid and status=1 LIMIT 1",compact('projectid'));
	if ($query['userid'] == $_COOKIE['userid']) {
		$title = 'Редактирование проекта';
		$title2 = 'Измените необходимые поля';
		$action = 'editproject';
	}
}*/
?>
<style>
	body{
		background-color: #f6f6f6;
	}
	.project-form{
		background-color: #fff;
		border-radius: 10px;
		padding: 40px;
	}
	.project-form label{
		font-size: 22px;
	}
	.project-form small{
		font-size: 14px;
	}
</style>
<section class="title-block">
	<div class="container">
		<h2>Создание проекта</h2>
		<p>Для создания проекта заполните поля, представленные ниже</p>
	</div>
</section>
<div class="container mt-5">
	<div class="row">
		<div class="col-md-8 offset-md-2">
			<form action="engine.php" method="POST" class="project-form" enctype="multipart/form-data">
				<input type="hidden" name="action" value="newproject">
				<input type="hidden" name="token" value="<?php echo $token; ?>">
				<h4 class="mb-3">Основное</h4>
				<div class="form-group">
				    <label>Название проекта</label>
				    <input type="text" class="form-control" name="name" placeholder="Введите название проекта" required="">
			    	<small class="form-text text-muted">Должно быть простым, запоминающимся и отражать суть вашего проекта.</small>
			  	</div>
			  	<div class="form-group">
				    <label>Описание проекта</label>
				    <textarea class="form-control" name="description" placeholder="Введите описание проекта" required="" cols="30" rows="10" maxlength="2000" minlength="30"></textarea>
			    	<small class="form-text text-muted">Подберите краткое и цепляющее описание.</small>
			  	</div>
			  	<div class="form-group">
				    <label>Место реализации проекта</label>
				    <select name="city" class="form-control" required="" placeholder="Выберите город">
				    	<option value="Казань">Казань</option>
				    	<option value="Москва">Москва</option>
				    	<option value="Санкт-Петербург">Санкт-Петербург</option>
				    	<option value="Нижний Новгород">Нижний Новгород</option>
				    	<option value="Сочи">Сочи</option>
				    	<option value="Екатеринбург">Екатеринбург</option>
				    </select>
			    	<small class="form-text text-muted">Укажите город, где будет реализован проект</small>
			  	</div>
			  	<div class="form-group">
				    <label>Необходимая сумма</label>
				    <div class="input-group">	
			        	<input type="number" class="form-control col-md-4" placeholder="Введите сумму" name="summa" required="" min="15000" max="10000000">
			        	<div class="input-group-append">
			          		<div class="input-group-text">₽</div>
			        	</div>
			      	</div>
			    	<small class="form-text text-muted">Сумма необходимая для вашего проекта</small>
			  	</div>
			  	<div class="form-group">
				    <label>Продолжительность проекта</label>
				    <div class="input-group">	
			        	<input type="number" class="form-control col-md-4" placeholder="Количество дней" name="days" required="" min="15" max="180">
			        	<div class="input-group-append">
			          		<div class="input-group-text">дней</div>
			        	</div>
			      	</div>
			    	<small class="form-text text-muted">Рекомендуется 30 дней. Минимально 15 дней.</small>
			  	</div>
			  	<hr>
			  	<h4 class="mb-3">Медиа</h4>
			  	<div class="form-group">
				    <label>Изображение</label>
				    <input type="file" name="img" required="" accept="image/x-png,image/gif,image/jpeg" class="form-control-file">
			    	<small class="form-text text-muted"></small>
			  	</div>
			  	<hr>
			  	<h4 class="mb-3">О себе</h4>
		  	 	<div class="form-row">
				    <div class="form-group col-md-6">
				      	<label>Имя</label>
				      	<input type="text" name="user-name" class="form-control" placeholder="Введите имя" required="" value="<?php echo $user1['name']; ?>">
				    </div>
				    <div class="form-group col-md-6">
				      	<label>Фамилия</label>
				      	<input type="text" class="form-control" name="user-surname" placeholder="Введите фамилию" required="" value="<?php echo $user1['surname']; ?>">
				    </div>
			  	</div>
			  	<div class="form-group">
				    <label>Должность</label>
				    <input type="text" class="form-control" name="user-profession" placeholder="Введите должность" required="" value="<?php echo $user1['profession']; ?>">
			    	<small class="form-text text-muted">Сервис доступен только для должностных лиц органов исполнительной власти.</small>
			  	</div>
			  	<div class="form-group">
				    <label>Информация о себе</label>
				    <textarea class="form-control" name="user-info" placeholder="Введите информацию о себе" required="" cols="30" rows="10" maxlength="1000" minlength="15"><?php echo $user1['info']; ?></textarea>
			    	<small class="form-text text-muted">Короткая информация, описывающая вашу деятельность.</small>
			  	</div>
			  	<hr>
			  	<h4 class="mb-3">Банковский счёт</h4>
			  	<div class="form-group">
				    <label>Номер банковского счёта</label>
				    <input type="text" class="form-control bank-account" name="bank-account" placeholder="Введите номер банковского счёта" required="">
			    	<small class="form-text text-muted">Счёт, на который будут поступать средства.</small>
			  	</div>
				<div class="form-row mt-5">
					<div class="form-group col-md-3">
						<button type="button" class="btn btn-block btn-outline-primary" onclick="toPage('index.php')">На главную</button>
					</div>
					<div class="form-group col-md-3 offset-md-6">
						<button type="submit" class="btn btn-block btn-primary">Создать проект</button>
					</div>		
				</div>
			</form>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>