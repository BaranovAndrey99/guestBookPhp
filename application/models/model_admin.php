<?php  
	class Model_Admin {

		public function connect_db() {
			define("DB_SERVER", "127.0.0.1");
			define("DB_USER", "learningtest12");
			define("DB_PASSWORD", "3CDLuNAl");
			define("DB_DATABASE", "learningtest12");

			$guest_book_oop = mysqli_connect(DB_SERVER , DB_USER, DB_PASSWORD, DB_DATABASE);
			return $guest_book_oop;
		}

		public function check_user() {
			$guest_book_oop = Model_Admin::connect_db() or die("Ошибка");
			$user = $_SESSION['nickname'];
			if($user != null) {
				$admin_stat = mysqli_query($guest_book_oop, "SELECT rights FROM users WHERE nickname = '$user'");
				$admin_stat_arr = mysqli_fetch_assoc($admin_stat);
				if($admin_stat_arr['rights'] != 1) {
					$user = null;
				}
			}
			return $user;
		}

		public function delete_user() {
			if(isset($_POST['ok_del_user'])) {
				/**
				 * Подключение к дб.
				 */
				$guest_book_oop = Model_Admin::connect_db() or die("Ошибка");

				/**
				 * Если поле  не пустое.
				 */
				$deletable_user = $_POST['del_user'];

				if(empty($deletable_user)) {
					echo "<p>Заполните поле</p>";
				}

				/**
				 * Если пользователь существует.
				 */
				$deleting_check = mysqli_query($guest_book_oop, "SELECT * FROM users WHERE nickname = '$deletable_user'");
				$deleting_check_arr = mysqli_fetch_assoc($deleting_check);
				if(!empty($deleting_check_arr)) {
					$del_start = mysqli_query($guest_book_oop, "DELETE FROM users WHERE nickname = '$deletable_user'");
					if(!$del_start) {
						echo "<p>Ошибка удаления</p>";
					}
				} else {
					echo "<p>Пользователя не существует</p>";
				}
			}
		}

		public function delete_post() {
			if(isset($_POST['ok_del_post'])) {
				/**
				 * Подключение к дб.
				 */
				$guest_book_oop = Model_Admin::connect_db() or die("Ошибка");

				/**
				 * Если поле  не пустое.
				 */
				$deletable_post = $_POST['del_post'];

				if(empty($deletable_post)) {
					echo "<p>Заполните поле</p>";
				}

				/**
				 * Если пользователь существует.
				 */
				$deleting_check = mysqli_query($guest_book_oop, "SELECT * FROM posts WHERE id = '$deletable_post'");
				$deleting_check_arr = mysqli_fetch_assoc($deleting_check);
				if(!empty($deleting_check_arr)) {
					$del_start = mysqli_query($guest_book_oop, "DELETE FROM posts WHERE id = '$deletable_post'");
					if(!$del_start) {
						echo "<p>Ошибка удаления</p>";
					}
				} else {
					echo "<p>Записи не существует</p>";
				}
			}
		}
	}
?>