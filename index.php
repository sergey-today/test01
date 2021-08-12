<!doctype html>

<head>

	<title>Тестовое задание</title>

	<link type="image/x-icon" rel="icon" href="favicon.ico">

	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta http-equiv="content language" content="ru">

	<link rel="stylesheet" type="text/css" href="style_null.css?time=<? echo time(); ?>">
	<link rel="stylesheet" type="text/css" href="style.css?time=<? echo time(); ?>">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

</head>

<body>

	<form id="form">
		<div id="content">
			<div id="form_div">
				<input 
					id="form_name"
					type="text" 
					name="name" 
					placeholder="Ваше имя" 
				>
				<input 
					id="form_phone"
					type="tel" 
					name="phone" 
					placeholder="Номер телефона" 
				>
				<input 
					id="form_email"
					type="email" 
					name="email" 
					placeholder="Электронная почта" 
				>
				<input 
					id="form_upload"
					type="file" 
					name="upload" 
					accept=".jpg, .jpeg" 
					multiple
				>
				<label 
					id="label_form_upload"
					for="form_upload"
				>
					<div id="label_check_drop"></div>
				</label>
				<div id="response_div">
					Заполните все поля формы<br>
					и при необходимости прикрепите фото.
				</div>
				<button 
					id="form_submit"
					type="button" 
				>
					Отправить
				</button>
			</div>
		</div>
	</form>

	<script src="script.js?t_time=<? echo time(); ?>" type="text/javascript"></script>

</body>

</html>