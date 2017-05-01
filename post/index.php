<?php
/**
 * Created by PhpStorm.
 * User: alaina
 * Date: 4/6/17
 * Time: 4:37 PM
 */
$open = true;		// Can be accessed when not logged in
require '../lib/site.inc.php';

/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/

$controller = new Calendar\HomeController($site, $_POST, $user);
header("location: " . $controller->getRedirect());