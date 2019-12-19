<?php
    require_once "sql.php";
    require_once "image.php";

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
            echo "
                <div class='row'>
            ";
            foreach($populairItems AS $item){
                $photo = getPhotosProduct($item["StockItemID"], true);
                if($photo !== false){
                    $photo = $photo[0]["Photo"];
                }
                echo "
                    <div class='col-4'>
                        <a href='product.php?product_id=".$item["StockItemID"]."' style='color:black'>
                            <div class='col-8'>
                ";
            if(!($image = loadDefault($photo, true))){
                echo "
                                <img class='img-fluid' src='data:image/jpeg;base64, " . base64_encode($photo) . " ' />
                ";
            }else{
                echo "  
                                <img class='img-fluid' src='" . $image . "' alt='geen afbeelding aanwezig' />
                ";
            }
            echo "
                            </div>
                            <div class='col-4'>
                                ".$item["StockItemName"]."</a>        
                            </div>
                        </a>
                    </div>
            ";
            }
            echo "</div>";
        }else{
            echo $populairItems;
        }
    }

    //Sum that calculates the actual discount percentage
    function amountSaved(){
        $product = getProductById($_GET["product_id"]);

        $recommendedRetailPrice = $product["RecommendedRetailPrice"];
        $unitPrice = $product["UnitPrice"];

        $priceDeduction = 100 / $recommendedRetailPrice * $unitPrice;
        $actualAmountSaved = 100 - $priceDeduction;

        return round($actualAmountSaved, 0)."%";
//        return "$actualAmountSaved%";
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