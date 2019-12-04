<?php
    require_once "config.php";
    require_once "functions/login.php";

    if(!checkLoggedIn()){

        $viewFile = "viewFile/loginpagina.php";


        if(isset($_POST["submitLogin"])){
            $requiredFields = ["logonName" => "E-mail", "password" => "Wachtwoord"];
            $errorFields = [];
            foreach ($requiredFields as $field => $message){
                if(!isset($_POST[$field]) || $_POST[$field] == ""){
                    array_push($errorFields, $message);
                }
            }
            if(count($errorFields) !== 0){
                $errorMessage = "U heeft de volgende velden niet ingevuld: ";
                checkRequiredInput($errorMessage, $errorFields, "alert-danger");
            }else{
                login($_POST["logonName"], $_POST["password"]);
            }

        }
    }else if(isset($_GET["logout"]) && $_GET["logout"] == true){
        unset($_SESSION["loggedIn"]);
        unset($_SESSION["permissions"]);
        alert_msg_push("alert-success", "Succesvol uitgelogd");
        header("location: loginpagina.php");
        exit;
    }else{
        alert_msg_push("alert-warning", "U bent al ingelogd");
        header("location: index.php");
        exit;
    }

    require_once "template.php";
?>