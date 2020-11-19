<?php
require_once "src/Proc.php";
$conn = new Mysql("CoursMSG");
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Site</title>
    </head>
    <body>
        <h1>voici les databases:</h1>
        <?=$conn->ShowDB()?>
        <h1>voici les tables:</h1>
        <?=$conn->ShowTables()?>
        <br>
        <a href="?Form">Click Here to from</a>
    </body>
</html>