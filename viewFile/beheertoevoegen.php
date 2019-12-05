<?php require_once ("functions/products.php"); ?>
<div>
    <div>
        <h1>Product toevoegen:</h1>
    </div>
    <div>
        <form action="beheertoevoegen.php" method="post" enctype="multipart/form-data"><br>
<!--            <p>StockItemID <input type="text" name="StockItemID"></p>-->
            <p>StockItemName <input type="text" name="StockItemName" required></p>
            <p>SupplierID <select name="suppliers">
                    <?php
                    //Onderstaande haalt de leveranciers op uit de DB en zet deze in een dropdown menu
                    $conn = createConn();

                    $query = $conn->prepare("SELECT SupplierID, SupplierName FROM suppliers ORDER BY SupplierID");
                    $query->execute();
                    $query = $query->get_result();

                    while($rows = $query->fetch_assoc()){
                        $supplierid = $rows['SupplierID'];
                        $suppliername = $rows['SupplierName'];
                        echo "<option value='$supplierid'>$supplierid. $suppliername</option>";
                    }

                    $conn->close();
                    ?>
                </select></p>
            <p>ColorID <select name="colors">
                    <?php
                    //Onderstaande haalt de kleuren op uit de DB en zet deze in een dropdown menu
                    $conn = createConn();

                    $query = $conn->prepare("SELECT ColorID, ColorName FROM colors");
                    $query->execute();
                    $query = $query->get_result();

                    while($rows = $query->fetch_assoc()){
                        $colorid = $rows['ColorID'];
                        $colorname = $rows['ColorName'];
                        echo "<option value='$colorid'>$colorid. $colorname</option>";
                    }
                    $conn->close();
                    ?>
                </select></p>
            <p>UnitPackageID <select name="unitpackagetypes">
                    <?php
                    //Onderstaande haalt de verpakkingen op uit de DB en zet deze in een dropdown menu
                    $conn = createConn();

                    $query = $conn->prepare("SELECT PackageTypeID, PackageTypeName FROM packagetypes");
                    $query->execute();
                    $query = $query->get_result();

                    while($rows = $query->fetch_assoc()){
                        $packagetypeidunit = $rows['PackageTypeID'];
                        $packagetypename = $rows['PackageTypeName'];
                        echo "<option value='$packagetypeidunit'>$packagetypeidunit. $packagetypename</option>";
                    }
                    $conn->close();
                    ?>
                </select></p>
            <p>OuterPackageID <select name="outerpackagetypes">
                    <?php
                    //Onderstaande haalt de verpakkingen op uit de DB en zet deze in een dropdown menu
                    $conn = createConn();

                    $query = $conn->prepare("SELECT PackageTypeID, PackageTypeName FROM packagetypes");
                    $query->execute();
                    $query = $query->get_result();

                    while($rows = $query->fetch_assoc()){
                        $packagetypeidouter = $rows['PackageTypeID'];
                        $packagetypename = $rows['PackageTypeName'];
                        echo "<option value='$packagetypeidouter'>$packagetypeidouter. $packagetypename</option>";
                    }
                    $conn->close();
                    ?>
                </select></p>
<!--            <p>Brand <input type="text" name="Brand"></p>-->
<!--            <p>Size <input type="text" name="Size"></p>-->
<!--            <p>LeadTimeDays <input type="text" name="LeadTimeDays"></p>-->
<!--            <p>QuantityPerOuter <input type="text" name="QuantityPerOuter"></p>-->
<!--            <p>IsChillerStock <input type="text" name="IsChillerStock"></p>-->
<!--            <p>Barcode <input type="text" name="Barcode"></p>-->
<!--            <p>TaxRate <input type="text" name="TaxRate"></p>-->
<!--            <p>UnitPrice <input type="text" name="UnitPrice"></p>-->
            <p>RecommendedRetailPrice <input type="text" name="RecommendedRetailPrice" required></p>
<!--            <p>TypicalWeightPerUnit <input type="text" name="TypicalWeightPerUnit"></p>-->
<!--            <p>MarketingComments <input type="text" name="MarketingComments"></p>-->
<!--            <p>InternalComments <input type="text" name="InternalComments"></p>-->
            <p>Photo <input type="file" name="Photo"></p>
