<?php
    require_once "config.php";
    require_once "functions/sql.php";
    require_once "functions/image.php";
    require_once "functions/permissions.php";
    $viewFile = "viewFile/shoppingcart.php";

    $productsShoppingCart = [];
    $wentToPurchase = false;

    if(isset($_POST["quantity"])){
        if(isset($_POST["id"])){
            $id = $_POST["id"];
            $quantity = $_POST["quantity"];

            if(is_numeric($id) && is_numeric($quantity) && isset($_SESSION["shoppingCart"][$id])){
                if($quantity == 0){
                    unset($_SESSION["shoppingCart"][$id]);
                }else{
                    $_SESSION["shoppingCart"][$id]["quantity"] = $quantity;
                    $_SESSION["shoppingCart"][$id]["pickCompletedWhen"] = date('Y-m-d H:i:s');
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
                    $id = $products[$i]["StockItemID"];
                    $products[$i]["quantity"] = $_SESSION["shoppingCart"][$id]["quantity"];
                    $products[$i]["pickCompletedWhen"] = $_SESSION["shoppingCart"][$id]["pickCompletedWhen"];

                    $subTotal = $products[$i]["UnitPrice"] * $products[$i]["quantity"];
                    $products[$i]["subTotal"] = $subTotal;
                    $total += $subTotal;
                    $totalProducts = $totalProducts + $products[$i]["quantity"];
                }
                $total += 3.95;

                if(isset($_POST["submitPurchase"])){
                    $wentToPurchase = true;
                    if(checkLoggedIn()){

                        $checkout = insertOrder($products);
                        if($checkout !== true){
                            alert_msg_push("alert-danger", "Er is iets mis gegaan, probeer alstublieft onpieuw");
                        }else{
                            alert_msg_push("alert-success", "Bestelling succesvol geplaatst, er wordt zo snel mogelijk contact met u opgenomen");
                            unset($_SESSION["shoppingCart"]);
                            header("location: browseproduct.php");
                            exit;
                        }

                    }else{
                        alert_msg_push("alert-danger", "U moet ingelogd zijn om producten te kunnen bestellen");
                        header("location: loginpagina.php?checkout=true");
                        exit;
                    }
                }

                for($i = 0; $i < count($products); $i++) {
                    $id = $products[$i]["StockItemID"];
                    $photo = getPhotosProduct($id, true);
                    if ($photo !== "Geen resultaten") {
                        $products[$i]["photo"] = $photo[0]["Photo"];
                    } else {
                        $products[$i]["photo"] = null;
                    }
                }

            }
        }
    }

    if(isset($_POST["submitPurchase"]) && $wentToPurchase == false){
        alert_msg_push("Alert-danger", "Er is iets mis gegaan, probeer alstublieft opnieuw");
    }
    // remove product from shopping cart


    require_once "template.php";
?>