<?php
namespace php_mvc;
require_once ('Loader.php');
class App {
	private static $instance = null;
	private $config = null;
	private $front_controller = null;
	private $router = null;

	private function __construct()
	{
		\php_mvc\Loader::register_namespace('php_mvc', dirname(__FILE__).DIRECTORY_SEPARATOR);
		\php_mvc\Loader::register_autoload();
		$this->config = \php_mvc\Config::get_instance();
	}

	public function get_config_folder()
	{
		return $this->config->get_config_folder();
	}

	public function set_config_folder($path)
	{
		$this->config->set_config_folder($path);
	}

	public function get_router()
	{
		return $this->router;
	}

	public function set_router($router)
	{
		$this->router = $router;
	}

	/**
	 * 
	 * @return php_mvc\Config
	 */
	public function get_config()
	{
		return $this->config;
	}

	public function run()
	{
		// If config file is not set, use default one
		if ($this->config->get_config_folder() === null)
		{
			$this->set_config_folder('../config');
		}

		$this->front_controller = \php_mvc\FrontController::get_instance();
		
		// Set up the router
		if ($this->router instanceof \php_mvc\Routers\IRouter)
		{
			$this->front_controller->set_router($this->router);
		}
		elseif ($this->router === 'JsonRPCRouter')
		{
			// TODO fix it when RPC is done
			$this->front_controller->set_router(new \php_mvc\Routers\DefaultRouter());
		}
		elseif ($this->router === 'CLIRouter')
		{
			$this->front_controller->set_router(new \php_mvc\Routers\DefaultRouter());	
		}
		else
		{
			$this->front_controller->set_router(new \php_mvc\Routers\DefaultRouter());	
		}
		$this->front_controller->dispatch();
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