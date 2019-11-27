<?php
$viewFile = "viewFile/aanpassenProduct.php";
require_once "functions/sql.php";


$product = getProductById($_GET["id"]);






require_once "template.php";