<?php
include 'bt/pdo.php';
session_start();
$token = $_SESSION['token'];

if (isset($_POST['action']) && $_POST['token'] == $token) {
	switch ($_POST['action']) {
		case 'reg':
			$user_name = htmlspecialchars($_POST['user_name']);
			$user_surname = htmlspecialchars($_POST['user_surname']);
			$user_email = htmlspecialchars($_POST['user_email']);
			$user_password = htmlspecialchars($_POST['user_password']);
			$user_password2 = htmlspecialchars($_POST['user_password2']);

			$query = sequery("SELECT email FROM users WHERE email=:user_email and status=1 LIMIT 1",compact('user_email'));

			if ($user_password != $user_password2) {
				echo 'Пароли не совпадают';
			}
			elseif (!empty($query)) {
				echo 'Такой email уже существует';
			}
			else{
				$query = query("INSERT INTO users (name, surname, email, password) VALUES (:user_name, :user_surname, :user_email, :user_password)", compact('user_name', 'user_surname', 'user_email', 'user_password'));
				setAuth(DB::getInstance()->lastInsertId());
				echo 'ok';
			}
			break;
		case 'auth':
			$user_email = htmlspecialchars($_POST['user_email']);
			$user_password = htmlspecialchars($_POST['user_password']);

			$query = sequery("SELECT * FROM users WHERE email=:user_email and status=1 LIMIT 1", compact('user_email'));

			if (empty($query)) {
				echo 'Такой Email не существует';
			}
			elseif ($user_password != $query['password']) {
				echo 'Неверный пароль';
			}
			else{
				setAuth($query['id']);
				echo 'ok';
			}

			break;
		case 'logOut':
			logOut();
			echo 'ok';
			break;
		case 'edituser':
			$user_name = htmlspecialchars($_POST['user-name']);
			$user_surname = htmlspecialchars($_POST['user-surname']);
			$user_profession = htmlspecialchars($_POST['user-profession']);
			$user_info = htmlspecialchars($_POST['user-info']);
			$userid = $_COOKIE['userid'];

			$query1 = query("UPDATE users SET name=:user_name, surname=:user_surname, profession=:user_profession, info=:user_info WHERE id=:userid", compact('user_name', 'user_surname', 'user_profession', 'user_info', 'userid'));

			header('Location: index.php');

			break;
						
		case 'newproject':
			$userid = $_COOKIE['userid'];
			$name = htmlspecialchars($_POST['name']);
			$description = htmlspecialchars($_POST['description']);
			$city = htmlspecialchars($_POST['city']);
			$summa = htmlspecialchars($_POST['summa']);
			$days = htmlspecialchars($_POST['days']);
			//$video = htmlspecialchars($_POST['video']);
			$bank_account = htmlspecialchars($_POST['bank-account']);
			$user_name = htmlspecialchars($_POST['user-name']);
			$user_surname = htmlspecialchars($_POST['user-surname']);
			$user_profession = htmlspecialchars($_POST['user-profession']);
			$user_info = htmlspecialchars($_POST['user-info']);

			$maxid = sequery("SELECT id FROM projects ORDER BY id DESC LIMIT 1");
			$maxid = (int)$maxid['id'] + 1;
			$type = substr($_FILES['img']['type'], 6);
			$video = $maxid.'.'.$type;


			$query = query("INSERT INTO projects (userid, name, description, city, summa, days, video, bank_account) VALUES (:userid, :name, :description, :city, :summa, :days, :video, :bank_account)", compact('userid', 'name', 'description', 'city', 'summa', 'days', 'video', 'bank_account'));

			$query1 = query("UPDATE users SET name=:user_name, surname=:user_surname, profession=:user_profession, info=:user_info WHERE id=:userid", compact('user_name', 'user_surname', 'user_profession', 'user_info', 'userid'));

			move_uploaded_file($_FILES['img']['tmp_name'], 'catalog/'.$video);

			header('Location: index.php');

			break;
		case 'sendDonate':
			$projectid = $_POST['project_id'];
			$donate = $_POST['donate'];

			$query = sequery("SELECT donated FROM projects WHERE id=:projectid and status=1 LIMIT 1", compact('projectid'));
			$donate1 = (int)$donate;
			$donate = (int)$donate + (int)$query['donated'];

			$query = query("UPDATE projects SET donated=:donate WHERE id=:projectid and status=1", compact('donate', 'projectid'));
			if (authCheck()) {
				$userid = $_COOKIE['userid'];
				$query = query("INSERT INTO donates (userid, projectid, donate) VALUES (:userid, :projectid, :donate1)", compact('userid', 'projectid', 'donate1'));
			}
			echo 'ok';
			break;
		case 'set_sort':
			session_start();
			$_SESSION['sort'] = $_POST['sort'];
			$_SESSION['sort_text'] = $_POST['sort_text'];
			break;		
		default:
			# code...
			break;
	}
}
?>