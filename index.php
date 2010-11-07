<?php
require 'app.php';
require 'wikimapia.php';

if (isset($_GET['id']))
    $id = $_GET['id'];
else
    $id = null;

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
    <head>
        <title>Wikimapia</title>
            <script type="text/javascript" src="jquery-1.4.3.js"></script>
            <script type="text/javascript" src="wikimapia.js"></script>
            <link rel="stylesheet" type="text/css" href="main.css" />
    </head>
    <body onload="draw(<?=$id?>);">
        <form action="." method="get">
            <input type="text" name ="id" value="<?php print $id; ?>" />
            <input type="submit" />
        </form>
        
        <canvas id="canv" width="300" height="300"></canvas>
        <br />
<?php
    if ($id) {
        print array2html((get_object($id)));
    }
?>
    </body>
</html>
