<?php 

// Единствения файл до който web server-а има достъп
// Тук include-ваме framework-а
// Като bootstrap

require_once ('../../mvc-realization/App.php');

$app = \php_mvc\App::get_instance();


$app->run();
$app->get_session()->counter2+=1;
echo $app->get_session()->counter2;