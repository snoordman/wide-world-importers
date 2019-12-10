<?php
    require_once "config.php";
    require_once "functions/products.php";

    $viewFile = "viewFile/beheerverwijderen.php";

    if(checkPermissions("IsSystemUser")){
        if(isset($_GET["submit"])){
            $StockItemID=$_GET["StockItemID"];

            $conn = createConn();
            $query= $conn ->prepare("UPDATE stockitems SET Active=0 WHERE StockItemID= ?");
            $query->bind_param("i", $StockItemID);
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