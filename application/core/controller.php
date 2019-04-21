<?php  
	class Controller {
		public $model;
		public $view;

		/**
		 * [__construct description] - создание вида.
		 */
		function __construct() {
			$this->view = new View();
		}

		/**
		 * [action_index description] - действие, вызываемое по умолчанию.
		 * @return [type] [description]
		 */
		function action_index() {

		}
	}
?>