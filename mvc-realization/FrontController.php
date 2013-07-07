<?php 
namespace php_mvc;

class FrontController {
	private static $instance = null;

	public function __construct()
	{

	}

	/*
		Когато бъде извикан, FrontController-а трябва да намери кой router трябва да бъде използван
	 */
	public function dispatch()
	{
		$a = new \php_mvc\Routers\DefaultRouter();
		$a->parse();
	}

	public static function get_instance()
	{
		if (self::$instance === null)
		{
			self::$instance = new \php_mvc\FrontController();
		}

		return self::$instance;
	}
}