<?php 
include 'header.php'; 

if (!isset($_SESSION['sort'])) {
	$_SESSION['sort'] = 'old';
	$_SESSION['sort_text'] = 'Сначала старые';
}

if (!isset($_GET['city'])) {
	$city = 'all';
	$query = sequery("SELECT * FROM projects WHERE status=1");
}
else{
	$city = $_GET['city'];
	if ($city == 'all') {
		$query = sequery("SELECT * FROM projects WHERE status=1");
	}
	else{
		$query = sequery("SELECT * FROM projects WHERE city=:city AND status=1",compact('city'));
	}
	
}
if (isset($query[0]['id'])){
if (isset($_SESSION['sort'])) {
	switch ($_SESSION['sort']) {
		case 'new':
			$query = array_reverse($query);
			break;
		case 'cheap':
			for ($j = 0; $j < count($query) - 1; $j++){
			    for ($i = 0; $i < count($query) - $j - 1; $i++){
			        // если текущий элемент больше следующего
			    	$num1 = (int)$query[$i]['summa'];
			    	$num2 = (int)$query[$i+1]['summa'];

			        if ($num1 > $num2){
			            // меняем местами элементы
			            $tmp_var = $query[$i + 1];
			            $query[$i + 1] = $query[$i];
			            $query[$i] = $tmp_var;
			        }
			    }
			}
			break;
		case 'exp':
			for ($j = 0; $j < count($query) - 1; $j++){
			    for ($i = 0; $i < count($query) - $j - 1; $i++){
			        // если текущий элемент больше следующего
			    	$num1 = (int)$query[$i]['summa'];
			    	$num2 = (int)$query[$i+1]['summa'];

			        if ($num1 < $num2){
			            // меняем местами элементы
			            $tmp_var = $query[$i + 1];
			            $query[$i + 1] = $query[$i];
			            $query[$i] = $tmp_var;
			        }
			    }
			}
			break;
		case 'progressup':
			for ($j = 0; $j < count($query) - 1; $j++){
			    for ($i = 0; $i < count($query) - $j - 1; $i++){
			        // если текущий элемент больше следующего
			        $num1 = intdiv((int)$query[$i]['donated']*100, (int)$query[$i]['summa']);
			        $num2 = intdiv((int)$query[$i+1]['donated']*100, (int)$query[$i+1]['summa']);

			        if ($num1 > $num2){
			            // меняем местами элементы
			            $tmp_var = $query[$i + 1];
			            $query[$i + 1] = $query[$i];
			            $query[$i] = $tmp_var;
			        }
			    }
			}
			break;	
		case 'progressdown':
			for ($j = 0; $j < count($query) - 1; $j++){
			    for ($i = 0; $i < count($query) - $j - 1; $i++){
			        // если текущий элемент больше следующего
			        $num1 = intdiv((int)$query[$i]['donated']*100, (int)$query[$i]['summa']);
			        $num2 = intdiv((int)$query[$i+1]['donated']*100, (int)$query[$i+1]['summa']);

			        if ($num1 < $num2){
			            // меняем местами элементы
			            $tmp_var = $query[$i + 1];
			            $query[$i + 1] = $query[$i];
			            $query[$i] = $tmp_var;
			        }
			    }
			}
			break;		
		default:
			# code...
			break;
	}
}
}

if (count($query) == 0) {
	$query = false;
}
elseif (!isset($query[0]['id'])) {
	$query = array('1' => $query);
}
?>
<style>
	body{
		background-color: #f6f6f6;
	}
	.main-block{
		background-color: #fff;
		border-radius: 20px;
		padding: 20px 30px;
	}
</style>
<section class="title-block" style="background-image: url(bt/img/page-bg1.png);">
	<div class="container">
		<h2>Сбор пожертвований</h2>
	</div>
</section>
<div class="container mt-5">
	<div class="row">
		<div class="col-md-12">
			<div class="main-block">
				<form>
					<div class="form-row">
						<div class="col-md-6 flex align-items-end">
							<h3>Проекты</h3>
						</div>
						<div class="col-md-3">
							<label>Город</label>
							<select name="city" class="form-control choose-city" required="" placeholder="Выберите город">
								<option value="all" <?php if($city == 'all') echo 'selected'; ?>>Все</option>
						    	<option value="Казань" <?php if($city == 'Казань') echo 'selected'; ?>>Казань</option>
						    	<option value="Москва" <?php if($city == 'Москва') echo 'selected'; ?>>Москва</option>
						    	<option value="Санкт-Петербург" <?php if($city == 'Санкт-Петербург') echo 'selected'; ?>>Санкт-Петербург</option>
						    	<option value="Нижний Новгород" <?php if($city == 'Нижний Новгород') echo 'selected'; ?>>Нижний Новгород</option>
						    	<option value="Сочи" <?php if($city == 'Сочи') echo 'selected'; ?>>Сочи</option>
						    	<option value="Екатеринбург" <?php if($city == 'Екатеринбург') echo 'selected'; ?>>Екатеринбург</option>
						    </select>
						</div>
						<div class="col-md-3">
							<label for="">Сортировка</label>
							<div class="btn-group btn-block set-sort">
							  	<button type="button" class="btn btn-info btn-block  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['sort_text']; ?></button>
							  	<div class="dropdown-menu">
							    	<a class="dropdown-item" href="new">Сначала новые</a>
							    	<a class="dropdown-item" href="old">Сначала старые</a>
							    	<a class="dropdown-item" href="exp">Самые дорогие</a>
							    	<a class="dropdown-item" href="cheap">Самые дешевые</a>
							    	<a class="dropdown-item" href="progressup">Прогресс по возрастанию</a>
							    	<a class="dropdown-item" href="progressdown">Прогресс по убыванию</a>
							  	</div>
							</div>
						</div>
					</div>
					<hr>
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
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$('.set-sort a').click(function(event) {
		event.preventDefault();
		var sort = $(this).attr('href'),
			sort_text = $(this).text();
		$.post('engine.php', {action: 'set_sort',token: '<?php echo $token; ?>',sort: sort,sort_text: sort_text}, function(data, textStatus, xhr) {
			//console.log(data);			
		});
		location.reload();
	});

	$('.choose-city').change(function(event) {
		var city = $('.choose-city option:selected').val();
		toPage('main.php?city='+city);
	});
</script>
<?php include 'footer.php'; ?>