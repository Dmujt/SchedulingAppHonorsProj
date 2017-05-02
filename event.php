<?php
require __DIR__ . '/lib/site.inc.php';
$view = new Calendar\EventView($site, $user,$_GET);
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
    <?php echo $view->present() ?>
</div>

</body>
</html>