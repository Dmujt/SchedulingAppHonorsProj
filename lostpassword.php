<?php
/**
 * Created by PhpStorm.
 * User: alaina
 * Date: 4/7/17
 * Time: 12:46 PM
 */
$open = true;
require './lib/site.inc.php';
$view = new Calendar\View();
$view->setTitle("Lost Password");
$view->addLink("./", "Homepage");

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
    <p><br>Please enter your email below and a link will be sent to reset your password!</p>

    <form method="post" action="./post/lostpassword.php"  class="initial-gameform">
        <fieldset>
            <legend>
                Lost Password
            </legend>
            <p>
                <label for="email">Email</label>
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
