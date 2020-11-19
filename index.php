<?php
if (!count($_GET)){
    $PATH = "res/pages/index.php";
    include_once $PATH;
}
if (isset($_GET['Form'])){
    $PATH = "res/pages/From.php";
    include_once $PATH;
}
