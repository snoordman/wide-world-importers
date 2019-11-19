<?php
    require_once ("functions/image.php");
    require_once ("functions/sql.php");
    $viewFile = "viewFile/product.php";

    $productId = $_GET["product_id"];
    $product = getProductById($productId);
    $photos = getPhotosProduct($productId);
    require_once ("template.php");