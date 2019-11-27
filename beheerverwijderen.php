<?php
$viewFile = "viewFile/beheerverwijderen.php";

if(isset($_GET["submit"])){
$StockItemID=$_GET["StockItemID"];

$conn = createConn();
$query= $conn ->prepare("DELETE FROM stockitems_archive WHERE StockItemID = ?");
$query->blind_param("i", $StockItemID);
$query->execute();
$conn->close();


    
}






require_once "template.php";

?>