<?php
	require_once("../base.php");
	function generateCode($length) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789';
		$code = '';
		$clen = strlen($chars) - 1;
		while (strlen($code) < $length) {
			$code .= $chars[mt_rand(0, $clen)];
		}
		return $code;
	}
	
	if(isset($_POST['submit'])) {
		$err = array();
		
		if(!preg_match("/^([A-z0-9_\.-]{2,64}+)@([A-z0-9_\.-]+){1,8}\.([A-z\.]{1,15})$/", $_POST['email'])) {
			$err[] = 'Email не подходит по условию';
		}
		if(!preg_match('/^[A-Za-z0-9]{6,25}$/', $_POST['password'])) {
			$err[] = 'Пароль не подходит по условию';
		}
		if($_POST['password'] != $_POST['password_confirm']) {
			$err[] = 'Пароли не совпадают';
		}
		if(count($err) == 0) {
			$hash = md5(generateCode(10));
			mysql_query("INSERT INTO `users` SET `email` = '".mysql_real_escape_string($_POST['email'])."', `password` = '".md5(md5($_POST['password']))."', `hash` = '".$hash."'") or die(mysql_error());
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