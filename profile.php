<?php
	include("files/models.php");
	
	$id = mysql_real_escape_string($_COOKIE['id']);
	
	$profile = profile($id);
	
	include_once("files/profile.php");
?>