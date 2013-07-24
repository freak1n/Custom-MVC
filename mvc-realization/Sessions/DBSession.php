<?php

namespace php_mvc\Sessions;

class DBSession extends \php_mvc\DB\SimpleDB implements \php_mvc\Sessions\ISession {
	
	private $session_name;
	private $table_name;
	private $lifetime;
	private $path;
	private $domain;
	private $secure;
	private $session_id;
	private $session_data = array();	

	public function __construct($db_connection, $name, $table_name = 'session', $lifetime = 3600, $path = null, $domain = null, $secure = false)
	{
		parent::__construct($db_connection);
		$this->table_name = $table_name;
		$this->session_name = $name;
		$this->lifetime = $lifetime;
		$this->path = $path;
		$this->domain = $domain;
		$this->secure = $secure;
		$this->session_id = $_COOKIE[$name];

		if (strlen($this->session_id) < 32)
		{
			$this->start_new_session();
		}
		else if ( ! $this->validate_session())
		{
			$this->start_new_session();
		}
	}
	
	public function __get($name) 
	{
		return $this->session_data[$name];
	}

	public function __set($name, $value)
	{
		$this->session_data[$name] = $value;
	}

	private function start_new_session()
	{
		$this->session_id = md5(uniqid('php_mvc', TRUE));
		$this->prepare('INSERT INTO '.$this->table_name.' (sessid,valid_until) VALUES(?,?)',
				array($this->session_id, (time() + $this->lifetime)))->execute();

		setcookie($this->session_name, $this->session_id, (time() + $this->lifetime), $this->path, $this->domain, $this->secure, true); 
	}

	private function validate_session()
	{
		if ($this->session_id)
		{
			$d = $this->prepare('SELECT * FROM '.$this->table_name.' WHERE sessid=? AND valid_until<=?', 
				array($this->session_id, (time() + $this->lifetime)))->execute()->fetch_all_assoc();
			if (is_array($d) AND count($d) == 1 AND $d[0])
			{
				$this->session_data = unserialize($d[0]['sess_data']);
				return true;
			}
		}
		return false;
	}

	public function get_session_id()
	{

	}

	public function save_session()
	{
		if ($this->session_id)
		{
			$this->prepare('UPDATE '.$this->table_name.' SET sess_data=?,valid_until=? WHERE sessid=?', 
				array(serialize($this->session_data), (time() + $this->lifetime), $this->session_id))->execute();
			setcookie($this->session_name, $this->session_id, (time() + $this->lifetime), $this->path, $this->domain, $this->secure, true);
		}	
	}

	public function destroy_session()
	{

	}

}