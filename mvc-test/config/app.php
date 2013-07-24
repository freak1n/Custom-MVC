<?php

$cnf['default_controller'] = 'Index';
$cnf['default_method'] = 'Index';
$cnf['namespaces']['Controllers'] = realpath('../controllers');

$cnf['session']['autostart'] = true;
$cnf['session']['type'] = 'database';
$cnf['session']['name'] = '__sess';
$cnf['session']['lifetime'] = 3600;
$cnf['session']['path'] = '/';
$cnf['session']['domain'] = '';
$cnf['session']['secure'] = false;
$cnf['session']['db_connection'] = 'default';
$cnf['session']['db_table'] = 'sessions';

return $cnf;