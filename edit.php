<?php
	include("files/models.php");
	
	$id = mysql_real_escape_string($_COOKIE['id']);
	
	$info = mysql_fetch_assoc(mysql_query("SELECT `id`, `email`, `name`, `surname` FROM `users` WHERE `id` = '".$id."'"));
	
	include_once("files/edit.php");
	
	if(isset($_POST['submit']))
		edit($id, $_POST['name'], $_POST['surname']);
?>