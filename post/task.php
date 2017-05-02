<?php
require '../lib/site.inc.php';

$controller = new Calendar\TasksController($site, $_POST, $user);
header("location: " . $controller->getRedirect());