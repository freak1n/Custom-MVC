<?php
namespace php_mvc\Routers;

class DefaultRouter implements \php_mvc\Routers\IRouter {
	
	public function get_URI()
	{
		
		return substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME'])+1);
		/* // Variant 1		
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
		} */
	}
}