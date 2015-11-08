<?php
	require_once("/../base.php");
	require_once("/../header.php");
	
	/* ГЕНЕРАЦИЯ ХЭША */
	function generateCode($length) { //Генерация хэша
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789';
		$code = '';
		$clen = strlen($chars) - 1;
		while (strlen($code) < $length) {
			$code .= $chars[mt_rand(0, $clen)];
		}
		return $code;
	}
	
	/* РЕГИСТРАЦИЯ */
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
			header('Location: edit');
		}
		else {
			echo '<strong>Ошибки: </strong><br>';
			foreach($err as $errors) {
				echo $errors.'<br>';
			}
		}
	}
	
	/* РЕДАКТИРОВАНИЕ ПРОФИЛЯ*/
	function edit($id, $name, $surname)
	{
		$err = array();
			
		if($name != "") {
			if(!preg_match('/^[А-яёЁA-z\-]{1,50}$/', $name)) {
				$err[] = 'Имя не подходит по условию';
			}
		}
		
		if($surname != "") {
			if(!preg_match('/^[А-яёЁA-z\-]{1,50}$/', $surname)) {
				$err[] = 'Фамилия не подходит по условию';
			}
		}
		if($name == "") $name = NULL;
		if($surname == "") $surname = NULL;
		
		if(count($err) == 0) {
			mysql_query("UPDATE `users` SET `name` = '".mysql_real_escape_string($name)."', `surname` = '".mysql_real_escape_string($surname)."' WHERE `id` = '".mysql_real_escape_string($id)."'") or die(mysql_error());
			header('Location: profile.php');
		}
		else {
			echo '<strong>Ошибки: </strong><br>';
			foreach($err as $errors) {
				echo $errors.'<br>';
			}
		}
	}
	
	/* ВЫХОД С САЙТА */
	function exit_()
	{
		setcookie('id', '', time() - 60*60*24*14, '/');
		setcookie('hash', '', time() - 60*60*24*14, '/');
	}
	
	/* АВТОРИЗАЦИя */
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
	
	/* ВЫВОД ПРОФИЛЯ */
	function profile($id)
	{
		$id = mysql_real_escape_string($id);
		
		$query_profile = mysql_query("SELECT `name`, `surname`, `raiting`, `avatar` FROM `users` WHERE `id` = '".$id."'");
		$profile = mysql_fetch_assoc($query_profile);
		return $profile;
	}
	
	/* НОВАЯ КОМНАТА */
	function new_room($title, $add_guest, $email_guest, $date, $time)
	{
		$rooms_isset_of_user = mysql_fetch_assoc(mysql_query("SELECT COUNT(`id`) as count FROM `rooms` WHERE (`first_p` = ".mysql_real_escape_string($_COOKIE['id'])." OR `second_p` = ".mysql_real_escape_string($_COOKIE['id']).") AND `active` = 1"));
		
		$err = array();
		
		if($rooms_isset_of_user['count'] > 0) {
			$err[] = 'Вы уже участвуете в какой-либо комнате. Завершите участие в комнате, чтобы начать новый раунд';
		}
		if(mb_strlen($title, 'utf-8') < 3) {
			$err[] = 'Название не подходит по условию';
		}
		
		if(!preg_match("/^([0-9]{1,2}).([0-9]{1,2}).([0-9]{4})$/", $date)) {
			$err[] = 'Дата указана неверно';
		}
		
		if(!preg_match("/^([0-9]{2}):([0-9]{2})$/", $time)) {
			$err[] = 'Время указано неверно';
		}
		$second_id = 0;
		if($add_guest == 1) {
			$second_user = mysql_fetch_assoc(mysql_query("SELECT `id` FROM `users` WHERE `email` = '".$email_guest."'"));
			
			if($second_user == true) {
				if(!preg_match("/^([A-z0-9_\.-]{2,64}+)@([A-z0-9_\.-]+){1,8}\.([A-z\.]{1,15})$/", $email_guest)) {
					$err[] = 'Email пользователя не подходит по условию';
				}
				$second_id = $second_user['id'];
			}
		}
		if(count($err) == 0) {
		
			$date = explode(".", $date);
			if($date[0] < 10) 
				$date[0] = '0' . $date[0];
			
			if	($date[1] < 10)
				$date[1] = '0' . $date[1];
				
			$date = $date[2].'-'.$date[1].'-'.$date[0];
			
			$time = $time.":00";
			
			$datetime = $date . ' ' . $time;
			
			$hash = md5(generateCode(10));
			mysql_query("INSERT INTO `rooms` SET `title` = '".mysql_real_escape_string($title)."', `first_p` = '".mysql_real_escape_string($_COOKIE['id'])."', `second_p` =  '".$second_id."', `time_start` = '".$datetime."', `active` = 1") or die(mysql_error());
			header('Location: /');
		}
		else {
			echo '<strong>Ошибки: </strong><br>';
			foreach($err as $errors) {
				echo $errors.'<br>';
			}
		}
	}
?>