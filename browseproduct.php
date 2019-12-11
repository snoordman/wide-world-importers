<?php
    require_once "config.php";
    require_once "functions/sql.php";
    require_once "functions/products.php";
    require_once "functions/image.php";
    $viewFile = "viewFile/browseproduct.php";


    $products = getProducts();

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
            //$products[$i]["Image"] = getPhotosProduct($product["StockItemId"], true)[0]["Photo"];
            $photo = getPhotosProduct($products[$i]["StockItemId"], true);
            if($photo !== "Geen resultaten"){
                $products[$i]["photo"] = $photo[0]["Photo"];
            }else{
                $products[$i]["photo"] = null;
            }
        }
    }

    require_once ("template.php");
