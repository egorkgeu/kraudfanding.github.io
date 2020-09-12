<?php 
include 'header.php';
if (authCheck()) {
	header('Location: index.php');
}
?>
<style>	
	.auth{
		margin-bottom: 150px;
	}
</style>
<section class="auth">
	<div class="container">
		<div class="row">
			<div class="col-md-4 offset-md-4">
				<form class="mt-5 pt-5">
					<h4 class="text-center mb-4">Авторизация</h4>
			  		<div class="form-group">
			    		<label>Email</label>
			    		<input type="text" class="form-control input-lg user-email" placeholder="Введите email">
			    		<div class="invalid-feedback">
				      	</div>
			  		</div>
			  		<div class="form-group">
			    		<label>Пароль</label>
			    		<input type="password" class="form-control input-lg user-password" placeholder="Введите пароль">
			    		<div class="invalid-feedback">
				      	</div>
			  		</div>
			  		<button type="button" class="btn btn-primary btn-lg btn-block auth-btn">Войти</button>
			  		<p>Еще не зарегистрированы? <a href="reg.php">Регистрация</a></p>
				</form>
			</div>
		</div>
	</div>
</section>
<script>
	$('.auth-btn').click(function(event) {
		$('.invalid-feedback').hide();
		$(this).closest('form').find('input').removeClass('is_invalid');
		var user_email = $('.user-email'),
			user_password = $('.user-password'),
			valid = true;
		if (user_email.val() == '') {
			valid = false;
			user_email.addClass('is_invalid');
		}
		if (user_password.val() == '') {
			valid = false;
			user_password.addClass('is_invalid');
		}

		if (valid == true) {
			$.post('engine.php', {action: 'auth', token: '<?php echo $token; ?>', user_email:user_email.val(),user_password:user_password.val()}, function(data, textStatus, xhr) {
				console.log(data);
				switch(data){
					case 'Такой Email не существует':
						user_email.addClass('is-invalid');
						user_email.closest('.form-group').find('.invalid-feedback').text(data).show();
						break;
					case 'Неверный пароль':
						user_password.addClass('is-invalid');
						user_password.closest('.form-group').find('.invalid-feedback').text(data).show();
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