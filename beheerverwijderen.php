<?php
    require_once "config.php";
    require_once "functions/products.php";

    $viewFile = "viewFile/beheerverwijderen.php";

    if(checkPermissions("isSystemUser") || checkPermissions("isSalesPerson")){
        if(isset($_GET["submit"])){
            $StockItemName=$_GET["StockItemName"];

            $conn = createConn();
            $query= $conn ->prepare("UPDATE stockitems SET Active=0 WHERE StockItemName= ?");
            $query->bind_param("s", $StockItemName);
            $query->execute();

            $conn->close();
        }
    }else{
        alert_msg_push("alert-danger", "U heeft geen rechten om deze pagina te bezoeken");
        header("Location: index.php");
        exit;
    }

    require_once "template.php";
?>