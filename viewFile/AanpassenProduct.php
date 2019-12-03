<div>
<div> <H1>Aanpassen product</H1>   </div>
<form action="aanpassenProduct.php" method="post"><br>
    <p>StockItemName <input type="text" name="StockItemName" value="<?php echo $product["StockItemName"]; ?>"></p>
    <p>SupplierID  <select name="SupplierID">  <?php
        //Onderstaande haalt de leveranciers op uit de DB en zet deze in een dropdown menu
        $conn = createConn();

        $query = $conn->query("SELECT SupplierID, SupplierName FROM suppliers ORDER BY SupplierID");


        while($rows = $query->fetch_assoc()){
            $supplierid = $rows['SupplierID'];
            $suppliername = $rows['SupplierName'];
            $selected =  "";
            if ($supplierid == $product["SupplierID"]){
                $selected = "selected";

            }
            echo "<option value='$supplierid' $selected>$supplierid. $suppliername</option>";
        }
        $conn->close();
        ?>
    </select></p>
    <p> ColorID <select name="colors">
            <?php
            //Onderstaande haalt de kleuren op uit de DB en zet deze in een dropdown menu
            $conn = createConn();

            $query = $conn->query("SELECT ColorID, ColorName FROM colors");

            while($rows = $query->fetch_assoc()) {
                $colorid = $rows['ColorID'];
                $colorname = $rows['ColorName'];
                $selected =  "";
                if ($colorid == $product['ColorID']) {
                    $selected = "selected";
                }
                elseif ($colorid == "NULL")
                {
                    $selected =  "";
                }

                echo "<option value='$colorid' $selected>$colorid. $colorname</option>";

                $conn->close();
            }

            ?>
        </select></p>
    <p>UnitPackageID <select name="unitpackagetypes">
            <?php
            //Onderstaande haalt de verpakkingen op uit de DB en zet deze in een dropdown menu
            $conn = createConn();

            $query = $conn->query("SELECT PackageTypeID, PackageTypeName FROM packagetypes");


            while($rows = $query->fetch_assoc()){
                $packagetypeidunit = $rows['PackageTypeID'];
                $packagetypename = $rows['PackageTypeName'];
                if ($packagetypeidunit == $product['UnitPackageID']){
                    $selected = "selected";
                }else{
                    $selected = "";
                }
                echo "<option value='" . $packagetypeidunit ."' " . $selected . ">" . $packagetypeidunit . $packagetypename . "</option>";
            }


            $conn->close();
            ?>
        </select></p>
    </form>
</div>




