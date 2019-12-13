<?php
    require_once "config.php";
    require_once "functions/login.php";
    $viewFile = "viewFile/register.php";

    $countryPlaceHolder = "";
    $provincePlaceHolder = "";
    $cityPlaceHolder = "";
    $deliveryPlaceHodler = "";
    $countries = false;
    $provinces = [];
    $cities = [];
    if(checkLoggedIn() == false || checkPermissions("isSystemUser") == true) {

        $countries = getCountries();
        //    $deliveryMethods = getDeliveryMethods();
        //    if($deliveryMethods !== false){
        //        $deliveryPlaceHodler = "Geen opties beschikbaar";
        //    }

        if ($countries !== false) {
            $provinces = getProvincesByCountry($countries[0]["CountryID"]);

            if ($provinces !== false) {
                $cities = getCitiesByProvince($provinces[0]["StateProvinceID"]);
                if ($cities == false) {
                    $cities = [];
                    $cityPlaceHolder = "Geen opties beschikbaar";
                }
            } else {
                $provinces = [];
                $cities = [];
                $cityPlaceHolder = "Geen opties beschikbaar";
                $provincePlaceHolder = "Geen opties beschikbaar";
            }
        } else {
            $countryPlaceHolder = "Geen opties beschikbaar";
            $provincePlaceHolder = "Geen opties beschikbaar";
            $cityPlaceHolder = "Geen opties beschikbaar";
            $countries = [];
        }

        if (isset($_POST["submitRegister"])) {
            if (isset($_POST["permissions"])) {
                $permissions = $_POST["permissions"];
            }

            $requiredFields = ["firstName" => "Voornaam", "lastName" => "Achternaam", "email" => "E-mail", "password" => "Wachtwoord", "city" => "Stad", "address" => "adres", "zip" => "Postcode"];
            $errorFields = [];
            foreach ($requiredFields as $field => $message) {
                if (!isset($_POST[$field]) || $_POST[$field] == "") {
                    array_push($errorFields, $message);
                }
            }
            if (count($errorFields) !== 0) {
                $errorMessage = "U heeft de volgende velden niet ingevuld: ";
                checkRequiredInput($errorMessage, $errorFields, "alert-danger");
            } else {
                $firstName = $_POST["firstName"];
                $lastName = $_POST["lastName"];
                $password = $_POST["password"];
                $email = $_POST["email"];
                $phoneNumber = $_POST["phoneNumber"];
                $userId = 3255;
                $permissions = null;

                // delivery location and postal location are currently the same
                $deliveryMethod = 3;
                $deliveryLocation = [$_POST["city"], $_POST["address"], $_POST["zip"]];

                if (!validateValuesRegister($password, $email, $phoneNumber)) {
                    $password = password_hash($password, PASSWORD_BCRYPT);
                    register($firstName, $lastName, $password, $email, $phoneNumber, $userId, $deliveryMethod, $deliveryLocation, $permissions);
                }
            }

        }

        require_once "template.php";
    }else{
        header("location: index.php");
    }
