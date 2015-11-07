<?php
	include("files/models.php");
	
	$info = mysql_fetch_assoc(mysql_query("SELECT `id`, `email`, `name`, `surname` FROM `users` WHERE `id` = '".mysql_real_escape_string($_COOKIE['id'])."'"));
	
	include_once("files/edit.php");
	
	if(isset($_POST['submit']))
		registration($_POST['email'], $_POST['password'], $_POST['password_confirm']);
		
?>