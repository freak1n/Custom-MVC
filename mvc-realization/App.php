<?php
namespace php_mvc;
require_once ('Loader.php');
class App {
	private static $instance = null;
	private $config = null;
	private $front_controller = null;
	private $router = null;
	private $db_connections = array();
	private $session = null;

	private function __construct()
	{
		set_exception_handler(array($this, 'exception_handler'));

		\php_mvc\Loader::register_namespace('php_mvc', dirname(__FILE__).DIRECTORY_SEPARATOR);
		\php_mvc\Loader::register_autoload();
		$this->config = \php_mvc\Config::get_instance();
		// Using default one config folder
		if ($this->config->get_config_folder() == null)
		{
			$this->set_config_folder('../config');
		}
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

		$_sess = $this->config->app['session'];
		if ($_sess['autostart'])
		{
			if ($_sess['type'] === 'native')
			{ 
				$sess_obj = new \php_mvc\Sessions\NativeSession($_sess['name'], $_sess['lifetime'], $_sess['path'], $_sess['domain'], $_sess['secure']);
			}
			elseif ($_sess['type'] === 'database')
			{
				$sess_obj = new \php_mvc\Sessions\DBSession($_sess['db_connection'], $_sess['name'], $_sess['db_table'], $_sess['lifetime'], $_sess['path'], $_sess['domain'], $_sess['secure']);
			}
			else 
			{
				throw new \Exception('No valid session', 500);
			}
			$this->set_session($sess_obj);
		}

		$this->front_controller->dispatch();
	}

	public function set_session(\php_mvc\Sessions\ISession $session)
	{
		$this->session = $session;
	}

	public function get_session()
	{
		return $this->session;
	}

	public function get_db_connection($connection = 'default')
	{
		if ( ! isset($connection))
		{
			throw new \Exception('No connection identifier provider', 500);
		}
		
		if (isset($this->db_connections[$connection]))
		{
			return $this->db_connections[$connection];
		}
		
		$_cnf = $this->get_config()->database;
		
		if ( ! isset($_cnf[$connection]))
		{
			throw new \Exception('No valid connection identificator is provided', 500);
		}
		
		$dbh = new \PDO($_cnf[$connection]['connection_uri'], $_cnf[$connection]['username'], 
						$_cnf[$connection]['password'], $_cnf[$connection]['pdo_options']);
		$this->db_connections[$connection] = $dbh;
		return $dbh;
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

	public function __destruct()
	{
		if ($this->session != null) 
		{
			$this->session->save_session();
		}		
	}

	public function exception_handler(\Exception $ex)
	{
		if ($this->config AND $this->config->app['display_exception'] == true) 
		{
			echo '<pre>'.printf($ex, true).'</pre>';
		}
		else
		{
			$this->display_error($ex->get_code());
		}
	}

	public function display_error($errors)
	{
		try 
		{
			$view = \php_mvc\View::get_instance();
			$view->display('errors'.$error);	
		} 
		catch (Exception $e) 
		{
			\php_mvc\Common::header_status($error);
			echo '<h1>'.$error.'</h1>';
			exit;
		}
	}
}