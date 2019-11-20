<?php
require_once "functions/sql.php";
require_once "functions/products.php";

if(isset($_SESSION["hoi"])){
    $amount = $_SESSION["hoi"];
}else{
    $amount = 10;
}
$products = getProducts($amount);

$viewFile = "viewFile/browseproduct.php";

// alles met php

$price = minMaxPrice(getProducts());

if(isset($_POST["amountProducts"])){

}

$categories = getCategories();


require_once ("template.php");


