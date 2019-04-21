<?php 
 
	class Controller_404 extends Controller {

		function __construct() {
			$this->view = new View();
		}

		function action_index() {
			$this->view->generate('../views/404_view.php', '../views/template_view.php', $data);
		}
	}
?>