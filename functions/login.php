<?php
require_once "sql.php";

// functie die checkt voor geldige waardes
function validateValuesRegister($password, $email, $phoneNumber){
    // variable om te kijken of er een alert is gezet. Standaardt false
    $alert = false;

    // reguliere expressie om te kijken of het wachtwoord voldoet aan een kleine letter een hoofdletter en een cijfer
    // zo niet zet dan een alert message en zet alert op true
    // voor uitleg over de regex ga naar https://regex101.com/r/yX8GXG/1

    // source regex password
    // https://www.imtiazepu.com/password-validation/
    if(!preg_match("/.*^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/", $password)){
        alert_msg_push("alert-danger", "Ongeldig wachtwoord. Uw wachtwoord moet minimaal 6 karakters lang zijn, een hoofdletter, kleine letter en een cijfer bevatten");
        $alert = true;
    }

    // reguliere expressie om te kjiken of het email geldig is
    // zo niet zet dan een alert message en zet alert op true
    if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
        alert_msg_push("alert-danger", "Ongeldige E-mail. Voer alstublieft een geldig E-mail in");
        $alert = true;
    }

    // requliere expressie om te kijken of het telefoonnumemr geldig is
    // voor uitleg over rexeg ga naar https://regex101.com/r/16PqqB/1
    // source regex password
    // https://regexr.com/3aevr
    if(!preg_match("/^((\+|00(\s|\s?\-\s?)?)31(\s|\s?\-\s?)?(\(0\)[\-\s]?)?|0)[1-9]((\s|\s?\-\s?)?[0-9])((\s|\s?-\s?)?[0-9])((\s|\s?-\s?)?[0-9])\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]$/", $phoneNumber)){
        alert_msg_push("alert-danger", "Ongeldige telefoonnummer. Voer alstublieft een geldig E-mail in");
        $alert = true;
    }

    return $alert;
}

// register functie
function register($firstName, $lastName, $password, $email, $phoneNumber, $userId, $deliveryMethod, $deliveryLocation, $permissions){
    // kijk of de email al in gebruik zo ja zet een alert
    if(!checkUserExists($email)){
        // maak de fullname van firstname en lastname
        $fullName = $firstName . " " . $lastName;
        // kijk of de fullname al bestaat zo ja zet een alert
        if(!checkNameExists($fullName)){
            // voer de functie uit voor het toevoegen van een gebruiker
            // kijk of de functie true teruggeeft, zoja zet een success alert en stuur de gebruiker door naar de home pagina.
            // als dit niet zo is zet dan een alert dat het mis is gegaan
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
            $alertMessage = "Naam en achternaam zijn al in gebruik";
            alert_msg_push("alert-danger", $alertMessage);
        }
    }else{
        $alertMessage = "E-mail is al in gebruik.";
        alert_msg_push("alert-danger", $alertMessage);
    };

}

// functie voor het inloggen
function login($email, $password){
    // kijk of de login geldig is
    // als dit zo is zet dan de sessions voor de ingelogde persoon, zet een alert dat het goed is
    // gegaan en stuur de gebruiker naar de homepagina
    // als dit niet is zet dan een alert
    $login = checkValidLogin($email, $password);
    if($login !== false){
        $_SESSION["loggedIn"] = true;
        $_SESSION["permissions"] = ["isSystemUser" => $login["IsSystemUser"], "isEmployee" => $login["IsEmployee"], "isSalesPerson" => $login["IsSalesPerson"]];
        $_SESSION["account"] = ["id" => $login["PersonID"], "name" => $login["PreferredName"], "loginName" => $login["LogonName"]];
        $alertMessage = "U bent succesvol ingelogd";
        alert_msg_push("alert-success", $alertMessage);
        header("Location: index.php");
        exit;
    }else{
        $alertMessage = "Verkeerd wachtwoord of email. Probeer alstublieft opnieuw.";
        alert_msg_push("alert-danger", $alertMessage);
    }
}
