<?php
require_once "sql.php";

function validateValuesRegister($password, $email, $phoneNumber){
    $alert = false;
    // source regex password
    // https://www.imtiazepu.com/password-validation/
    if(!preg_match("/.*^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/", $password)){
        alert_msg_push("alert-danger", "Ongeldig wachtwoord. Uw wachtwoord moet minimaal 6 karakters lang zijn, een hoofdletter en een kleine letter bevatten");
        $alert = true;
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        alert_msg_push("alert-danger", "Ongeldige E-mail. Voer alstublieft een geldig E-mail in");
        $alert = true;
    }
    if(!preg_match($phoneNumber, "/(^(\+{1}\d{0,3}\s?)?((\d+)+(\-?\d+)+)$)|(^\-{1}$)/")){
        alert_msg_push("alert-danger", "Ongeldige telefoonnummer. Voer alstublieft een geldig E-mail in");
        $alert = true;
    }

    return $alert;
}

function register($firstName, $lastName, $password, $email, $phoneNumber, $faxNumber, $userId, $permissions){
    if(!validateValuesRegister($password, $email, $phoneNumber)){
        if(checkUserExists($email) == false){
            $addUser = addUser($firstName, $lastName, $password, $email, $phoneNumber, $faxNumber, $userId, $permissions);
            if($addUser == true){
                $alertMessage = "Account succesvol aangemaakt";
                alert_msg_push("alert-success", $alertMessage);
                header("location: login.php");
                exit;
            }else{
                $alertMessage = "Er is iets mis gegaan, propbeer alstublieft opnieuw";
                alert_msg_push("alert-success", $alertMessage);
            }
        }else{
            $alertMessage = "E-mail is al in gebruik.";
            alert_msg_push("alert-danger", $alertMessage);
        };
    }

}

function login($email, $password){
    if(false !== $login = checkValidLogin($email, $password)){
        $_SESSION["loggedIn"] = true;
        $_SESSION["permissions"] = ["isSystemUser" => $login["IsSystemUser"], "isEmployee" => $login["IsEmployee"], "isSalesPerson" => $login["IsSalesPerson"]];
        $alertMessage = "U bent succesvol ingelogd";
        alert_msg_push("alert-success", $alertMessage);
        header("Location: index.php");
        exit;
    }else{
        $alertMessage = "Verkeerd wachtwoord of email. Probeer alstublieft opnieuw.";
        alert_msg_push("alert-danger", $alertMessage);
    }
}