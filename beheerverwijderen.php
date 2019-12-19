<?php
    require_once "config.php";
    require_once "functions/products.php";

    $viewFile = "viewFile/beheerverwijderen.php";

    if(checkPermissions("isSystemUser") || checkPermissions("isSalesPerson")){
        if(isset($_GET["id"])){
            $StockItemID=$_GET["id"];






            $conn = createConn();
            $query= $conn ->prepare("UPDATE stockitems SET Active=0 WHERE StockItemID= ?");
            $query->bind_param("s", $StockItemID);
            $result = $query->execute();

            $conn->close();

            if($result == true){
                alert_msg_push("alert-success", "Succesvol verwijderd");
                header("Location: browseproduct.php");
                exit;
            }else{
                alert_msg_push("alert-danger", "Er is iets mis gegaan probeer het opnieuw");
                header("Location: browseproduct.php");
                exit;
            }

        }
    }else{
        alert_msg_push("alert-danger", "Niet genoeg rechten voor deze actie");
        header("Location: index.php");
        exit;
    }

    require_once "template.php";
?>