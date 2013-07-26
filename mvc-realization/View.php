<?php

namespace php_mvc;

class View {
	private static $instance = null;
	private $__extension = '.php';
	private $__view_path = null;
	private $__view_dir = null;
	private $__data = array();
	private $__layout_parts = array();
	private $__layout_data = array();

	private function __construct()
	{
		$this->__view_path = \php_mvc\App::get_instance()->get_config()->app['views_directory'];
		if ($this->__view_path == null) 
		{
			$this->__view_path = realpath('../views/');
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

	public function set_view_directory($path)
	{
		$path = trim($path);
		if ($path)
		{
			$path = realpath($path).DIRECTORY_SEPARATOR;
			if (is_dir($path) AND is_readable($path)) 
			{
				$this->__view_dir = $path;
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

	public function get_layout_data($name)
	{
		return $this->__layout_data[$name];
	}

	public function display($name, $data = array(), $return_as_string = false)
	{
		if (is_array($data)) 
		{
			$this->__data = array_merge($this->__data, $data);
		}

		if (count($this->__layout_parts) > 0)
		{
			foreach ($this->__layout_parts as $key => $value) 
			{
				$r = $this->include_file($value);
				if ($r) 
				{
					$this->__layout_data[$key] = $r;
				}		
			}
		}

		if ($return_as_string) 
		{
			return $this->include_file($name);
		}
		else
		{
			echo $this->include_file($name);
		}
	}

	public function append_to_layout($key, $template)
	{
		if ($key AND $template) 
		{
			$this->__layout_parts[$key] = $template;			
		}	
		else
		{
			throw new \Exception("Layout require valid key and template", 500);
		}
	}

	private function include_file($file)
	{
		if ($this->__view_dir == null) 
		{
			$this->set_view_directory($this->__view_path);
		}

		$___fl = $this->__view_dir.str_replace('.', DIRECTORY_SEPARATOR, $file).$this->__extension;

		if (file_exists($___fl) AND is_readable($___fl))
		{
			ob_start();
			include $___fl;
			return ob_get_clean();
		}
		else
		{
			throw new \Exception("View ".$file.' cannot be included', 500);
		}
	}

	public function __set($name, $value)
	{
		$this->__data[$name] = $value;
	}

	public function __get($name)
	{
		return $this->__data[$name];
	}
}