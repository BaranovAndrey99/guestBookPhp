<?php 
 
	class Controller_Personal extends Controller {

		function __construct() {
			$this->model = new Model_Personal();
			$this->view = new View();
		}

		function action_index() {
			$data['user'] = $this->model->get_user();
			$data['status_btns'] = $this->model->get_status_btns();
			//$data['sended_post'] = $this->model->post_sender();
			$this->view->generate('../views/personal_view.php', '../views/template_view.php', $data);
		}
	}
?>