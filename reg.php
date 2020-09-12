<?php 
include 'header.php';
if (authCheck()) {
	header('Location: index.php');
}
?>
<section class="auth">
	<div class="container">
		<div class="row">
			<div class="col-md-4 offset-md-4">
				<form class="mt-5 pt-5">
					<h4 class="text-center mb-4">Регистрация</h4>
			  		<div class="form-group">
			    		<label>Имя</label>
			    		<input type="text" class="form-control input-lg reg-name" placeholder="Введите имя">
			  		</div>
			  		<div class="form-group">
			    		<label>Фамилия</label>
			    		<input type="text" class="form-control input-lg reg-secondname" placeholder="Введите имя">
			  		</div>
			  		<div class="form-group">
			  			<label>Email</label>
			    		<input type="email" class="form-control input-lg reg-email" placeholder="Введите email">
			    		<div class="invalid-feedback">
				      	</div>
			  		</div>
			  		<div class="form-group">
			    		<label>Пароль</label>
			    		<input type="password" class="form-control input-lg reg-password" placeholder="Введите пароль">
			  		</div>
			  		<div class="form-group">
			    		<label>Повторите пароль</label>
			    		<input type="password" class="form-control input-lg reg-password2" placeholder="Повторите пароль">
			    		<div class="invalid-feedback">
				      	</div>
			  		</div>
			  		<button type="button" class="btn btn-primary btn-lg btn-block reg-btn">Зарегистрироваться</button>
			  		<p>Уже зарегистрированы? <a href="auth.php">Авторизация</a></p>
				</form>
			</div>
		</div>
	</div>
</section>
<script>
	var check_code = false;

	$(document).on('click', '.reg-btn', function(event) {
		event.preventDefault();
		$(this).closest('form').find('input').removeClass('is-invalid');
		$('.invalid-feedback').hide();
		var reg_name = $('.reg-name'),
			reg_secondname = $('.reg-secondname'),
			reg_email = $('.reg-email'),
			reg_password = $('.reg-password'),
			reg_password2 = $('.reg-password2'),
			valid = true;
			

		if (reg_name.val() == '') {
			reg_name.addClass('is-invalid');
			valid = false;
		}
		if (reg_secondname.val() == '') {
			reg_secondname.addClass('is-invalid');
			valid = false;
		}

		if (reg_email.val() == '') {
			reg_email.addClass('is-invalid');
			reg_email.closest('.form-group').find('.invalid-feedback').hide();
			valid = false;
		}
		else if(reg_email.val().indexOf('@') <= -1){
			reg_email.addClass('is-invalid');
			reg_email.closest('.form-group').find('.invalid-feedback').text('Введите корректный email').show();
			valid = false;
		}

		if (reg_password.val() == '') {
			reg_password.addClass('is-invalid');
			valid = false;
		}	
		if (reg_password2.val() == '') {
			reg_password2.addClass('is-invalid');
			valid = false;
		}

		if (valid == true) {
			$.post('engine.php', {action: 'reg', token: '<?php echo $token; ?>', user_name: reg_name.val(), user_surname: reg_secondname.val(), user_email: reg_email.val(), user_password: reg_password.val(), user_password2: reg_password2.val()}, function(data, textStatus, xhr) {
				console.log(data);
				switch(data){
					case 'Пароли не совпадают':
						reg_password.addClass('is-invalid');
						reg_password2.addClass('is-invalid');
						reg_password2.closest('.form-group').find('.invalid-feedback').text(data).show();
						break;
					case 'Такой email уже существует':
						reg_email.addClass('is-invalid');
						reg_email.closest('.form-group').find('.invalid-feedback').text(data).show();
						break;
					case 'ok':
						location.replace('index.php');
						break;	
					default:
						break;		
				}
			});
		}
	});
</script>
<?php include 'footer.php'; ?>