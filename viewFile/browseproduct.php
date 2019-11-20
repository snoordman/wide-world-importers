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
                <form name="amountProductsForm" method="post">
                    <label>Weergave per pagina:</label>
                    <select name="amountProducts" id="amountProducts" onchange="this.form.submit()">
                        <option value=10>10</option>
                        <option value=25>25</option>
                        <option value=50>50</option>
                        <option value=100>100</option>
                    </select>
                </form>
            </div>
            <br/>
            <div class="row">
                <form method="post" name="filters" id="filters">
                    <label>Categorie:</label> <br/>
                    <select data-placeholder="" class="form-control chosen" name="categorie" id="categorie">
                        <option value=""></option>
                        <?php
                        for($i = 0; $i < count($categories); $i++){
                            ?>
                            <option value='<?php echo $categories[$i]["StockGroupId"]; ?>'><?php echo $categories[$i]["StockGroupName"]; ?></option>
                            <?php
                        }
                        ?>
                    </select><br>

                    Prijs:(€) <input class="form-control" type="text" name="price" value="" id="price">
                    <input class="form-control" id="range" type="range" step="0.01" min="<?php echo $price["min"] ?>" max="<?php echo $price["max"]; ?>" value="50">
                    <br/>
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