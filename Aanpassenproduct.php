<?php
    require_once "config.php";
    require_once "functions/sql.php";

if(isset($_POST['submit'])) {
    $StockItemName = $_POST['StockItemName'];
    $supplierid = $_POST['SupplierID'];
    $colorid = $_POST['colors'];
    $packagetypeidunit = $_POST['unitpackagetypes'];
    $packagetypeidouter = $_POST['outerpackagetypes'];
    $recommendedretailprice = $_POST['RecommendedRetailPrice'];

    $aanpassenID = $_GET["id"];

    $conn = createConn();
    $query = $conn->prepare("
            UPDATE stockitems 
            SET StockItemName = ?, SupplierID = ?, ColorID = ?, UnitPackageID = ?, OuterPackageID = ?, RecommendedRetailPrice = ?
            WHERE StockItemID = ?
        ");

    $query->bind_param("sssssss",$StockItemName, $supplierid, $colorid, $packagetypeidunit, $packagetypeidouter, $recommendedretailprice, $aanpassenID);
    $query->execute();

    $conn->close();

}
$product = getProductById($_GET["id"]);
    $viewFile = "viewFile/aanpassenProduct.php";

    require_once "template.php";

