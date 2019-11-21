<?php
require_once "functions/sql.php";
require_once "functions/products.php";
$viewFile = "viewFile/browseproduct.php";

if(isset($_SESSION["hoi"])){
    $amount = $_SESSION["hoi"];
}else{
    $amount = 10;
}
$products = getProducts($amount);

$price = minMaxPrice(getProducts());

if(isset($_GET["amountProducts"])){
    $products = getProductByFilter([4]);
}

$categories = getCategories();


require_once ("template.php");