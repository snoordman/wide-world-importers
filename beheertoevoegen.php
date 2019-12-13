<?php
    require_once "config.php";
    $viewFile = "viewFile/beheertoevoegen.php";

    if(checkPermissions("isSystemUser") || checkPermissions("isSalesPerson")){
        require_once "functions/sql.php";


//Met onderstaande if-statement wordt gekeken of er op de 'Toevoegen' knop is gedrukt

        if (isset($_POST['submit'])) {
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

            //Met onderstaande if-statement wordt er zodra er op de knop Toevoegen wordt gedrukt het image bestand als blob geupload in de tabel photos
            if(isset($_FILES["Photo"]) && $_FILES["Photo"]["error"] == 0) {
                //Met onderstaande query wordt de hoogste PhotoId opgehaald uit de tabel photos
                $maxIdPhoto = "
                    SELECT MAX(PhotoId) AS photoId 
                    FROM photos AS p
                    ORDER BY PhotoId DESC
                    LIMIT 1
                ";
                $photo = $_FILES["Photo"]['tmp_name'];
                $name = $_FILES['Photo']['name'];
                $photo = file_get_contents($photo);


                $query2 = $conn->prepare("INSERT INTO photos (Photo, `name`) VALUES (?, ?)");

                $null = NULL;
                $query2->bind_param("bs", $null, $name);
                $query2->send_long_data(0, $photo);

                $query2->execute();

                //Met onderstaande query wordt er in de koppeltabel stockitemphotos een link gelegd tussen de tabel stockitems en photos
                $query3 = $conn->prepare("INSERT INTO stockitemphotos (StockItemId, PhotoId) VALUES (($maxIdStockItem), ($maxIdPhoto))");

                $query3->execute();
            }

            $conn->close();
        }

        require_once "template.php";
    }else{
        alert_msg_push("alert-danger", "U heeft geen rechten om deze pagina te bezoeken");
        header("Location: index.php");
        exit;
    }
?>