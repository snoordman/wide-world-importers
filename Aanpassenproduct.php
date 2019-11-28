<?php
    require_once "config.php";
    require_once "functions/sql.php";
    $viewFile = "viewFile/aanpassenProduct.php";

    $product = getProductById($_GET["id"]);

    require_once "template.php";