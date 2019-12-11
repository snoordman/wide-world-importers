<?php
    require_once "config.php";
    require_once "functions/sql.php";
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
    }
    
    if(isset($_SESSION["shoppingCart"])){
        $products = [];
        if(count($_SESSION["shoppingCart"]) == 0){
            unset($_SESSION["shoppingCart"]);
        }else {
            $products = getMultipleProducts(array_keys($_SESSION["shoppingCart"]));
            if(!is_string($products)){
                for($i = 0; $i < count($products); $i++){
                    $id = $products[$i]["StockItemId"];
                    $products[$i]["quantity"] = $_SESSION["shoppingCart"][$id]["quantity"];
                    $photo = getPhotosProduct($id, true)[0]["Photo"];
                    if($photo !== "Geen resultaten"){
                        $products[$i]["photo"] = $photo;
                    }else{
                        $products[$i]["photo"] = null;
                    }
                }
            }
        }
    }

    // remove product from shopping cart
    if(isset($_GET["removeProduct"]) && $_GET["removeProduct"] == true && isset($_GET["shoppingCartItem"])){
        if(isset($_SESSION["shoppingCart"][$_GET["shoppingCartItem"]])){
            unset($_SESSION["shoppingCart"][$_GET["shoppingCartItem"]]);
        }else{
            alert_msg_push("alert-warning", "Product zit niet in de winkelwagen");
        }
    }

    // remove 1 item for product in shopping cart
    // if picked quantity is 1 remove product from shopping cart
    if(isset($_GET["removeSingle"])){
        if(isset($_SESSION["shoppingCart"][$_GET["removeSingle"]])){
            if($_SESSION["shoppingCart"][$_GET["removeSingle"]]["quantity"] == 1){
                unset($_SESSION["shoppingCart"][$_GET["removeSingle"]]);
            }else{
                $_SESSION["shoppingCart"][$_GET["removeSingle"]]["quantity"] -= 1;
            }
        }else{
            alert_msg_push("alert-warning", "Product zit niet in de winkelwagen");
        }
    }

    require_once "template.php";
?>