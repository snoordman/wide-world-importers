<?php
function validateValuesRegister(){

}

function register($fullName, $firstName, $password, $email, $phoneNumber, $faxNumber){
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
