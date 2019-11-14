<?php
require_once "functions/sql.php";
require_once "functions/products.php";

$products = getProducts();

$viewFile = "viewFile/browseproduct.php";

// alles met php

$price = minMaxPrice(getProducts());

if(isset($_POST["amountProducts"])){
    echo "";
}

require_once ("template.php");