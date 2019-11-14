<?php

include 'functions/products.php';

    $viewFile = "viewFile/home.php";

    $products = requestProducts();

    require_once "template.php";



?>