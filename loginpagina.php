<?php
    require_once "config.php";
    require_once "functions/login.php";
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

    require_once "template.php";
?>