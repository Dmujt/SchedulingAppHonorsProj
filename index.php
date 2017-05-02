<?php
require __DIR__ . '/lib/site.inc.php';
$view = new Calendar\HomeView($site, $user);
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
    <div class="main-content">
        <h1>Homepage</h1>
        <?php echo $view->present() ?>
    </div>

</body>
</html>