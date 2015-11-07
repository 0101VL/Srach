<?php
	require_once("base.php");
	require_once("files/hash.php");

	$email = mysql_real_escape_string($_POST['email']); // Получаем E-mail
	
	$data = mysql_fetch_assoc(mysql_query("SELECT `password`, `id` FROM `users` WHERE `email` = '".$email."'' LIMIT 1"));

	if($data['password'] === md5(md5($_POST['password']))) {
		$hash = md5(generateCode(10));

		mysql_query("UPDATE `users` SET `hash` = '".$hash."' WHERE `email` = '".$email."'");

		setcookie('id', $data['id'], time() + 60*60*24*14, '/');
		setcookie('hash', $hash, time() + 60*60*24*14, '/');
	}
?>