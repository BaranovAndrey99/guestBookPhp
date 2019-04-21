<div class="container white_area">
	<form action="" method="post">
		<p class="h2">Форма регистрации</p>
		<input name="reg_name" type="text" placeholder="Имя"><br>
		<input name="reg_mail" 	type="text" placeholder="Почта"><br>
		<input name="reg_nick" type="text" placeholder="Никнейм"><br>
		<input name="reg_pass1" type="password" placeholder="Пароль"><br>
		<input name="reg_pass2" type="password" placeholder="Повтор пароля"><br>
		<input name="reg_ok" type="submit" value="ОК"><br>
	</form>
</div>
<!-- Поле вывода ошибок при вводе -->
<div class="container white_area error_area">
	<?php 
		//Model_Registration::registration_handler();
	?>
</div>