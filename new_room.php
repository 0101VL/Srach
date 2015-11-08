<?php
	include("files/models.php");
	
	include_once("files/new_room.php");
	
	$add_guest = 0;
	if(isset($_POST['add_guest']))
		if($_POST['add_guest'] == "on") $add_guest = 1;
	
	if(isset($_POST['submit']))
		new_room($_POST['title'], $add_guest, $_POST['email_guest'], $_POST['date'], $_POST['time']);
?>