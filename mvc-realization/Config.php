<?php

namespace php_mvc;
// Read only class for config files
class Config {
	public static $instance = null;
	// Path to config folder
	private $config_folder = null;
	private $config_array = array();

	private function __construct()
	{

	}

	public function get_config_folder()
	{
		return $this->config_folder;
	}

	public function set_config_folder($config_folder)
	{
		// Проверява дали нещо е подадено
		if ( ! $config_folder)
		{
			throw new \Exception('Empty config folder path: ');
		}

		$_config_folder = realpath($config_folder);
		
		if ($_config_folder != FALSE AND is_dir($_config_folder) AND is_readable($_config_folder))
		{
			// Clear old config data
			$this->config_array = array();
			$this->config_folder = $_config_folder.DIRECTORY_SEPARATOR;
			/*$ns = $this->app['namespace'];
			if(is_array($ns))
			{
				\php_mvc\Loader::register_namespaces($ns);
			}*/
		}
		else 
		{
			throw new \Exception("Config directory read error:".$config_folder);
		}
	}

	
	public function include_config_file($path)
	{
		if( ! $path)
		{
			// TODO
			throw new \Exception();			
		}

		$_file = realpath($path);
		if ($_file != FALSE AND is_file($_file) AND is_readable($_file))
		{
			// basename() - връща името на файла
			// Маха .php - explode - масив 
			$_basename = explode('.php', basename($_file))[0];
			$this->config_array[$_basename] = include $_file;
		}
		else 
		{
			// TODO
			throw new Exception("Config file read error".$path);
		}
	}

	public function __get($name)
	{
		if ( ! isset($this->config_array[$name]))
		{
			$this->include_config_file($this->config_folder.$name.'.php');
		}

		if (array_key_exists($name, $this->config_array))
		{
			return $this->config_array[$name];
		}

		return null;
	}

	public static function get_instance()
	{
		if(self::$instance === null)
		{
			self::$instance = new \php_mvc\Config();
		}

		return self::$instance;
	}

}