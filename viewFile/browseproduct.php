<!-- Alles met html -->
<div class="product">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-3"><h1>Producten</h1></div>
        <div class="col-5"></div>
    </div>
    <br/>
    <div class="row">
        <div class="col-4">
            <div class="row">
                <div class="col-6"><h3>Filter</h3></div>
                <div class = "col-5"></div>
                <form method="get" name="pages">
                    Aantal per Pagina:
                    <select name="amountProducts" id="amountProducts" onchange="this.form.submit()">
                        <option value=10 name="limit10">10</option>
                        <option value=25 name="limit25">25</option>
                        <option value=50 name="limit50">50</option>
                        <option value=100 name="limit100">100</option>
                    </select>
                </form>
            </div>
            <br />
            <div class="row">
                <form method="get" name="filter">
                    <div data-toggle="collapse" data-target="#categoriesCollapse" aria-expanded="true"><i class="fas fa-arrow-down"></i> <b>Selecteer categorie</b></div>
                    <div id="categoriesCollapse" class="collapse show">
<?php
                        for($i = 0; $i < count($categories); $i++){
?>
                        <input type="checkbox" value='<?php echo $categories[$i]["StockGroupId"]; ?>' name="categories[]"> <?php echo $categories[$i]["StockGroupName"]; ?><br/>
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
                echo "<div class='row'>";
                foreach($products AS $product){
                    echo " 
							<div class='col-4'>
								<div class='row'>
								<a href='product.php?product_id=" . $product["StockItemId"] . "' style='color:black'>
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
									<div class='col-12'>
										". "€". number_format($product["UnitPrice"], 2, ',', '.') ."
									 </div>
							    </a>
								</div>
								<br>
							</div>
                    ";

                    if(checkPermissions("isSystemUser") || checkPermissions("isSalesPerson")) {
                        echo "
                                <div class='col-2'><a href='AanpassenProduct.php?id=" . $product["StockItemId"] . "'> <i class=\"fas fa-edit\"></i> Aanpassen</a></div>
                        ";
                    }
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>
</div>