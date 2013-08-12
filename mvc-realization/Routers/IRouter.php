<?php 

namespace php_mvc\Routers;

interface IRouter {
	public function get_URI();
	public function get_post();
}