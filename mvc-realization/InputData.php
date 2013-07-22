<?php 

namespace php_mvc;

class InputData {
	private static $instance = null;
	private $get = array();
	private $post = array();
	private $cookies = array();

	private function __construct()
	{
		$this->cookies = $_COOKIE;
	}

	public function set_post($arr)
	{
		if (is_array($arr))
		{
			$this->post = $arr;	
		}
	}

	public function set_get($arr)
	{
		if (is_array($arr))
		{
			$this->get = $arr;
		}
	}

	// $id 'cause we dont have keys in array
	public function has_get($id)
	{
		return array_key_exists($id, $this->get);
	}

	public function has_post($name)
	{
		return array_key_exists($name, $this->post);
	}

	public function has_cookies($name)
	{
		return array_key_exists($name, $this->cookies);
	}

	// Get information from GET
	public function get($id, $normalize = null, $default = null)
	{
		if ($this->has_get($id))
		{
			if ($normalize !== null)
			{
				return \php_mvc\Common::normalize($this->get[$id], $normalize);
			}
			return $this->get[$id];
		}
		return $default;
	}

	// Get information from POST
	public function post($name, $normalize = null, $default = null)
	{
		if ($this->has_post($name))
		{
			if ($normalize !== null)
			{
				return \php_mvc\Common::normalize($this->post[$name], $normalize);
			}
			return $this->post[$name];
		}
		return $default;
	}

	// Get information from COOKIES
	public function cookies($name, $normalize = null, $default = null)
	{
		if ($this->has_cookies($name))
		{
			if ($normalize !== null)
			{
				return \php_mvc\Common::normalize($this->cookies[$name], $normalize);
			}
			return $this->cookies[$name];
		}
		return $default;
	}

	public static function get_instance()
	{
		if (self::$instance == null)
		{
			self::$instance = new \php_mvc\InputData();
		}
		return self::$instance;
	}
}