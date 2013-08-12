<?php

namespace \php_mvc\Routers;

class JsonRPCRouter implements \php_mvc\Routers\IRouter {
	private $map = array();
	private $request_id;
	private $post = array();

	public function __construct()
	{
		if ($_SERVER['REQUEST_METHOD'] != 'POST' OR 
			empty($_SERVER['CONTENT_TYPE']) OR 
			$_SERVER['CONTENT_TYPE'] != 'application/json') 
		{
			throw new Exception("Require json request", 400);
			
		}
	}
	
	public function set_method_map($arr)
	{
		if (is_array($arr)) 
		{
			$this->map = $arr;
		}
	}

	public function get_post()
	{
		return $this->post;
	}

	public function get_URI()
	{
		if ( ! is_array($this->map) OR count($this->map) == 0) 
		{
			$arr  = \php_mvc\App::get_instance()->get_config->rpc_routes;
			if (is_array($arr) AND count($arr) > 0) 
			{
				$this->map = $arr;
			}
			else
			{
				throw new \Exception("Router require method map", 500);
				
			}
		}

		$request = json_decode(file_get_contents('php://input'), true);
		if ( ! is_array($request) OR ! isset($request['method'])) 
		{
			throw new \Exception('Require JSON request', 400);			
		}
		else
		{
			if ($this->map[$request['method']]) 
			{
				$this->request_id = $request['id'];
				$this->post = $request['params'];
				return $this->map[$request['method']];
			}
			else
			{
				throw new \Exception("Method not found", 501);
			}
		}	
	}

	public function get_request_id()
	{
		return $this->request_id;
	}
}	