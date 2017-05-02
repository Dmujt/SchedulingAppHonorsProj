<?php

$open = true;
require './lib/site.inc.php';
$view = new Calendar\View();
$view->setTitle("Lost Password");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head(); ?>
</head>

<body>
<?php
echo $view->header();

?>
<div class="password">

    <!-- Create the body HTML here -->

    <form method="post" action="./post/lostpassword.php"  class="initial-gameform">
        <fieldset>
            <legend>
                Lost Password
            </legend>
            <span class="error"><br>Please enter your email below and a link will be sent to reset your password!</span>

            <p>
                <input type="email" id="email" name="email" placeholder="Email">
            </p>
            <p>
                <input type="submit" id="submit" value="Submit" name="submit">
            </p>
        </fieldset>

    </form>


</div>

</body>
</html>
