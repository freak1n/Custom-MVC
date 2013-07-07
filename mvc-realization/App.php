<?php
namespace php_mvc;
require_once ('Loader.php');
class App {
	private static $instance = null;
	

	private function __construct()
	{
		\php_mvc\Loader::register_namespace('php_mvc', dirname(__FILE__).DIRECTORY_SEPARATOR);
		\php_mvc\Loader::register_autoload();
	}

	public function run()
	{

	}

	/**
	 * 
	 * @return \php-mvc\App();
	 */
	public static function get_instance()
	{
		if (self::$instance === null)
		{
			self::$instance = new \php_mvc\App();
		}	

		return self::$instance;
	}
}