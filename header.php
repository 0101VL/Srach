<?php
	require_once("base.php");
	$user_info = mysql_fetch_assoc(mysql_query("SELECT `id`, `email`, `name`, `surname` FROM `users` WHERE `id` = '".mysql_real_escape_string($_COOKIE['id'])."'"));
?>