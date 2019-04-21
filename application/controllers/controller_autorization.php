<?php

	class Controller_Autorization extends Controller {

		function __construct()
		{
			$this->model = new Model_Autorization();
			$this->view = new View();
		}
		
		function action_index()
		{	
			$data = $this->model->autorization_handler();
			$this->view->generate('autorization_view.php', 'template_view.php', $data);
		}
	}
?>	