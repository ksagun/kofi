<?php
require("src/app.php");
$app = new App();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="/assets/css/style.css">

    <?php if (Routes::$selected_route['module'] && Routes::$selected_route['module']->style): ?>
        <link rel="stylesheet" href="<?php echo "/src/modules/" . Routes::$selected_route['module']->style; ?>">
    <?php endif; ?>

    <!-- Remove this -->
    <link rel="stylesheet" href="/assets/css/prism.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <title>
        <?php echo $app->page_title; ?>
    </title>
</head>

<body>
    <div class="app">
        <?php
        //Use for standalone modules to isolate module from global function declarations here.
        $standalone = false;
        if (is_array(Routes::$selected_route) & array_key_exists("standalone", Routes::$selected_route)) {
            $standalone = Routes::$selected_route['standalone'];
        }
        ?>
        <?php
        $app->init();
        ?>
    </div>
</body>

<?php if (Routes::$selected_route['module'] && Routes::$selected_route['module']->js): ?>
    <script src='<?php echo "/src/modules/" . Routes::$selected_route['module']->js; ?>'></script>
<?php endif; ?>

<!-- Remove this -->
<script src="/assets/js/prism/prism.js"></script>

</html>