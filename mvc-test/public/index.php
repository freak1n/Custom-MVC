<?php 
// Единствения файл до който web server-а има достъп
// Тук include-ваме framework-а
// Като bootstrap
require_once ('../../mvc-realization/App.php');
$app = \php_mvc\App::get_instance();
\php_mvc\Loader::register_namespace('Test', '/home/phreak/Development/php-mvc/mvc-test/models/');
$app->run();
new \Test\Models\User();