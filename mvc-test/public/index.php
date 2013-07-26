<?php 

error_reporting(E_ALL ^ E_NOTICE);
// Единствения файл до който web server-а има достъп
// Тук include-ваме framework-а
// Като bootstrap

require_once ('../../mvc-realization/App.php');

$app = \php_mvc\App::get_instance();

$app->run();