<?php 
// Единствения файл до който web server-а има достъп
// Тук include-ваме framework-а
// Като bootstrap
require_once ('../../mvc-realization/App.php');

$app = \php_mvc\App::get_instance();

$db = new \php_mvc\DB\SimpleDB();
$a = $db->prepare('SELECT * FROM users  WHERE id=?', array(1))->execute()->fetch_all_assoc();
echo "<pre>";
var_dump($a);
echo "</pre>";
$app->run();




