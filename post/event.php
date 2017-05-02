<?php
require '../lib/site.inc.php';

$controller = new Calendar\EventsController($site, $_POST, $user);
header("location: " . $controller->getRedirect());