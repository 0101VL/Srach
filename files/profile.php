<!doctype html>
<html>
	<head>
		<title>Редактирование данных</title>
		<meta charset="utf-8">
	</head>
	<body>
		<h1><?php if($profile['name'] != "" AND $profile['name'] != NULL) echo $profile['name']; ?></h1>
		<h1><?php if($profile['surname'] != "" AND $profile['surname'] != NULL) echo $profile['surname']; ?></h1>
		<h1><?php if($profile['raiting'] != "" AND $profile['raiting'] != NULL) echo $profile['raiting']; ?></h1>
	</body>
</html>