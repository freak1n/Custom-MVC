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

	public function get($id, $normalize = null, $default = null)
	{
		if ($this->has_get($id))
		{
			if ($normalize !== null)
			{
				
			}
			return $this->get[$id];
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