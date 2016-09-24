<?php
require __DIR__ . '/lib/steampunked.inc.php';
$view = new Steampunked\SteampunkedView($steampunked);
//echo $view->getJSON();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Steampunked</title>
    <link href="game.css" type="text/css" rel="stylesheet" />
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="site.con.js"></script>
    <script>
        $(document).ready(function() {
            new Game("form");
        });
    </script>
</head>
<body>
<div id="logo" align="center">
    <?php echo $view->header(); ?>
</div>
    <form>
<!--        <form action="game-post.php" method="post">-->
        <div align="center">
            <?php echo $view->grid(); ?>
        </div>
        <div align="center">
            <?php echo $view->turnMessage(); ?>
        </div>
        <div align="center">
            <?php echo $view->getError(); ?>
        </div>
        <div id="pipeOptions" align="center">
            <?php echo $view->pipeOptions(); ?>
        </div>
        <div id ="buttonOptions" align="center">
            <?php echo $view->buttonOptions(); ?>
        </div>
        <div id='win'>

        </div>
    </form>
</body>
</html>
