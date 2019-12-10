<?php
    require_once "config.php";
    require_once 'functions/products.php';

    $viewFile = "viewFile/home.php";

    var_dump($_SESSION["shoppingCard"]);

    require_once "template.php";
?>