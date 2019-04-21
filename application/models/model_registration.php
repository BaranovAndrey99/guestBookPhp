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

		/**
		 * Проверка длины.
		 */
		public function length_check($value, $min, $max) {
			if(strlen($value) < $min or strlen($value) > $max) {
				return false;
			} else {
				return true;
			}
		}
	}

	class Model_Registration extends Model {

		public function connect_db() {
			define("DB_SERVER", "127.0.0.1");
			define("DB_USER", "learningtest12");
			define("DB_PASSWORD", "3CDLuNAl");
			define("DB_DATABASE", "learningtest12");

			$guest_book_oop = mysqli_connect(DB_SERVER , DB_USER, DB_PASSWORD, DB_DATABASE);
			return $guest_book_oop;
		}
		public function registration_handler() {
			/**
			 * Если нажата кнопка ОК в форме регистрации,
			 * то проводим проверку на ввод данных и их валидацию.
			 */
			
			if(isset($_POST['reg_ok'])){
				$reg_name = Validation::filling_test($_POST['reg_name'], $reg_name, "Заполните поле имени.<br>");
				$reg_mail = Validation::filling_test($_POST['reg_mail'], $reg_mail, "Заполните поле почты.<br>");
				$reg_nick = Validation::filling_test($_POST['reg_nick'], $reg_nick, "Заполните поле никнейма.<br>");
				$reg_pass1 = Validation::filling_test($_POST['reg_pass1'], $reg_pass1, "Заполните поле пароля.<br>");
				$reg_pass2 = Validation::filling_test($_POST['reg_pass2'], $reg_pass2, "Повторите пароль.<br>");

				/**
				 * Если все поля заполнены.
				 */
				if(isset($reg_name) and isset($reg_mail) and isset($reg_nick) and isset($reg_pass1) and isset($reg_pass2)) {
					/**
					 * Проверяем почту на валидность.
					 */
					$email_validate = filter_var($reg_mail, FILTER_VALIDATE_EMAIL);
		    		if(!$email_validate){
		        		exit("Неправильный формат почты.");
		    		}
					/**
				 	* Проверяем совпадение паролей.
				 	* Если совпали, то идем дальше.
				 	*/
				 	if($reg_pass1 != $reg_pass2) {
				 		exit("Пароли не совпадают");
				 	}
				 	/**
				 	 * После прохождения данными проверки на совпадение паролей
				 	 * и прохождения почтой валидации, можно приступить к приведению
				 	 * данных к нужному для сохранения виду, а именно:
				 	 * 
				 	 * stripslashes     - Удаление бэкслешей и прочего.
				 	 * htmlspecialchars - Представление спецсимволов в виде сущностей.
				 	 * trim		        - Удаление лишних пробелов.
				 	 */
				 	
				 	/**
				 	 * Приводим данные к нормальному виду.
				 	 */
				 	$reg_name = Validation::formatting_fields($reg_name);
				 	$reg_mail = Validation::formatting_fields($reg_mail);
				 	$reg_nick = Validation::formatting_fields($reg_nick);
				 	$reg_pass1 = Validation::formatting_fields($reg_pass1);
				 	
				    /**
				     * Проверяем длину:
				     * 	Имя     - не менее 3 и не более 20.
				     * 	Ник     - не менее 5 и не более 20.
				     * 	Пароль  - не менее 8 и не более 30.
				     */
				    if(!Validation::length_check($reg_name, 3, 20)) {
				    	exit("Имя не должно быть меньше 3х и больше 20ти символов");
				    }
				    if(!Validation::length_check($reg_nick, 5, 20)) {
				    	exit("Ник не должен быть меньше 5ти и больше 20ти символов");
				    }
				    if(!Validation::length_check($reg_pass1, 8, 30)) {
				    	exit("Пароль не должен быть меньше 8ми и больше 30ти символов");
				    }

				    /**
				     * Хешируем пароль.
				     */
				    $password = password_hash($reg_pass1, PASSWORD_DEFAULT);

				    /**
				     * Подключаемся к бд.
				     */
				    $guest_book_oop = Model_Registration::connect_db() or die("Ошибка"); 
				    /**
				     * Проверка на существование пользователей
				     * с таким же ником и почтой. Если таковые имеются,
				     * то ошибка. Если таких нет - добавляем в БД.
				     */
				    $second_nick_user = mysqli_query($guest_book_oop, "SELECT id FROM users WHERE nickname = '$reg_nick'");
				    $second_nick_user_cnt = mysqli_num_rows($second_nick_user);

				    $second_mail_user = mysqli_query($guest_book_oop, "SELECT id FROM users WHERE email = '$reg_mail'");
				    $second_mail_user_cnt = mysqli_num_rows($second_mail_user);

				    if($second_nick_user_cnt != 0) {
		        		exit ("Пользователь с таким никнеймом уже существует.");
		    		}
				    if ($second_mail_user_cnt != 0){
				        exit ("Пользователь с такой почтой уже существует.");
				    }
					
				    /**
				     * Если все хорошо - проводим INSERT.
				     */
				    $insert_user = mysqli_query($guest_book_oop, "INSERT INTO users (name, email, nickname, password) VALUES ('$reg_name','$reg_mail','$reg_nick','$password')");

				    /**
				     * Проверяем успешность инсерта.
				     */
				    if(!$insert_user){
		        		echo "Ошибка регистрации. Попробуйте еще раз.";
				    } else {
				        echo "Вы успешно зарегистрированы.";
				        mysqli_close($guest_book_oop);
				    }
				} else {
					exit();
				}
			}
		}
	}
?>