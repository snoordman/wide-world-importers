<?php
    require_once "sql.php";

    function retrieveProducts(){
        $conn = createConn();
        $products = getProducts($conn);
        closeConn($conn);

        if(is_string($products)){
            return $products;
        }else if($products->num_rows > 0){
            return $products;
        }else{
            return "Geen resultaten";
        }
    }

    $hoi = getProductByCategory(createConn(), [6]);
    foreach ($hoi as $doei){
        echo $doei[1];
        echo "<br />";
    }