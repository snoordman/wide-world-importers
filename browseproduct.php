<?php
    require_once "config.php";
    require_once "functions/sql.php";
    require_once "functions/products.php";
    require_once "functions/image.php";
    $viewFile = "viewFile/browseproduct.php";

    $records = getAmountProducts();

    $amountPageValues = [10, 25, 50, 100];

    if(isset($_GET["amountProducts"])){
        $amountPerPage = $_GET["amountProducts"];
    }else{
        $amountPerPage = 10;
    }
    if(isset($_GET["page"])){
        $page = $_GET["page"];
    }else{
        $page = 0;
    }

    $pages =  $records / $amountPerPage;

    $page = $page * $amountPerPage;
    $products = getProducts($amountPerPage, $page);

    $price = getMinMaxPrice();

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

    if(!is_string($products)){
        for($i = 0; $i < count($products); $i++){
            $photo = getPhotosProduct($products[$i]["StockItemId"], true);
            if($photo !== "Geen resultaten"){
                $products[$i]["photo"] = $photo[0]["Photo"];
            }else{
                $products[$i]["photo"] = null;
            }
        }
    }


    require_once ("template.php");
