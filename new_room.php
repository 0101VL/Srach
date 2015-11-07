<!doctype html>
<html>
	<head>
		<title>Создание новой комнаты</title>
		<meta charset="utf-8">
	</head>
	<body>
		<form method="post" action="files/new_room.php">
			Название комнаты: <input type="text" name="title"><br>
			<input type="checkbox" id="checkbox" name="add_guest">Добавить пользователя
			<span id="new_guest">E-mail пользователя: <input type="text" name="email_guest"></span><br>
			<input type="submit" name="submit" value="Создать комнату"><br>
		</form>
		<script>
			var checkbox = document.getElementById("checkbox");
			var new_guest = document.getElementById("new_guest");
			new_guest.style.display = "none";
				 checkbox.onchange = function() {
					new_guest.style.display = (new_guest.style.display == "none") ? "block" : "none";
				 }
		</script>
	</body>
</html>