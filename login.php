<?php
	include("files/models.php");
	
	
	include_once("files/login.php");
	if(isset($_POST['submit']))
		login($_POST['email'], $_POST['password']);
?>