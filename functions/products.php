<?php
    require_once "sql.php";

    function retrieveProducts(){
        $conn = createConn();
        $products = getProducts($conn);
        closeConn($conn);

        if(is_string($products) || $products->num_rows > 0){
            return $products;
        }else{
            return "Geen resultaten";
        }
    }

    function retrieveProductsByCategories($categories){
        $conn = createConn();
        $products = getProductByCategory($conn, $categories);

        if(is_string($products) || $products->num_rows > 0){
            return $products;
        }else{
            return "Geen resultaten";
        }
    }

    function requestProducts(){
        $connection = createConn();
        $products = requestProducts($connection);
        closeConn();
        return $products;
    }

    function displayProducts($products){
        foreach($products AS $naam){
            print("Product: $naam<br>");
        }
    }