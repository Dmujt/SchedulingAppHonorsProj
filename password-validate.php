<?php
$open = true;
require 'lib/site.inc.php';
$view = new Calendar\PasswordValidateView($_GET);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Validation Page</title>
    <link href="lib\css\main.css" type="text/css" rel="stylesheet" />
</head>

<body>

    <?php echo $view->header()?>
<div class="main-content">
    <?php echo $view->error_msg()?>
</div>

<div class="password">
    <!-- Create the body HTML here -->

    <?php echo $view->present()?>
    <p></p>


</div>

</body>
</html>