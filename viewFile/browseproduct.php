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

    <form action="/action_page.php" id="Filters">
        <br>
        <select name="filter1" id="filter1">
            <option value=>Selecteer Categorie:</option>
            <option value=>10</option>
            <option value=25>25</option>
            <option value=50>50</option>
            <option value=100>100</option>
        </select>
        <br/>

    </form>

</div>
