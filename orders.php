<?php
    require_once "config.php";
    require_once "functions/sql.php";
    require_once "orders.php";

    $viewFile = "viewFile/orders.php";
    $orders = [];

    if(checkLoggedIn()){
        $orders = getOrders();

        require_once "template.php";
    }else{
        alert_msg_push("altert-danger", "U moet ingelogd zijn om uw bestellingen te bekijken");
        header("Location: login.php");
    }