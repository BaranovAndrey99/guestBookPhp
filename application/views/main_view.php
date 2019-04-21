
	
<section>
	<div class="container white_area" id="status_actions">
		<!-- Область статуса пользователя. -->
		<p class="h3" id="status">Статус: <?php echo $data['user']; ?></p>
		<!-- Область кнопок Авторизация и Регистрация или Выход. -->
		<div id="status_buttons"> 
			<?php echo $data['status_btns']; ?>	
		</div>
	</div>
</section>

<section>
	<!-- Область отправки поста. -->
	<div class="container white_area">
		<form action="" method="post">
			<textarea name="sended_text" id="" cols="120" rows="8"></textarea><br>
			<input name="send_post_btn" type="submit" value="Отправить"><br>
			<label id="anon_check_label"><input name="anon_checkbox" type="checkbox"><p>Анонимно<p></label><br>
		</form>
		<?php 
			$post_sender = new Model_Main;
			$post_sender->post_sender(); 
		?>
	</div>	
</section>

<section>
	<!-- Область листинга постов. -->
	<div class="container white_area" id="post_list">
		<?php
			$post_seter = new Model_Main;
			$post_seter->post_seter();
		?>
	</div>
	<!-- Область переключателя страниц. -->
	<div class="container white_area">
		<form id="pages" action="" method="post">
		<?php
			$page_listener = new Model_Main;
			$page_listener->page_listener();
		?>
		</form>
	</div>
</section>