<!--            <p>CustomFields <input type="text" name="CustomFields"></p>-->
<!--            <p>Tags <input type="text" name="Tags"></p>-->
<!--            <p>SearchDetails <input type="text" name="SearchDetails"></p>-->
<!--            <p>LastEditedBy <input type="text" name="LastEditedBy"></p>-->
<!--            <p>ValidFrom <input type="text" name="ValidFrom"></p>-->
<!--            <p>ValidTo <input type="text" name="ValidTo"></p>-->
<!--            <p>Active <input type="text" name="Active"></p>-->
            <input type="submit" value="Toevoegen" name="submit"><br><br>
        </form>
    </div>
</div>

<?php

//Met onderstaande query wordt de hoogste StockItemID opgehaald uit de tabellen stockitems en stockitems_archive

$maxIdStockItem = "
    SELECT MAX(StockItemID) AS maxId 
    FROM stockitems AS s
    UNION ALL 
    SELECT MAX(StockItemID) AS maxId  
    FROM stockitems_archive AS sa
    ORDER BY maxId DESC
    LIMIT 1
";

//Met onderstaande query wordt de hoogste PhotoId opgehaald uit de tabel photos

if(!isset($_POST["photoId"])){
    $maxIdPhoto = "
        SELECT MAX(PhotoId) AS photoId 
        FROM photos AS p
        ORDER BY PhotoId DESC
        LIMIT 1
    ";
}else{
    $maxIdPhoto = $_POST["photoId"];
}

//Met onderstaande if-statement wordt gekeken of er op de 'Toevoegen' knop is gedrukt

if(isset($_POST['submit'])) {

//    $stockitemid = $_POST['StockItemID'];
    $stockitemname = $_POST['StockItemName'];
    $supplierid = $_POST['suppliers'];
    $colorid = $_POST['colors'];
    $packagetypeidunit = $_POST['unitpackagetypes'];
    $packagetypeidouter = $_POST['outerpackagetypes'];
//    $brand = $_POST['Brand'];
//    $size = $_POST['Size'];
//    $leadtimedays = $_POST['LeadTimeDays'];
//    $quantityperouter = $_POST['QuantityPerOuter'];
//    $ischillerstock = $_POST['IsChillerStock'];
//    $barcode = $_POST['Barcode'];
//    $taxrate = $_POST['TaxRate'];
//    $unitprice = $_POST['UnitPrice'];
    $recommendedretailprice = $_POST['RecommendedRetailPrice'];
//    $typicalweightperunit = $_POST['TypicalWeightPerUnit'];
//    $marketingcomments = $_POST['MarketingComments'];
//    $internalcomments = $_POST['InternalComments'];
//    $customfields = $_POST['CustomFields'];
//    $tags = $_POST['Tags'];
//    $searchdetails = $_POST['SearchDetails'];
//    $lasteditedby = $_POST['LastEditedBy'];
//    $validfrom = $_POST['ValidFrom'];
//    $validto = $_POST['ValidTo'];
//    $active = $_POST['Active'];

    $conn = createConn();

    //Met onderstaande query worden de waardes die in de bovenstaande form door de gebruiker zijn ingevuld gepushed naar de database

    $query = $conn->prepare("INSERT INTO stockitems (StockItemID, StockItemName, SupplierID, ColorID, UnitPackageID, OuterPackageID, RecommendedRetailPrice, LastEditedBy, ValidFrom, ValidTo, Active) 
		VALUES (($maxIdStockItem) + 1, ?, $supplierid, $colorid, $packagetypeidunit, $packagetypeidouter, ?, 1, '" . date('Y-m-d H:i:s') . "' , '9999-12-31 23:59:59', 1)");

    $query->bind_param("sd", $stockitemname, $recommendedretailprice);

    $query->execute();

    $conn->close();


//Met onderstaande if-statement wordt er zodra er op de knop Toevoegen wordt gedrukt het image bestand als blob geupload in de tabel photos

    if (isset($_POST['submit'])) {

        $photo = $_FILES['Photo']['tmp_name'];
        $name = $_FILES['Photo']['name'];
        $photo = base64_encode(file_get_contents(addslashes($photo)));

        $conn = createConn();

        $query = $conn->prepare("INSERT INTO photos (Photo, `name`) VALUES (?, ?)");

        $query->bind_param("ss", $photo, $name);

        $query->execute();

        $conn->close();

    }

//Met onderstaande query wordt er in de koppeltabel stockitemphotos een link gelegd tussen de tabel stockitems en photos

    $conn = createConn();

    $query = $conn->prepare("INSERT INTO stockitemphotos (StockItemId, PhotoId) VALUES (($maxIdStockItem), ($maxIdPhoto))");

    $query->execute();

    $conn->close();
}

?>