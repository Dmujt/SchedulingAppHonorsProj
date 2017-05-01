<?php
/**
 * Created by PhpStorm.
 * User: alaina
 * Date: 4/7/17
 * Time: 12:26 PM
 */
require '../lib/site.inc.php';
$controller = new Calendar\LoginController($site, $_SESSION, $_POST);
$user=null;
header("location: ". $site->getRoot());