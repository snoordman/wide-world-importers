<?php

require_once "functions/alerts.php";
require_once "functions/products.php";
require_once "template.php";
$viewFile = "viewFile/beheerverwijderen.php";


if(isset($_GET["submit"])){
    $StockItemID=$_GET["StockItemID"];

    $conn = createConn();
    $query= $conn ->prepare("INSERT INTO stockitems_archive SELECT * FROM stockitems WHERE StockItemID= ?");
    $query->bind_param("i", $StockItemID);
    $query->execute();
    $conn->close();

    $conn = createConn();
    $query2= $conn ->prepare("DELETE FROM stockitems WHERE StockItemID = ?");
    $query2->bind_param("i", $StockItemID);
    $query2->execute();


    $conn->close();
}

?>