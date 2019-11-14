<!-- Alles met html -->

<div>
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
    <form action="/action_page.php" id="filters">
        <br>
        <select name="filter1" id="filter1">
            <option value=>Selecteer Categorie:</option>
            <option value=>10</option>
            <option value=25>25</option>
            <option value=50>50</option>
            <option value=100>100</option>
        </select>
        <br/>
        <br><br>
            Prijs:(€)<br>
            <input type="text" name="price" value="" id="price"><br>
            <input type="submit" value="Filter">
            <p></p>
            <input id="range" type="range" step="0.01" min="<?php echo $price["min"] ?>" max="<?php echo $price["max"]; ?>" value="50">

    </form>

</div>
