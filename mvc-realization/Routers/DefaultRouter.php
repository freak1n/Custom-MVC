<?php
namespace php_mvc\Routers;

class DefaultRouter {
	private $controller = null;
	private $method = null;
	private $params = array(); 
	public function parse()
	{
		// маха index.php
		$_uri = substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME'])+1);
		$_params = explode('/', $_uri);
		
		if($_params[0]) 
		{
			$this->controller = ucfirst($_params[0]);

			// If we do not have controller and method, we do not have params
			
			if($_params[1])
			{
				$this->method = $_params[1];
				// За да останат get параметрите
				unset($_params[0], $_params[1]);
				$this->params = array_values($_params);
			}
		}
	}


	public function get_controller()
	{
		return $this->controller;			
	}

	public function get_method()
	{
		return $this->method;
	}

	public function get_get_params()
	{
		return $this->params;
	}

}