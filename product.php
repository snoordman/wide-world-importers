<?php
    require_once "config.php";
    require_once ("functions/products.php");
    require_once ("functions/image.php");


    $viewFile = "viewFile/product.php";

    if(isset($_GET["product_id"])){
        $productId = $_GET["product_id"];
        $product = getProductById($productId);
        if(is_array($product)){
            $photos = getPhotosProduct($productId);
        }else{
            alert_msg_push("alert-danger", "U heeft een ongeldig product geselecteerd");
            header("location: browseproduct.php");
            exit;
        }

    }else{
        alert_msg_push("alert-danger", "U heeft geen product geselecteerd");
        header("location: browseproduct.php");
        exit;
    }


    require_once ("template.php");