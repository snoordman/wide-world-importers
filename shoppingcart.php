<?php
    require_once "config.php";
    require_once "functions/sql.php";
    require_once "functions/image.php";
    require_once "functions/permissions.php";
    $viewFile = "viewFile/shoppingcart.php";

    $productsShoppingCart = [];

    if(isset($_POST["quantity"])){
        if(isset($_POST["id"])){
            $id = $_POST["id"];
            $quantity = $_POST["quantity"];

            if(is_numeric($id) && is_numeric($quantity) && isset($_SESSION["shoppingCart"][$id])){
                if($quantity == 0){
                    unset($_SESSION["shoppingCart"][$id]);
                }else{
                    $_SESSION["shoppingCart"][$id]["quantity"] = $quantity;
                }
            }else{
                alert_msg_push("alert-danger", "Er is iets mis gegaan, probeer alsublieft opnieuw");
            }
        }else{
            alert_msg_push("alert-danger", "Er is iets mis gegaan, probeer alsublieft opnieuw");
        }
    }else if(isset($_POST["deleteItem"])){
        if(isset($_POST["itemId"])) {
            $id = $_POST["itemId"];
            if (isset($_SESSION["shoppingCart"][$id])){
                unset($_SESSION["shoppingCart"][$id]);
            } else {
                alert_msg_push("alert-danger", "Er is iets mis gegaan, probeer alsublieft opnieuw");
            }
        }else{
            alert_msg_push("alert-danger", "Er is iets mis gegaan, probeer alsublieft opnieuw");
        }
    }

    if(isset($_SESSION["shoppingCart"])){
        $products = [];
        $totalProducts = 0;
        $total = 0;
        if(count($_SESSION["shoppingCart"]) == 0){
            unset($_SESSION["shoppingCart"]);
        }else {
            $products = getMultipleProducts(array_keys($_SESSION["shoppingCart"]));
            if(!is_string($products)){
                for($i = 0; $i < count($products); $i++){
                    $id = $products[$i]["StockItemId"];
                    $products[$i]["subtoal"] = $products[$i]["UnitPrice"] ;
                    $products[$i]["quantity"] = $_SESSION["shoppingCart"][$id]["quantity"];
                    $photo = getPhotosProduct($id, true);
                    if($photo !== "Geen resultaten"){
                        $products[$i]["photo"] = $photo[0]["Photo"];
                    }else{
                        $products[$i]["photo"] = null;
                    }

                    $subTotal = $products[$i]["UnitPrice"] * $products[$i]["quantity"];
                    $products[$i]["subTotal"] = $subTotal;
                    $total += $subTotal;
                    $totalProducts = $totalProducts + $products[$i]["quantity"];
                }
            }
        }

        if(isset($_POST["submitPurchase"])){
            if(checkLoggedIn()){
                $products = getMultipleProducts(array_keys($_SESSION["shoppingCart"]));

//            $viewFile = "viewFile/checkout.php";
//
//            $countries = getCountries();
//
//            if ($countries !== false) {
//                $provinces = getProvincesByCountry($countries[0]["CountryID"]);
//
//                if ($provinces !== false) {
//                    $cities = getCitiesByProvince($provinces[0]["StateProvinceID"]);
//                    if ($cities == false) {
//                        $cities = [];
//                        $cityPlaceHolder = "Geen opties beschikbaar";
//                    }
//                } else {
//                    $provinces = [];
//                    $cities = [];
//                    $cityPlaceHolder = "Geen opties beschikbaar";
//                    $provincePlaceHolder = "Geen opties beschikbaar";
//                }
//            } else {
//                $countryPlaceHolder = "Geen opties beschikbaar";
//                $provincePlaceHolder = "Geen opties beschikbaar";
//                $cityPlaceHolder = "Geen opties beschikbaar";
//                $countries = [];
//            }
              $checkout = insertOrder($products);
              if($checkout == false){
                  alert_msg_push("alert-success", "Er is iets mis gegaan, probeer alstublieft onpieuw");
              }else{
                  alert_msg_push("alert-success", "Betaling succesvol, uw producten/producten zullen zo wnel mogelijk worden geleverd");
              }

            }else{
                alert_msg_push("alert-danger", "U moet ingelogd zijn om producten te kunnen bestellen");
                header("location: loginpagina.php?checkout=true");
                exit;
            }
        }
    }

    // remove product from shopping cart


    require_once "template.php";
?>