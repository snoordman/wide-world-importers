<?php
    require_once "config.php";
    $viewFile = "viewFile/shoppingcart.php";

    $productsShoppingCart = [];

    var_dump($_SESSION["shoppingCart"]);
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