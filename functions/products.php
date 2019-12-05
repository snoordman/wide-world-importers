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
                //            print("Productnummer: ".$naam["StockItemID"] . " | ");
                print("Productnaam: ".$naam["StockItemName"]);
                //            print("Hoeveelheid verkocht: ".$naam["COUNT(*) AS meest_verkocht"]);
                print("<br>");
            }
        }else{
            echo $populairItems;
        }
    }

//    function displayEditProducts($result, $product){
//        while($rows = $result){
//            $packagetypeidouter = $rows['PackageTypeID'];
//            $packagetypename = $rows['PackageTypeName'];
//            if ($packagetypeidouter == $product['OuterPackageID'])
//            {
//                $selected = "selected";
//            }else
//            {
//                $selected = "";
//            }
//            echo "<option value='$packagetypeidouter' $selected>$packagetypeidouter. $packagetypename</option>";
//        }
//    }