<?php 

namespace Controllers;

class Index {
	public function index() 
	{
		$view = \php_mvc\View::get_instance();
		
		$view->username = 'yavcho';
		$view->append_to_layout('body', 'admin.index');
		$view->append_to_layout('body2', 'admin.index');
		$view->display('layouts.default', array('c' => array(1,2,3,4,5)), false);
	}
}