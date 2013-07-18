<?php

namespace php_mvc;

// Никога не трябва да има инстанция
// Никога не трябва да бъде наследяван
final class Loader {
	private static $namespaces = array();

	private function __construct () 
	{

	}

	public static function register_autoload()
	{
		/*
			Позволява да регистрираме наша система за зареждане на autoloading-а
			Когато php не може да намери съответния клас той си има негов autoloader
			Когато не може да намери се обръща към този механизъм
			Първия аргумент е обекта към който се обръща
			autoload е името на метода 
		 */
		spl_autoload_register(array("\php_mvc\Loader", 'autoload'));
	}

	public static function autoload($class)
	{
		self::load_class($class);
	}

	public static function load_class($class)
	{
		foreach (self::$namespaces as $key => $value) 
		{
			if (strpos($class, $key) === 0)
			{
				
				$f = str_replace('\\', DIRECTORY_SEPARATOR, $class);
				$f = substr_replace($f, $value, 0, strlen($key)).'.php';
				$f = realpath($f);
				
				if ($f AND is_readable($f))
				{
					require_once $f;
				}
				else 
				{
					// TODO
					throw new \Exception('File cannot be included'.$f);
				}
				break;
			}
		}
	}

	/**
	 * [register_namespace description]
	 * @param  [type] $namespace Name of namespace
	 * @param  [type] $path      Real path
	 * @return 
	 */
	public static function register_namespace($namespace, $path)
	{
		$namespace = trim($namespace);
		if (strlen($namespace) > 0) 
		{
			if ( ! $path)
			{
				throw new \Exception('Invalid path');
			}
			// Връща истинския път. Ако $path е null, ще върне директорията където е изпълнен
			$_path = realpath($path);
			if ($_path AND is_dir($_path) AND is_readable($_path))
			{
				self::$namespaces[$namespace.'\\'] = $_path.DIRECTORY_SEPARATOR;
			}
			else
			{
				// TODO
				throw new \Exception('Namespace directory read error'.$path);
			}

		}
		else
		{
			// TODO
			throw new \Exception('Invalid namespace' . $namespace);
		}
	}

	public static function register_namespaces($ns)
	{
		if (is_array($ns))
		{
			foreach ($ns as $key => $value) {
				self::register_namespace($key, $value);
			}
		}
		else
		{
			throw new \Exception('Invalid namespaces');
		}
	}

	public static function get_namespaces()
	{
		return self::$namespaces;
	}

	public static function remove_namespace($namespace)
	{
		unset(self::$namespaces[$namespace]);
	}

	public static function clear_namespaces()
	{
		self::$namespaces = array();
	}
}