<?php
    require_once "config.php";
    $viewFile = "viewFile/beheertoevoegen.php";

    if(checkPermissions("isSystemUser") || checkPermissions("isSalesPerson")){
        require_once "template.php";
    }else{
        alert_msg_push("alert-danger", "U heeft geen rechten om deze pagina te bezoeken");
        header("Location: index.php");
        exit;
    }
?>