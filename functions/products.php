<?php
    require_once "sql.php";


    function displayProducts(){
        $products = getProducts();
        var_dump($products);
//        foreach($products AS $naam){
//            print("Product: $naam[0] <br>");
//        }
    }

    function minMaxPrice($products){
        $min = 0;
        $max = 0;
        for($i = 0; $i < count($products); $i++){
            $price = $products[$i]["RecommendedRetailPrice"];
            if($min == 0){
                $min = $price;
            }else{
                if($price < $min){
                    $min = $price;
                }

                if($price > $max){
                    $max = $price;
                }
            }
        }

        return ["min" => $min, "max" => $max];
    }