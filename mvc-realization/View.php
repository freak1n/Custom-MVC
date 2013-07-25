<?php

namespace php_mvc;

class View {
	private static $instance = null;
	private $view_path = null;
	private $data = array();
	
	private function __construct()
	{
		$this->view_path = \php_mvc\App::get_instance()->get_config()->app['views_directory'];
		if ($this->view_path == null) 
		{
			$this->view_path = realpath('../views/');
		}
	}

	public function set_view_directory($path)
	{
		$path = trim($path);
		if ($path)
		{
			$path = realpath($path).DIRECTORY_SEPARATOR;
			if (is_dir($path) AND is_readable($path)) 
			{
				$this->view_dir = $path;
			}
			else
			{
				throw new \Exception('view path', 500);
			}
		}
		else
		{
			throw new \Exception('view path', 500);
		}
	}		

	public static function get_instance()
	{
		if (self::$instance == null) 
		{
			self::$instance = new \php_mvc\View();
		}
		return self::$instance;
	}

	public function __set($name, $value)
	{
		$this->data[$name] = $value;
	}

	public function __get($name)
	{
		return $this->data[$name];
	}
}