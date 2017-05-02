<?php


require '../lib/site.inc.php';
$controller = new Calendar\LoginController($site, $_SESSION, $_POST);
$user=null;
header("location: ". $site->getRoot());