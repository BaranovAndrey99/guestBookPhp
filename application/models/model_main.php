<?php  
	class Model_Main extends Model {
		public $max_posts_in_page;
		public $num_all_posts;
		public $now_page;

		public function connect_db() {
			define("DB_SERVER", "127.0.0.1");
			define("DB_USER", "learningtest12");
			define("DB_PASSWORD", "3CDLuNAl");
			define("DB_DATABASE", "learningtest12");

			$guest_book_oop = mysqli_connect(DB_SERVER , DB_USER, DB_PASSWORD, DB_DATABASE);
			return $guest_book_oop;
		}
		/**
		 * Определяет пользователя(гостя или ник авторизованного);
		 */
		public function get_user() {
			if($_SESSION['nickname'] == null) {
				$user = "Гость";
			} else {
				$user = $_SESSION['nickname'];
			}
			return $user;
		}
		/**
		 * Если пользователь авторизован,
		 * то выводим кнопку выхода.
		 * Иначе кнопки логина и регистрации.
		 */
		public function get_status_btns() {
			if(empty($_SESSION['nickname'])) {
				$status_btns = "<a href='/registration'>Регистрация</a> |
								<a href='/autorization'>Авторизация</a>";
			} else {
				$status_btns = "<form action='' method='post'>
									<a href='/logout'>Выход</a>
								</form>";
			}
			return $status_btns;
		}

		/**
		 * Отправщик поста в БД.
		 */
		public function post_sender() {
			if(isset($_POST['send_post_btn'])){
				if(!empty($_POST['sended_text'])) {
					$texts = $_POST['sended_text'];
					$dates = date("Y-m-d H:i:s");
					/**
					 * Если активирована анонимная отправка и пользователь
					 * авторизован, то он отправляет запись анонимно.
					 * Если он не авторизован, то он так и так гость.
					 */
					if($_POST['anon_checkbox'] == true && !empty($_SESSION['nickname'])) {
						$users = "Анонимно";
					} else {
						$users = Model_Main::get_user();
					};
					
					$guest_book_oop = Model_Main::connect_db() or die("Ошибка" . mysqli_error($guest_book_oop));

					$sending_query = mysqli_query($guest_book_oop, "INSERT INTO posts (user, dates, texts) VALUES ('$users', '$dates', '$texts')") or die("Ошибка отправки");
					mysqli_close($guest_book_oop);
				} else {
					echo "<p>Поле не заполнено</p>";
				}
			} 
		}

		/**
		 * Вывод постов.
		 */
		public function post_seter() {

			$guest_book_oop = Model_Main::connect_db() or die("Ошибка");

			if($_POST['page'] != null) {
				$this->now_page = $_POST['page'];
			} else {
				$this->now_page = 1;
			}
			
			$min_lim = ($this->now_page - 1) * 5;

			$now_printed_posts = mysqli_query($guest_book_oop, "SELECT user, dates, texts FROM posts ORDER BY dates DESC LIMIT $min_lim, 5");
			$array = array();
			while ($row = mysqli_fetch_assoc($now_printed_posts)) {
			    $array[] = $row;
			}
			for($i = 0; $i < 5; $i++){
				$res = $array[$i];
				if($res['texts'] == null){
					continue;
				}
				echo "<div class='white_area post_div'>".$res['user']." (".$res['dates'].")<br>".$res['texts']."</div>";
			}
			//var_dump($array[]);

			/**
			 * В этом вар дампе я ожидал увидеть массив состоящий из строк,
			 * являющихся сообщениями из бд.
			 * 
			 * Теоритически вместо вар-дампа тут стоит цикл фор, который выводит
			 * элементы массива, пока он не закончится.
			 * 
			 * При нажатии страницы 1 - массив строк из БД с нулевой по 4ю.
			 * 						2 - с 5й по 9ю.
			 * 						3 - с 10й по 14ю(если таковые имеются).
			 * 						и т.д
			 * Но вар дамп говорит, что мы передаем boolean в mysqli_fetch_assoc($now_printed_posts);.
			 * 	А это говорит о том, что этот самый boolean - это результат запроса SELECT texts FROM posts LIMIT $min_lim, $max_lim.
			 * 	В чем дело?
			 */
			mysqli_close($guest_book_oop);
		}

		/**
		 * Переключаетль страниц.
		 */
		public function page_listener() {
			$guest_book_oop = Model_Main::connect_db() or die("Ошибка");

			$this->max_posts_in_page = 5;
			$all_posts = mysqli_query($guest_book_oop, "SELECT * FROM posts WHERE id > 0");
			$this->num_all_posts = mysqli_num_rows($all_posts);

			$num_of_pages = ceil($this->num_all_posts / $this->max_posts_in_page);
			$this->now_page = 1;
			for($i = 1; $i <= $num_of_pages; $i++) {
				echo "<input class='page_submit' type='submit' value='$i' name='page'>";
			}
			mysqli_close($guest_book_oop);
		}
	}
?>