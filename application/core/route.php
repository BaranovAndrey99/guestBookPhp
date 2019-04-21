<?php  
	/**
	 * Создаем класс Route запускающий методы контроллеров,
	 * генерирующих вид страниц.
	 */
	class Route {
		/**
		 * [start description] - Запускает маршрутизатор.
		 * @return [type] [description]
		 */
		static function start() {
			session_start();
			/**
			 * Имя контроллера и действие по умолчанию.
			 */
			$controller_name = 'Main';
			$action_name = 'index';

			/**
			 * Массив, состоящий из имен директорий пути к текущей директории.
			 */
			$routes = explode('/', $_SERVER['REQUEST_URI']);
		
			/**
			 * Контроллером будет вторая директория.
			 */
			if (!empty($routes[1])) {	
				$controller_name = $routes[1];
			}
			
			
			/**
			 * Действием будет третья директория.
			 */
			if (!empty($routes[2])) {
				$action_name = $routes[2];
			}

			/**
			 * Создаются имена будующих классов,
			 * соответствующих контроллерам.
			 */
			$model_name = 'Model_'.$controller_name;
			$controller_name = 'Controller_'.$controller_name;
			$action_name = 'action_'.$action_name;


			/**
			 * Берем файл соответствующей модели.
			 * Создаем переменную пути к нему.
			 * Если файл существует, то подключаем его.
			 */
			$model_file = strtolower($model_name).'.php';
			$model_path = "application/models/".$model_file;
			if(file_exists($model_path)) {
				include "application/models/".$model_file;
			}

			/**
			 * Берем файл соответствующей контроллеру.
			 * Создаем переменную пути к нему.
			 * Если файл существует, то подключаем его.
			 * Иначе выдаем ошибку.
			 */
			$controller_file = strtolower($controller_name).'.php';
			$controller_path = "application/controllers/".$controller_file;
			if(file_exists($controller_path))
			{
				include "application/controllers/".$controller_file;
			} else {
				/**
				 * Сдесь лучше доделать, чтобы выводить не просто
				 * Error404, а еще кидать исключение.
				 */
				Route::ErrorPage404();
			}

			/**
			 * Создадим сам контроллер соответствующего класса.
			 */
			$controller = new $controller_name;

			/**
			 * Действие для этого контроллера будет содержать следующая переменная.
			 */
			$action = $action_name;
			/**
			 * Если существует соответствующий метод:
			 */
			if(method_exists($controller, $action))
			{
				/**
				 * Вызываем действие контроллера.
				 */
				$controller->$action();
			} else {
				/**
				 * Иначе выводим Error404, а лучше кинуть исключение.
				 */
				Route::ErrorPage404();
			}
		}
		/**
		 * [ErrorPage404 description] - Метод вывода Error404.
		 */
		function ErrorPage404() {
	        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
	        header('HTTP/1.1 404 Not Found');
			header("Status: 404 Not Found");
			header('Location:'.$host.'404');
	    }
	}
?>