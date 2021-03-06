<div>
    <div>
        <h1>Product toevoegen:</h1>
    </div>
    <div>
        <form action="beheertoevoegen.php" method="post" enctype="multipart/form-data"><br>
<!--            <p>StockItemID <input type="text" name="StockItemID"></p>-->
            <p>Productnaam <input type="text" name="StockItemName" required></p>
            <p>Leverancier <select name="suppliers">
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
            <p>Kleur <select name="colors">
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
            <p>Verpakking (product) <select name="unitpackagetypes">
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
            <p>Verpakking (versturen)<select name="outerpackagetypes">
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
            <p>Onze prijs <input type="text" name="UnitPrice" required></p>
            <p>Adviesprijs <input type="text" name="RecommendedRetailPrice" required></p>
            <p>Voorraad <input type="text" name="QuantityOnHand"></p>
<!--            <p>TypicalWeightPerUnit <input type="text" name="TypicalWeightPerUnit"></p>-->
            <p>Productbeschrijving <textarea rows="2" name="MarketingComments"></textarea></p>
<!--            <p>InternalComments <input type="text" name="InternalComments"></p>-->
            <p>Afbeelding <input type="file" name="Photo"></p>
<!--            <p>CustomFields <input type="text" name="CustomFields"></p>-->
<!--            <p>Tags <input type="text" name="Tags"></p>-->
<!--            <p>SearchDetails <input type="text" name="SearchDetails"></p>-->
<!--            <p>LastEditedBy <input type="text" name="LastEditedBy"></p>-->
<!--            <p>ValidFrom <input type="text" name="ValidFrom"></p>-->
<!--            <p>ValidTo <input type="text" name="ValidTo"></p>-->
<!--            <p>Active <input type="text" name="Active"></p>-->
            <input type="submit" value="Toevoegen" name="submit" class="btn-primary"><br><br>
        </form>
    </div>
</div>