<?php  
	class Validation {

		/**
		 * Проверка на заполнение.
		 */
		public function filling_test ($fill_name, $result_variable, $error) {
			if(!empty($fill_name)){
					$result_variable = $fill_name;
					return $result_variable;
				} else {
					echo $error;
				}
		}
		/**
		 * Удаление бекслешей, представление спецсимволов в виде сущностей,
		 * удаление лишних пробелов.
		 */
		public function formatting_fields($formatted_field) {
			$formatted_field = stripslashes($formatted_field);
			$formatted_field = htmlspecialchars($formatted_field);
			$formatted_field = trim($formatted_field);

			return $formatted_field;
		}
	}
	class Model_Autorization extends Model {

		public function connect_db() {
			define("DB_SERVER", "127.0.0.1");
			define("DB_USER", "learningtest12");
			define("DB_PASSWORD", "3CDLuNAl");
			define("DB_DATABASE", "learningtest12");

			$guest_book_oop = mysqli_connect(DB_SERVER , DB_USER, DB_PASSWORD, DB_DATABASE);
			return $guest_book_oop;
		}
		
		public function autorization_handler() {
			if(isset($_POST['login_ok'])) {
				/**
				 * Проверяем поля на заполнение.
				 */
				$login_nick = Validation::filling_test($_POST['login_nick'], $login_nick, "Введите никнейм.<br>");
				$login_pass = Validation::filling_test($_POST['login_pass'], $login_pass, "Введите пароль.<br>");
				
				if(!isset($login_nick) or !isset($login_pass)) {
					exit();
				}
				/**
				 *   Удаляем бекслеши и прочее.
				 */
				$login_nick = Validation::formatting_fields($login_nick);
				$login_pass = Validation::formatting_fields($login_pass);

			    /**
			     * Проверяем существование такого пользователя.
			     */
			   	$guest_book_oop = Model_Autorization::connect_db() or die("Ошибка"); 
			    $user_exist = mysqli_query($guest_book_oop, "SELECT * FROM users WHERE nickname = '$login_nick'");
			    $num_user_exist = mysqli_num_rows($user_exist);

			    
			    if($num_user_exist != 1) {
			    	exit("Такого пользователя не существует. <a href='/registration'>Регистрация.</a>");
			    }

			    
			    /**
			     * Берем хеш пароля из БД.
			     */
			    
			    $hash_password = mysqli_query($guest_book_oop, "SELECT password FROM users WHERE nickname='$login_nick'");
			    $hash_password_str = mysqli_fetch_assoc($hash_password);

			    /**
			     * Сверяем пароли.
			     */
			    $password_verify = password_verify($login_pass, $hash_password_str['password']);

			    if(!$password_verify) {
			    	exit("Неверный пароль.");
			    } else {
					$_SESSION['nickname'] = $login_nick;
			    	$admin_stat = mysqli_query($guest_book_oop, "SELECT rights FROM users WHERE nickname = '$login_nick'");
			    	$admin_stat_arr = mysqli_fetch_assoc($admin_stat);
			    	if($admin_stat_arr['rights'] == NULL){
			    		echo "Вы успешно авторизованы";
			    	} else {
			    		echo "<meta http-equiv='refresh' content='0; url=/admin'>";
			    	}  	
			    }
			}
		}
	}
?>