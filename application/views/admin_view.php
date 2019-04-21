<div class="left half_block">
	<div class="ava">
		<?php echo "<img src='".$data['get_ava']."' alt=''>"; ?>
	</div>
	
	<p class="h2">Администратор: <?php echo $_SESSION['nickname']; ?></p>
	<div class="ava_sending">
		<form enctype="multipart/form-data" method="post"> 
			<input name="picture" type="file" accept="image/jpeg" />
			<input type="submit" name="ava_in" value="Загрузить" />
		</form>	
	</div>
	<div class="logout">
		<form action='' method='post'>
			<a href='/logout' class="logout_btn">Выход</a>
		</form>
	</div>
</div>
<div class="container white_area">
	<p class="h3">Удаление пользователей</p>
	<form action="" method="post">
		<input name="del_user" type="text" placeholder="Удалить пользователя по нику"><br>
		<input name="ok_del_user" type="submit" value="Удалить">
	</form>
	<?php 
		$post_sender = new Model_Admin;
		$post_sender->delete_user(); 
	?>
</div>
<div class="container white_area">
	<p class="h3">Удаление записей</p>
	<form action="" method="post">
		<input name="del_post" type="text" placeholder="Удалить запись по id"><br>
		<input name="ok_del_post" type="submit" value="Удалить">
	</form>
	<?php 
		$post_sender = new Model_Admin;
		$post_sender->delete_post(); 
	?>
</div>