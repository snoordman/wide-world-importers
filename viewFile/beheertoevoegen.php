<div>
    <div>
        <h1>Product toevoegen:</h1>
    </div>
    <div>
        <form action="beheertoevoegen.php" method="post"><br>
            <p>StockItemID <input type="text" name="StockItemID"> Chapt autmatisch een hoger nummer in de database dus niet invullen</p>
            <p>StockItemName <input type="text" name="StockItemName"></p>
            <p>SupplierID <input type="text" name="SupplierID"></p>
            <p>ColorID <input type="text" name="ColorID"></p>
            <p>UnitPackageID <input type="text" name="UnitPackageID"></p>
            <p>OuterPackageID <input type="text" name="OuterPackageID"></p>
            <p>Brand <input type="text" name="Brand"></p>
            <p>Size <input type="text" name="Size"></p>
            <p>LeadTimeDays <input type="text" name="LeadTimeDays"></p>
            <p>QuantityPerOuter <input type="text" name="QuantityPerOuter"></p>
            <p>IsChillerStock <input type="text" name="IsChillerStock"></p>
            <p>Barcode <input type="text" name="Barcode"></p>
            <p>TaxRate <input type="text" name="TaxRate"></p>
            <p>UnitPrice <input type="text" name="UnitPrice"></p>
            <p>RecommendedRetailPrice <input type="text" name="RecommendedRetailPrice"></p>
            <p>TypicalWeightPerUnit <input type="text" name="TypicalWeightPerUnit"></p>
            <p>MarketingComments <input type="text" name="MarketingComments"></p>
            <p>InternalComments <input type="text" name="InternalComments"></p>
            <p>Photo <input type="text"  name="Photo"></p>
            <p>CustomFields <input type="text" name="CustomFields"></p>
            <p>Tags <input type="text" name="Tags"></p>
            <p>SearchDetails <input type="text" name="SearchDetails"></p>
            <p>LastEditedBy <input type="text" name="LastEditedBy"></p>
            <p>ValidFrom <input type="text" name="ValidFrom"></p>
            <p>ValidTo <input type="text" name="ValidTo"></p>
            <input type="submit" value="Toevoegen" name="submit"><br><br>
        </form>
    </div>
</div>

<?php

require_once ("functions/products.php");

$maxId = "
    SELECT MAX(StockItemID) AS maxId 
    FROM stockitems AS s
    UNION ALL 
    SELECT MAX(StockItemID) AS maxId  
    FROM stockitems_archive AS sa
    ORDER BY maxId DESC
    LIMIT 1
";

if(isset($_POST['submit'])){

    $stockitemid = $_POST['StockItemID'];
    $stockitemname = $_POST['StockItemName'];
    $supplierid = $_POST['SupplierID'];
    $colorid = $_POST['ColorID'];
    $unitpackageid = $_POST['UnitPackageID'];
    $outerpackageid = $_POST['OuterPackageID'];
    $brand = $_POST['Brand'];
    $size = $_POST['Size'];
    $leadtimedays = $_POST['LeadTimeDays'];
    $quantityperouter = $_POST['QuantityPerOuter'];
    $ischillerstock = $_POST['IsChillerStock'];
    $barcode = $_POST['Barcode'];
    $taxrate = $_POST['TaxRate'];
    $unitprice = $_POST['UnitPrice'];
    $recommendedretailprice = $_POST['RecommendedRetailPrice'];
    $typicalweightperunit = $_POST['TypicalWeightPerUnit'];
    $marketingcomments = $_POST['MarketingComments'];
    $internalcomments = $_POST['InternalComments'];
    $photo = $_POST['Photo'];
    $customfields = $_POST['CustomFields'];
    $tags = $_POST['Tags'];
    $searchdetails = $_POST['SearchDetails'];
    $lasteditedby = $_POST['LastEditedBy'];
    $validfrom = $_POST['ValidFrom'];
    $validto = $_POST['ValidTo'];

    $conn = createConn();

    $query = $conn->prepare("INSERT INTO stockitems (StockItemID, StockItemName, SupplierID, ColorID, UnitPackageID, OuterPackageID, Brand, `Size`, LeadTimeDays, QuantityPerOuter, 
        IsChillerStock, Barcode, TaxRate, UnitPrice, RecommendedRetailPrice, TypicalWeightPerUnit, MarketingComments, InternalComments, Photo, CustomFields, 
        Tags, SearchDetails, LastEditedBy, ValidFrom, ValidTo) VALUES (($maxId) + 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '" . date('Y-m-d H:i:s') . "' , '9999-12-31 23:59:59')");

    $query->bind_param("siiiissiiiiddddssbsssi", $stockitemname, $supplierid, $colorid, $unitpackageid, $outerpackageid, $brand, $size, $leadtimedays, $quantityperouter, $ischillerstock, $barcode, $taxrate, $unitprice, $recommendedretailprice, $typicalweightperunit, $marketingcomments, $internalcomments, $photo, $customfields, $tags, $searchdetails, $lasteditedby);

    $query->execute();

    $conn->close();

}

?>




<?php
////Onderstaande haalt de leveranciers op uit de DB en zet deze in een dropdown menu
//
//require_once ("functions/products.php");
//
//$conn = createConn();
//
//$query = $conn->query("SELECT SupplierName FROM suppliers");
//
//
//?>
<!--<select name="suppliers">-->
<!--    --><?php
//    echo "Kies leverancier";
//    while($rows = $query->fetch_assoc()){
//        $supplier = $rows['SupplierName'];
//        echo "<option value='$supplier'>$supplier</option>";
//    }
//    ?>
<!--</select>-->
<!---->
<?php
//
//$conn->close();
//
//?>
