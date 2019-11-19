<!-- Alles met html -->
<body>
<div class="product">
<div class="row">
    <div class="col-10">
        <h1>Ons assortiment</h1>
    </div>


</div>
<div class="row">
<div class="col-3">



    <br>
    <form name="amountProductsForm" method="post">
        <label>Weergave op pagina:</label>
        <br>
        <select name="amountProducts" id="amountProducts" onchange="this.form.submit()">
            <option value=10>10</option>
            <option value=25>25</option>
            <option value=50>50</option>
            <option value=100>100</option>
        </select>
    </form>
</div>
<form>
    <br>
    <div class="col-4">
    <form method="post" name="filters" id="filters">
        <br>
        <label>Categorie:</label> <br/>
        <select name="categorie" id="categorie">
            <option value='<?php echo $cat ?>'><?php echo $cat ?></option>
            <option value='<?php echo $cat ?>'><?php echo $cat ?></option>
            <option value='<?php echo $cat ?>'><?php echo $cat ?></option>
            <option value='<?php echo $cat ?>'><?php echo $cat ?></option>
        </select>
    </div>
        <br/>
        <br><br>
</form>

    <form>
<div class="col-10">

    Prijs:(€)<br>
            <input type="text" name="price" value="" id="price"><br>

            <p></p>
            <input id="range" type="range" step="0.01" min="<?php echo $price["min"] ?>" max="<?php echo $price["max"]; ?>" value="50">
            <br/>
</div>
<div class="col-12">
    <input type="submit" value="Filter">
</div>
</div>


    </form>


    <div>
    <?php
       displayProducts();
       ?>
</div>

</div>

</body>