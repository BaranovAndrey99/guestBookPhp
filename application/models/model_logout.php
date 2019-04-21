<?php  
	class Model_Logout extends Model {
		public function logout() {
			unset($_SESSION['nickname']);
			/*
			*	Уничтожаем сессию.
			*/
			session_destroy();
		}
	}
?>