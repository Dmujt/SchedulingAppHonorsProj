<?php
$open = true;
require '../lib/site.inc.php';

$controller = new Calendar\CreateUserController($site, $_POST);
header("location: " . $controller->getRedirect());

/*
echo "<pre>";
print_r($controller->getRedirect());
print_r($_POST);
echo "</pre>";
*/
