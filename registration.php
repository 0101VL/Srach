<?php
	include("files/models.php");
	
	
	include_once("files/registration.php");
	if(isset($_POST['submit']))
		registration($_POST['email'], $_POST['password'], $_POST['password_confirm']);
?>