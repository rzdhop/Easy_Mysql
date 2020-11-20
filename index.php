<?php
if (!count($_GET)){
    $PATH = "res/pages/index.php";
    include_once $PATH;
}
if (isset($_GET['DB'])and !isset($_GET['Table'])){
    $PATH = "res/pages/ShowTables.php";
    include_once $PATH;
}
if (isset($_GET['DB']) and isset($_GET['Table'])){
    $PATH = "res/pages/Describe.php";
    include_once $PATH;
}
if (isset($_GET['Form'])){
    $PATH = "res/pages/From.php";
    include_once $PATH;
}
