<?php
    require_once "config.php";
    require_once "functions/login.php";
    $viewFile = "viewFile/register.php";

    $provinces = [];
    $cities = [];
    $countries = getCountries();
    if($countries !== false){
        $provinces = getProvincesByCountry($countries[0]["CountryID"]);

        if($provinces !== false){
            $cities = getCitiesByProvince($provinces[0]["StateProvinceID"]);
        }else{
            $provinces = [];
            $cities = [];
        }
    }else{
        $countries = [];
    }

    if(isset($_POST["submitRegister"])){
        if(isset($_POST["permissions"])){
            $permissions = $_POST["permissions"];
        }

        $requiredFields = ["firstName" => "Voornaam", "lastName" => "Achternaam", "email" => "E-mail", "password" => "Wachtwoord", "deliveryMethod", "deliveryCity", "deliveryCity" => "Stad", "deliveryAddress" => "adres", "deliveryPostalCode" => "Postcode"];
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
            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            $password = $_POST["password"];
            $email = $_POST["email"];
            $phoneNumber = $_POST["phoneNumber"];
            $userId = 3255;
            $permissions = null;

            // delivery location and postal location are currently the same
            $deliveryMethod = $_POST["deliveryMethod"];
            $deliveryLocation = [$_POST["deliveryCity"], $_POST["deliveryAdres"], $_POST["deliveryPostalCode"]];
            
            if(!validateValuesRegister($password, $email, $phoneNumber)) {
                $password = password_hash($password, PASSWORD_BCRYPT);
                register($firstName, $lastName, $password, $email, $phoneNumber, $userId, $permissions, $deliveryMethod, $deliveryLocation);
            }
        }

    }

    require_once "template.php";
