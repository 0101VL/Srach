<?php
	require_once("../base.php");

	if(isset($_POST['submit'])) {
		$err = array();
		if(!preg_match("/^([A-zА-яёЁ0-9\!\-\_\+\.\,?\;\:]{2, 150})$/", $_POST['title'])) {
			$err[] = 'Название не подходит по условию';
		}
		
		if($_POST['add_guest'] == "on") {
			if(!preg_match("/^([A-z0-9_\.-]{2,64}+)@([A-z0-9_\.-]+){1,8}\.([A-z\.]{1,15})$/", $_POST['email_guest'])) {
				$err[] = 'Email пользователя не подходит по условию';
			}
		}

		if(count($err) == 0) {
			$hash = md5(generateCode(10));
			mysql_query("INSERT INTO `rooms` SET `title` = '".mysql_real_escape_string($_POST['title'])."', `first_p` = '', `hash` = '".$hash."'") or die(mysql_error());
			$last_id = mysql_fetch_assoc(mysql_query("SELECT MAX(`id`) as max_id FROM `users`"));
			setcookie('id', $last_id['max_id'], time() + 60*60*24*14, '/');
			setcookie('hash', $hash, time() + 60*60*24*14, '/');
			header('Location: ../');
		}
		else {
			echo '<strong>Ошибки: </strong><br>';
			foreach($err as $errors) {
				echo $errors.'<br>';
			}
		}
	}
?>