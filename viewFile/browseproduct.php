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
?>
                    </div>
                    <br/>
                    Max Prijs:(€)
                    <input class="form-control" type="text" name="price" value="" id="price">
                    <input class="form-control" id="range" type="range" step="0.01" min="<?php echo $price["min"] ?>" max="<?php echo $price["max"]; ?>" value="50">
                    <input type="submit" value="Filter" name="submitFilter">
                </form>
            </div>
        </div>
        <div class="col-8">
            <?php
            if(is_string($products)){
                echo $products;
            }else{
                foreach($products AS $product){
                    echo "<a href='product.php?product_id=".$product["StockItemId"]."' style='color:black'>".$product["StockItemName"]."</a>". "<br />". "<p><a href='AanpassenProduct.php?id=" . $product["StockItemId"] . "'  title='Dit product aanpassen.'>Aanpassen</a></p>";
                }
            }
            ?>
        </div>
    </div>
</div>