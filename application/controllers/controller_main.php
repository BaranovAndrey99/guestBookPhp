<?php 
 
	class Controller_Main extends Controller {

		function __construct() {
			$this->model = new Model_Main();
			$this->view = new View();
		}

		function action_index() {
			$data['user'] = $this->model->get_user();
			$data['status_btns'] = $this->model->get_status_btns();
			//$data['sended_post'] = $this->model->post_sender();
			$this->view->generate('../views/main_view.php', '../views/template_view.php', $data);
		}
	}
?>