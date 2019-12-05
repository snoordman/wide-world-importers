<?php
    require_once "sql.php";


    function displayProducts(){
        $products = getProducts();

        foreach($products AS $naam){
            print($naam["StockItemName"]. " ");
            print($naam["RecommendedRetailPrice"] . "<br>");
        }
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

    function displayProduct($text, $field){
        echo "
            <div class='row'>
                ". $text . $field . "   
            </div>
        ";
    }

    function displayMostPopulairItems(){
        $populairItems = fetchMostPopulairItems();

        if(is_array($populairItems)){
            foreach($populairItems AS $naam){
                echo ("<a href='product.php?product_id=".$naam["StockItemID"]."' style='color:black' >".$naam["StockItemName"]."</a><br>");
            }
        }else{
            echo $populairItems;
        }
    }