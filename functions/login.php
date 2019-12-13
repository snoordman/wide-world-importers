<?php
require_once "sql.php";

function validateValuesRegister($password, $email, $phoneNumber){
    $alert = false;
    // source regex password
    // https://www.imtiazepu.com/password-validation/
    if(!preg_match("/.*^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/", $password)){
        alert_msg_push("alert-danger", "Ongeldig wachtwoord. Uw wachtwoord moet minimaal 6 karakters lang zijn, een hoofdletter, kleine letter en een cijfer bevatten");
        $alert = true;
    }
    if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
        alert_msg_push("alert-danger", "Ongeldige E-mail. Voer alstublieft een geldig E-mail in");
        $alert = true;
    }

    // source regex password
    // https://regexr.com/3aevr
    if(!preg_match("/^((\+|00(\s|\s?\-\s?)?)31(\s|\s?\-\s?)?(\(0\)[\-\s]?)?|0)[1-9]((\s|\s?\-\s?)?[0-9])((\s|\s?-\s?)?[0-9])((\s|\s?-\s?)?[0-9])\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]$/", $phoneNumber)){
        alert_msg_push("alert-danger", "Ongeldige telefoonnummer. Voer alstublieft een geldig E-mail in");
        $alert = true;
    }

    return $alert;
}

function register($firstName, $lastName, $password, $email, $phoneNumber, $userId, $deliveryMethod, $deliveryLocation, $permissions){
    if(checkUserExists($email) == false){
        $addUser = addUser($firstName, $lastName, $password, $email, $phoneNumber, $userId, $deliveryMethod, $deliveryLocation, $permissions);
        if($addUser == true){
            $alertMessage = "Account succesvol aangemaakt";
            alert_msg_push("alert-success", $alertMessage);
            header("location: loginpagina.php");
            exit;
        }else{
            $alertMessage = "Er is iets mis gegaan, propbeer alstublieft opnieuw";
            alert_msg_push("alert-danger", $alertMessage);
        }
    }else{
        $alertMessage = "E-mail is al in gebruik.";
        alert_msg_push("alert-danger", $alertMessage);
    };

}

function login($email, $password){
    $login = checkValidLogin($email, $password);
    if($login !== false){
        $_SESSION["loggedIn"] = true;
        $_SESSION["permissions"] = ["isSystemUser" => $login["IsSystemUser"], "isEmployee" => $login["IsEmployee"], "isSalesPerson" => $login["IsSalesPerson"]];
        $_SESSION["account"] = ["id" => "PersonID", "name" => $login["PreferredName"], "loginName" => $login["LogonName"]];
        $alertMessage = "U bent succesvol ingelogd";
        alert_msg_push("alert-success", $alertMessage);
        header("Location: index.php");
        exit;
    }else{
        $alertMessage = "Verkeerd wachtwoord of email. Probeer alstublieft opnieuw.";
        alert_msg_push("alert-danger", $alertMessage);
    }
}
