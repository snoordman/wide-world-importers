<?php
    require_once "config.php";
    require_once ("functions/products.php");
    require_once ("functions/image.php");


    $viewFile = "viewFile/product.php";

    $productId = $_GET["product_id"];
    $product = getProductById($productId);
    $photos = getPhotosProduct($productId);




    require_once ("template.php");