<?php
    require_once "config.php";
    require_once "functions/sql.php";

    if(checkPermissions("isSystemUser") || checkPermissions("isSalesPerson")) {
        if (isset($_POST['submit'])) {
            $StockItemName = $_POST['StockItemName'];
            $supplierid = $_POST['SupplierID'];
            $colorid = $_POST['colors'];
            $packagetypeidunit = $_POST['unitpackagetypes'];
            $packagetypeidouter = $_POST['outerpackagetypes'];
            $unitPrice = $_POST['unitPrice'];

            $aanpassenID = $_GET["id"];

            $conn = createConn();
            $query = $conn->prepare("
                    UPDATE stockitems 
                    SET StockItemName = ?, SupplierID = ?, ColorID = ?, UnitPackageID = ?, OuterPackageID = ?, RecommendedRetailPrice = ?
                    WHERE StockItemID = ?
                ");

            $query->bind_param("sssssss", $StockItemName, $supplierid, $colorid, $packagetypeidunit, $packagetypeidouter, $unitPrice, $aanpassenID);
            $query->execute();

            $conn->close();

        }
        $product = getProductById($_GET["id"]);
        $viewFile = "viewFile/aanpassenProduct.php";
    }else{
        alert_msg_push("alert-danger", "U heeft geen rechten om deze pagina te bezoeken");
        header("Location: index.php");
        exit;
    }

    require_once "template.php";

