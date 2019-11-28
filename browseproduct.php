<?php
require_once "functions/sql.php";
require_once "functions/products.php";
$viewFile = "viewFile/browseproduct.php";


$products = getProducts();

$price = minMaxPrice(getProducts());



if(isset($_GET["submitFilter"])){
    $products = getProductByFilter([getProductById(1, 2, 3, 4, 5, 6, 7, 8, 9, 10)]);
}else if(isset($_GET["search"])){
    $search = $_GET["searchValue"];
    if($search !== ""){
        $products = getProductBySearch($search);
    }
}

$categories = getCategories();

require_once ("template.php");