<?php

// Connection URL for PDO
// Connection 1
$cnf['default']['connection_uri'] = 'mysql:host=localhost;dbname=test1';
$cnf['default']['username'] = 'yavcho_despark';
$cnf['default']['password'] = 'quadro0';
// In the connection momment
$cnf['default']['pdo_options'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES 'UTF8'";
// Throw exceptions for errors
$cnf['default']['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

// Connection 2
$cnf['session']['connection_uri'] = 'mysql:host=localhost;dbname=session';
$cnf['session']['username'] = 'yavcho_despark';
$cnf['session']['password'] = 'quadro0';
$cnf['session']['pdo_options'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES 'UTF8'";
// Throw exceptions for errors
$cnf['session']['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

return $cnf;