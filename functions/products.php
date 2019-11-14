<?php
    require_once "sql.php";


    function displayProducts(){
        $products = getProducts();
        foreach($products AS $naam){
            print("Product: ".$naam["StockItemName"] . "<br>");
        }
    }