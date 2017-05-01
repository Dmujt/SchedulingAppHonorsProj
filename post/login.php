<?php
$open = true;		// Can be accessed when not logged in
require '../lib/site.inc.php';

/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/

$controller = new Calendar\LoginController($site, $_SESSION, $_POST);
header("location: " . $controller->getRedirect());