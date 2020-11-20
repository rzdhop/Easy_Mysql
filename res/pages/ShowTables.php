<?php
require_once "src/Proc.php";
$conn = new Mysql(htmlspecialchars($_GET['DB']));
$conn->ShowTables(TRUE);

$table = $conn->ShowTables(TRUE);
for($x=0; $x < count($table); $x++){
    echo '<a href="?DB='.$_GET['DB'].'&Table='.$table[$x].'">'.$table[$x]."</a><br>";
}
?>