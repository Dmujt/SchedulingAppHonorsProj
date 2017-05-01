<?php
/**
 * Created by PhpStorm.
 * User: mccli
 * Date: 4/2/2017
 * Time: 6:13 PM
 */
$open = true;
require '../lib/site.inc.php';

$controller = new Calendar\PasswordValidateController($site, $_POST);
//var_dump($_POST);
header("location: " . $controller->getRedirect());

/*
echo "<pre>";
print_r($_POST);
print_r($controller->getRedirect());
echo "</pre>";
*/