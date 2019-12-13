<?php
    require_once "sql.php";


    function displayProducts(){
        $products = getProducts();

        foreach($products AS $naam){
            print($naam["StockItemName"]. " ");
            print($naam["UnitPrice"] . "<br>");
        }
    }

    function minMaxPrice($products){
        $min = 0;
        $max = 0;
        for($i = 0; $i < count($products); $i++){
            $price = $products[$i]["UnitPrice"];
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

    function checkWeightProduct($size){
        $weightArray = ["g", "kg", "mg"];
        if(in_array(substr($size, -1), $weightArray)){
            return false;
        }

        return true;
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

    //Sum that calculates the actual discount percentage
    function amountSaved(){
        $product = getPriceForDiscount();

        $recommendedRetailPrice = $product["RecommendedRetailPrice"];
        $unitPrice = $product["UnitPrice"];

        $priceDeduction = 100 / $recommendedRetailPrice * $unitPrice;
        $actualAmountSaved = 100 - $priceDeduction;

        return round($actualAmountSaved, 0)."%";
    }
    //Sum that calculates the actual discount percentage

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