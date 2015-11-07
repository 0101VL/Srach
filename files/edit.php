<!doctype html>
<html>
	<head>
		<title>Редактирование данных</title>
		<meta charset="utf-8">
	</head>
	<body>
		<form method="post">
			<!--Пароль: <input type="password" name="password"><br> //-->
			Имя: <input type="text" name="name"<?php echo ($info['name'] != NULL) ? 'value="'.$info['name'].'"' : '';?>><br>
			Фамилия: <input type="text" name="surname"<?php echo ($info['surname'] != NULL) ? 'value="'.$info['surname'].'"' : '';?>><br>
			<input type="submit" name="submit" value="Изменить"><br>
		</form>
	</body>
</html>