<?php 
namespace php_mvc;

class FrontController {
	private static $instance = null;
	private $name_space = null;
	private $controller = null;
	private $method = null;
	private $router = null;

	public function __construct()
	{

	}

	public function get_router()
	{
		return $this->router;
	}

	public function set_router(\php_mvc\Routers\IRouter $router)
	{
		$this->router = $router;
	}
	/*
		Когато бъде извикан, FrontController-а трябва да намери кой router трябва да бъде използван
	 */
	public function dispatch()
	{
		if ($this->router == null)
		{
			throw new \Exception('No valid router found', 500);
		}

		$_uri = $this->router->get_uri(); 
		$routes = \php_mvc\App::get_instance()->get_config()->routes;
		
		// Entire array of current package - *, administration or whatever
		$_rcache = null;

		// Set the namespace by route
		if (is_array($routes) AND count($routes)>0)
		{
			foreach ($routes as $key => $value) 
			{
				if (stripos($_uri, $key) === 0 && ($_uri==$key || stripos($_uri, $key.'/') === 0) && isset($value['namespace']))
				{
					$this->name_space = $value['namespace'];
					$_uri = substr($_uri, strlen($key)+1);
					$_rcache = $value;
					break;
				} 
			}
		}
		else
		{
			throw new \Exception('Default route is missing', 500);
		}

		// Using the default pakcage
		if ($this->name_space == null AND isset($routes['*']['namespace']))
		{
			$this->name_space = $routes['*']['namespace'];
			$_rcache = $routes['*'];
		}
		elseif ($this->name_space == null AND ! isset($routes['*']['namespace']))
		{
			throw new \Exception("Default route missing");
		}
		
		$input = \php_mvc\InputData::get_instance();
		// Exploding URI for division controller and method
		$_params = explode('/', $_uri);
		
		if($_params[0]) 
		{
			$this->controller = strtolower($_params[0]);
			
			// If we do not have controller and method, we do not have params
			if(isset($_params[1]))
			{
				$this->method = strtolower($_params[1]);
				unset($_params[0], $_params[1]);
				$input->set_get(array_values($_params));
				
				// За да останат get параметрите
				$this->params = array_values($_params);
			}
			else 
			{
				$this->method = $this->get_default_method();
			}
		}
		else 
		{
			$this->controller = $this->get_default_controller();
			$this->method = $this->get_default_method();
		}

		if (is_array($_rcache) AND isset($_rcache['controllers']))
		{
			if(isset($_rcache['controllers'][$this->controller]['methods'][$this->method]))
			{
				$this->method = strtolower($_rcache['controllers'][$this->controller]['methods'][$this->method]);
			}
			if (isset($_rcache['controllers'][$this->controller]['to']))
			{
				$this->controller = strtolower($_rcache['controllers'][$this->controller]['to']); 
			}
		}

		$input->set_post($this->router->get_post());
		// TODO fix it
		$f = $this->name_space.'\\'.ucfirst($this->controller);
		$new_controller = new $f();
		$new_controller->{$this->method}();
	}	

	public function get_default_controller()
	{
		$controller = \php_mvc\App::get_instance()->get_config()->app['default_controller'];
		if ($controller)
			return strtolower($controller);
		return 'index';
	}

	public function get_default_method()
	{
		$method = \php_mvc\App::get_instance()->get_config()->app['default_method'];
		if($method)
			return strtolower($method);
		return 'index';
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