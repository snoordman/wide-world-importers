<?php
    require_once "config.php";
    require_once ("functions/products.php");
    require_once ("functions/image.php");

    $viewFile = "viewFile/product.php";
    $product = [];
    if(isset($_GET["product_id"])){
        $productId = $_GET["product_id"];
        $product = getProductById($productId);
        if(is_array($product)){
            $photos = getPhotosProduct($productId);

            if(isset($_POST["submitProduct"])){
                if(isset($_POST["amountProduct"]) && $_POST["amountProduct"] !== "" && is_numeric($_POST["amountProduct"])){
                    $quantity = (int)$_POST["amountProduct"];
                    if(isset($_SESSION["shoppingCart"][$productId])){
                        $_SESSION["shoppingCart"][$productId]["quantity"] += $quantity;
                    }else{
                        $_SESSION["shoppingCart"][$productId] = ["packageTypeId" => $product["packageTypeId"], "quantity" => $quantity, "unitPrice" =>
                            $product["UnitPrice"], "taxRate" => $product["TaxRate"], "time" => date('Y-m-d H:i:s')];
                    }
                    alert_msg_push("alert-success", "Succesvol toegevoegd");
                    header("Location: " . $_SERVER['REQUEST_URI']);
                    exit;
                }else{
                    alert_msg_push("alert-danger", "Ongeldig aantal producten geselecteerd");
                }
            }
        }else{
            alert_msg_push("alert-danger", "U heeft een ongeldig product geselecteerd");
            header("location: browseproduct.php");
            exit;
        }
    }else{
        alert_msg_push("alert-danger", "U heeft geen product geselecteerd");
        header("location: browseproduct.php");
        exit;
    }


    require_once ("template.php");