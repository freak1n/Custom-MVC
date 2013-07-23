<?php

namespace php_mvc\DB;

class SimpleDB {
	protected $connection = 'default';
	private $db = null;
	
	private $stmt = null;
	private $params = array();
	private $log_sql = false;
	private $sql;

 	public function __construct($connection = null)
	{
		if ($connection instanceof \PDO)
		{
			$this->db = $connection;
		}
		elseif ($connection != null)
		{
			$this->db = \php_mvc\App::get_instance()->get_db_connection($connection);
			$this->connection = $connection;
		}
		else
		{
			// Default case
			$this->db = \php_mvc\App::get_instance()->get_db_connection($this->connection);
		}
	} 

	public function prepare($sql, $params = array(), $pdo_options = array())
	{
		$this->stmt = $this->db->prepare($sql, $pdo_options);
		$this->params = $params;
		$this->sql = $sql;
		return $this;
	}

	public function execute($params = array())
	{
		if ($params)
		{
			$this->params = $params;
		}
		if ($this->log_sql)
		{
			\php_mvc\Logger::get_instance()->set($this->sql.' '.print_r($this->params, true), 'db');
		}
		$this->stmt->execute($this->params);
		return $this;
	}

	public function fetch_all_assoc()
	{
		return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
 	}

 	public function fetch_row_assoc()
 	{
 		return $this->stmt->fetch(\PDO::FETCH_ASSOC);
 	}

 	public function get_last_insert_id()
 	{
 		return $this->db->last_insert_id();
 	}

 	public function get_affected_rows()
 	{
 		return $this->stmt->rowCount();
 	}

 	public function get_stmt()
 	{
 		return $this->stmt;
 	}
}

