<!-- Alles met html -->

<div>
    Ons assortiment
    <br>
    <form name="amountProductsForm" method="post">
        <select name="amountProducts" id="amountProducts" onchange="this.form.submit()">
            <option value=>Aantal per pagina:</option>
            <option value=10>10</option>
            <option value=25>25</option>
            <option value=50>50</option>
            <option value=100>100</option>
        </select>
    </form>
    <br>
    <form method="post" name="filters" id="filters">
        <br>
        <label>Selecteer Categorie</label> <br/>
        <select name="categorie" id="categorie">
            <option value=>10</option>
            <option value=25>25</option>
            <option value=50>50</option>
            <option value=100>100</option>
        </select>
        <br/>
        <br><br>
            Prijs:(€)<br>
            <input type="text" name="price" value="" id="price"><br>

            <p></p>
            <input id="range" type="range" step="0.01" min="<?php echo $price["min"] ?>" max="<?php echo $price["max"]; ?>" value="50">
            <br/>
            <input type="submit" value="Filter">


    </form>

</div>
