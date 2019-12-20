<!-- Alles met html -->
<?php
    if(isset($_GET["amountProducts"])){
        $parameter = "?amountProducts=" . $_GET["amountProducts"] . "&";
    }else{
        $parameter = "?";
    }
?>
<div class="product">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-3"><h1>Producten</h1></div>
        <div class="col-5">
            <?php
                if(!isset($_GET["submitFilter"]) && !isset($_GET["price"]) && !isset($_GET["categories"])){
                    for($i = 0; $i < $pages; $i++){
                        echo "<a href='browseproduct.php".$parameter."page=".$i."'>" . ($i + 1) . " </a>";
                    }
                }
            ?>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-4">
            <div class="row">
                <div class="col-6"><h3>Filter</h3></div>
                <div class = "col-5"></div>
                <?php
                if(!isset($_GET["submitFilter"]) && !isset($_GET["price"]) && !isset($_GET["categories"])) {
                    ?>
                    <form method="get">
                        Aantal per Pagina:
                        <select name="amountProducts" id="amountProducts" onchange="this.form.submit()">
                            <?php
                            foreach ($amountPageValues as $value) {
                                echo "<option value='" . $value . "' ";
                                if (isset($_GET["amountProducts"]) && $_GET["amountProducts"] == $value) {
                                    echo "selected ";
                                }
                                echo ">" . $value . "</option>";
                            }
                            ?>
                        </select>
                        <?php
                        if (isset($_GET["page"])) {
                            echo '<input type="hidden" name="page" value="' . $_GET['page'] . '"/>';
                        }
                        ?>
                    </form>
                    <?php
                }
                ?>
            </div>
            <br />
            <div class="row">
                <form method="get" name="filter">
                    <?php
                        if(isset($_GET["page"])){
                            echo '<input type="hidden" name="page" value="'.$_GET['page'] . '"/>';
                        }
                        if(isset($_GET["amountProducts"])){
                            echo '<input type="hidden" name="amountProducts" value="'.$_GET['amountProducts'] . '"/>';
                        }
                    ?>
                    <div data-toggle="collapse" data-target="#categoriesCollapse" aria-expanded="true"><i class="fas fa-arrow-down"></i> <b>Selecteer categorie</b></div>
                    <div id="categoriesCollapse" class="collapse show">
<?php
                        for($i = 0; $i < count($categories); $i++){
                            if(isset($_GET["categories"]) && in_array($categories[$i]["StockGroupId"], $_GET["categories"])){
                                $selected = "checked";
                            }else{
                                $selected = "";
                            }
?>
                            <input type="checkbox" value='<?php echo $categories[$i]["StockGroupId"]; ?>' name="categories[]" <?php echo $selected ?>> <?php echo $categories[$i]["StockGroupName"]; ?><br/>
<?php
                        }

//Retrieve image from database and display it on html webpage
//function displayImageFromDatabase(){
//    $conn = createconn();
//    $sqlselectimageFromDb = "SELECT * FROM photos ";
//    $dataFromDb = mysqli_query($conn, $sqlselectimageFromDb);
//    while ($row = mysqli_fetch_assoc($dataFromDb)) {
//        echo '<img src="data:image;base64,'. base64_encode($row['Photo']) . '" />';
//    }
//    $conn->close();
//}
//
//displayImageFromDatabase();
    ?>
                    </div>
                    <br/>
                    Max Prijs:(€)
                    <input class="form-control" type="text" name="price" value="" id="price">
                    <input class="form-control" id="range" type="range" step="0.01" min="<?php echo $price["minPrice"] ?>" max="<?php echo $price["maxPrice"]; ?>" value="50">
                    <input type="submit" value="Filter" name="submitFilter">
                </form>
            </div>
        </div>
        <div class="col-8">
            <?php
            if(is_string($products)){
                echo $products;
            }else{
                echo "
                    <div class='row'>
                ";
                foreach($products AS $product){
                    echo " 
                        <div class='col-4'>
                            <a href='product.php?product_id=" . $product["StockItemId"] . "' style='color:black'>
                                <div class='row'>
                                    <div class='col-12'>
                    ";
                    if(!($image = loadDefault($product['photo'], true))){
                        echo "             
                                        <img class='img-fluid' src='data:image/jpeg;base64, " . base64_encode($product["photo"]) . " ' />
                        ";
                    }else{
                        echo "  
                                        <img class='img-fluid' src='" . $image . "' alt='geen afbeelding aanwezig' />
                        ";
                    }
		            echo "
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-12'>
                                        ". $product["StockItemName"] ."
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-5'>
                                        €". number_format($product["UnitPrice"], 2, ',', '.') ."
                                    </div>
                                </div>
                            </a>
                    ";
                    if(checkPermissions("isSystemUser") || checkPermissions("isSalesPerson")) {
                        echo "
                            <a href='AanpassenProduct.php?id=" . $product["StockItemId"] . "'> <i class=\"fas fa-edit\"></i> Aanpassen</a>
                            <a href='beheerverwijderen.php?id=" . $product["StockItemId"] . "' ><i class=\"fas fa-edit\"></i>Verwijderen</a>
                        
                        ";
                    }
                    echo "
                            <br />
                            <br />
                        </div>
                    ";
                }
                echo "
                    </div>
                ";
            }
            ?>
        </div>
    </div>
</div>