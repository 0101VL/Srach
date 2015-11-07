<?php
	require_once("/../base.php");
	require_once("/../header.php");
	
	function generateCode($length) { //Генерация хэша
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789';
		$code = '';
		$clen = strlen($chars) - 1;
		while (strlen($code) < $length) {
			$code .= $chars[mt_rand(0, $clen)];
		}
		return $code;
	}
	
	function registration($email, $password, $password_confirm) // Регистрация
	{
		$err = array();
			
		if(!preg_match("/^([A-z0-9_\.-]{2,64}+)@([A-z0-9_\.-]+){1,8}\.([A-z\.]{1,15})$/", $email)) {
			$err[] = 'Email не подходит по условию';
		}
		if(!preg_match('/^[A-Za-z0-9]{6,25}$/', $password)) {
			$err[] = 'Пароль не подходит по условию';
		}
		if($password !== $password_confirm) {
			$err[] = 'Пароли не совпадают';
		}
		if(count($err) == 0) {
			$hash = md5(generateCode(10));
			mysql_query("INSERT INTO `users` SET `email` = '".mysql_real_escape_string($email)."', `password` = '".md5(md5($password))."', `hash` = '".$hash."'") or die(mysql_error());
			$last_id = mysql_fetch_assoc(mysql_query("SELECT MAX(`id`) as max_id FROM `users`"));
			setcookie('id', $last_id['max_id'], time() + 60*60*24*14, '/');
			setcookie('hash', $hash, time() + 60*60*24*14, '/');
			header('Location: /');
		}
		else {
			echo '<strong>Ошибки: </strong><br>';
			foreach($err as $errors) {
				echo $errors.'<br>';
			}
		}
	}
	
	function edit($id, $name, $surname)
	{
		$err = array();
			
		if($name != "") {
			if(!preg_match('/^[А-яёЁ\-]{1,50}$/', $name)) {
				$err[] = 'Имя не подходит по условию';
			}
		}
		
		if($surname != "") {
			if(!preg_match('/^[А-яёЁ\-]{1,50}$/', $surname)) {
				$err[] = 'Фамилия не подходит по условию';
			}
		}
		
		if(count($err) == 0) {
			mysql_query("UPDATE `users` SET `name` = '".mysql_real_escape_string($name)."', `surname` = '".mysql_real_escape_string($surname)."' WHERE `id` = '".mysql_real_escape_string($id)."'") or die(mysql_error());
			header('Location: /');
		}
		else {
			echo '<strong>Ошибки: </strong><br>';
			foreach($err as $errors) {
				echo $errors.'<br>';
			}
		}
	}
	
	function exit_()
	{
		setcookie('id', '', time() - 60*60*24*14, '/');
		setcookie('hash', '', time() - 60*60*24*14, '/');
	}
	
	function login($email, $password)
	{
		$email = mysql_real_escape_string($email); // Получаем E-mail
		
		$password = mysql_real_escape_string($password); // Получаем Password
		
		$data = mysql_fetch_assoc(mysql_query("SELECT `password`, `id` FROM `users` WHERE `email` = '".$email."' LIMIT 1"));

		if($data['password'] === md5(md5($password))) {
			$hash = md5(generateCode(10));

			mysql_query("UPDATE `users` SET `hash` = '".$hash."' WHERE `email` = '".$email."'");

			setcookie('id', $data['id'], time() + 60*60*24*14, '/');
			setcookie('hash', $hash, time() + 60*60*24*14, '/');
		}
	}
	
	function profile($id)
	{
		$id = mysql_real_escape_string($id);
		
		$query_profile = mysql_query("SELECT `name`, `surname`, `raiting`, `avatar` FROM `users` WHERE `id` = '".$id."'");
		$profile = mysql_fetch_assoc($query_profile);
		return $profile;
	}
?>