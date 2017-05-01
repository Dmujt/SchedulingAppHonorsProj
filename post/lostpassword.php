<?php
/**
 * Created by PhpStorm.
 * User: alaina
 * Date: 4/7/17
 * Time: 12:49 PM
 */
$open = true;
require '../lib/site.inc.php';

$controller = new Calendar\LostPasswordController($site, $_POST);
header("location: " . $controller->getRedirect());

/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
*/