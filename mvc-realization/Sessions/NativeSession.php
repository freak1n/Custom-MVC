<?php

namespace php_mvc\Sessions;

class NativeSession implements \php_mvc\Sessions\ISession {

	public function __construct($name, $lifetime = 3600, $path = null, $domain = null, $secure = false)
	{
		if (strlen($name) < 1)
		{
			$name = '_sess';
		}
		session_name($name);
		session_set_cookie_params($lifetime, $path, $domain, $secure, true);
		session_start();
	}

	public function get_session_id()
	{
		return session_id();
	}

	public function save_session()
	{
		session_write_close();
	}
	
	public function destroy_session()
	{
		session_destroy();
	}
	
	public function __get($name)
	{
		return $_SESSION[$name];
	}
	
	public function __set($name, $value)
	{
		$_SESSION[$name] = $value;
	}
}