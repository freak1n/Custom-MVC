<?php

namespace php_mvc\Sessions;
interface ISession {
	
	public function get_session_id();
	public function save_session();
	public function destroy_session();
	public function __get($name);
	public function __set($name, $value);
}