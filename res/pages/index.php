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
        <br>
        <?php
        $DBs = $conn->ShowDB(TRUE);
        for($x=0; $x < count($DBs); $x++){
            echo '<a href="?DB='.$DBs[$x].'">'.$DBs[$x]."</a><br>";
        }?>
        <br>
        <a href="?Form">Click Here to from</a>
    </body>
</html>