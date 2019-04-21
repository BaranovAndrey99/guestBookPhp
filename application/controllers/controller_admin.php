<?php

	class Controller_Admin extends Controller {

		function __construct()
		{
			$this->model = new Model_Admin();
			$this->view = new View();
		}
		
		function action_index()
		{		
			$data['user'] = $this->model->check_user();
			
			if($data['user'] == null) {
				echo "<meta http-equiv='refresh' content='0; url=/autorization'>";
			} else {
				$this->view->generate('admin_view.php', 'template_view.php', $data);
			}	
		}
	}
?>	