<?php
$open = true;
require 'lib/site.inc.php';
$view = new Calendar\PasswordValidateView($_GET);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head()?>

</head>

<body>

    <?php echo $view->header()?>

<div class="password">
    <!-- Create the body HTML here -->

    <?php echo $view->present()?>
    <p></p>


</div>

</body>
</html>