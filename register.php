<?php
    require_once "config.php";
    require_once "functions/login.php";
    $viewFile = "viewFile/register.php";

    if(isset($_POST["submitRegister"])){
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        $phoneNumber = $_POST["phoneNumber"];
        $faxNumber = $_POST["faxNumber"];
        $userId = 3255;
        $permissions = null;

        if(isset($_POST["permissions"])){
            $permissions = $_POST["permissions"];
        }

        $requiredFields = ["firstName" => "Voornaam", "lastName" => "Achternaam", "email" => "E-mail", "password" => "Wachtwoord"];
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
            register($firstName, $lastName, $password, $email, $phoneNumber, $faxNumber, $userId, $permissions);
        }

    }

    require_once "template.php";
