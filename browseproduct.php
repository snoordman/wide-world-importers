<?php
    require_once "config.php";
    require_once "functions/sql.php";
    require_once "functions/products.php";

    $viewFile = "viewFile/browseproduct.php";


    $products = getProducts();

    $price = minMaxPrice(getProducts());

    if(isset($_GET["submitFilter"])){
        $categories = null;
        $priceFilter = null;

        if(isset($_GET["categories"]) && $_GET["categories"] !== []) {
            $categories = $_GET["categories"];
        }
        if(isset($_GET["price"]) && $_GET["price"] !== ""){
            $priceFilter = $_GET["price"];
        }

        $products = getProductByFilter($categories, $priceFilter);

    }else if(isset($_GET["search"])){
        $search = $_GET["searchValue"];
        if($search !== ""){
            $products = getProductBySearch($search);
        }
    }

    $categories = getCategories();


    require_once ("template.php");
