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