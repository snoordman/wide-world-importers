<?php
    require_once "sql.php";


    function displayProducts(){
        $products = getProducts();
        var_dump($products);
//        foreach($products AS $naam){
//            print("Product: $naam[0] <br>");
//        }
    }