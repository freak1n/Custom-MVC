<?php 

namespace Controllers;

class Index extends \php_mvc\DefaultController {
	public function index() 
	{
		$this->app->display_error(404);
		$val = new \php_mvc\Validation();
		$val->set_rule('url', 'http://az.com')->set_rule('min_length', 'httpss', 5);
		var_dump($val->validate());
		print_r($val->get_errors());
		$view = \php_mvc\View::get_instance();
		
		$view->username = 'yavcho';
		$view->append_to_layout('body', 'admin.index');
		$view->append_to_layout('body2', 'admin.index');
		$view->display('layouts.default', array('c' => array(1,2,3,4,5)), false);
	}
}