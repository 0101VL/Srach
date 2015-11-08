<?php
	require_once("base.php");
	require_once("files/models.php");
	if(isset($_COOKIE['id']))
		$user_info = mysql_fetch_assoc(mysql_query("SELECT `id`, `email`, `name`, `surname` FROM `users` WHERE `id` = '".mysql_real_escape_string($_COOKIE['id'])."'"));
	
	if(!isset($user_info) OR !isset($_COOKIE['id']) OR !isset($_COOKIE['hash'])) {
		exit_();
	}
?>