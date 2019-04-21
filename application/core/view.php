<?php  
	/**
	 * public $template_view;
	 */
	class View {
		/**
		 * Можно задать дефолтный шаблон страницы.
		 * 		public $template_view;
		 * 		
		 * [generate description]
		 * @param  [type] $content_view  [description] - виды контента.
		 * @param  [type] $template_view [description] - виды шаблонов.
		 * @param  [type] $data          [description] - массив элементов страницы.
		 * @return [type]                [description]
		 */
		function generate($content_view, $template_view, $data = null) {
			/**
			 * Подключаем нужный шаблон. Внутри него встраивается контент.
			 * В шаблон мы поместим: header, status_bar, send_bar, post_listing, page_list, footer.
			 */
			include 'application/views/'.$template_view;
		}
	}
?>