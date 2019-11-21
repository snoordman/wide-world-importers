<!-- Alles met html -->
<div class="product">
    <div class="row">
        <div class="col-5"></div>
        <div class="col-2"><h1>Producten</h1></div>
        <div class="col-5"></div>
    </div>
    <br/>
    <div class="row">
        <div class="col-4">
            <div class="row">
                <form method="get" name="pages">
                    Aantal pagina's:
                    <select name="amountProducts" id="amountProducts" onchange="this.form.submit()">
                        <option value=10>10</option>
                        <option value=25>25</option>
                        <option value=50>50</option>
                        <option value=100>100</option>
                    </select>
                </form>
            </div>
            <br />
            <div class="row">
                <form method="get" name="filter">
                    <div data-toggle="collapse" data-target="#categoriesCollapse"><i class="fas fa-arrow-down"></i> <b>Selecteer categorie</b></div>
                    <div id="categoriesCollapse" class="collapse">
<?php
                    for($i = 0; $i < count($categories); $i++){
?>
                        <input type="checkbox" value='<?php echo $categories[$i]["StockGroupId"]; ?> '> <?php echo $categories[$i]["StockGroupName"]; ?><br/>
<?php
                }
?>
                    </div>
                    <br/>
                    Prijs:(€) <input class="form-control" type="text" name="price" value="" id="price">
                    <input class="form-control" id="range" type="range" step="0.01" min="<?php echo $price["min"] ?>" max="<?php echo $price["max"]; ?>" value="50">
                    <input type="submit" value="Filter">
                </form>
            </div>
        </div>
        <div class="col-8">
            <?php
            displayProducts();
            ?>
        </div>
    </div>
</div>