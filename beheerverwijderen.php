<?php
$viewFile = "viewFile/beheerverwijderen.php";
require_once "functions/products.php";
require_once "template.php";

if(isset($_GET["submit"])){
$StockItemID=$_GET["StockItemID"];

$conn = createConn();
$query= $conn ->prepare("SELECT * INTO stockitems_archive FROM stockitems WHERE StockItemID = ?");
$query->bind_param("i", $StockItemID);
$query->execute();
$conn->close();



}






?>