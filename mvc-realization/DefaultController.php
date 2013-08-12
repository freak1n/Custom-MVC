<?php

namespace php_mvc;

class DefaultController {
	public $app;
	public $view;
	public $config;
	public $input;

	public function __construct()
	{
		$this->app = \php_mvc\App::get_instance();
		$this->view = \php_mvc\View::get_instance();
		$this->config = $this->app->get_config();
		$this->input = \php_mvc\InputData::get_instance();
	}

	public function json_response()
	{
		
	}
} 