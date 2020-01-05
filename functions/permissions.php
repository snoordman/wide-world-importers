<?php
    // functie om te kijken of gebruiker voldoet aan bebpaalde rechten
    function checkPermissions($permissionRank){
        // kijk of de checkLoggedIn functie true is en de session permissions een array bevat met de index $permissionRank en die 1 is
        if(checkLoggedIn() == true && isset($_SESSION["permissions"][$permissionRank]) && $_SESSION["permissions"][$permissionRank] == 1){
            return true;
        }else{
            return false;
        }
    }

    // functie om te kijken of de gebruiker ingelogd is
    function checkLoggedIn(){
        // kijk of session loggedIn is gezet en de loggedIn session true is
        if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true){
            return true;
        }else{
            return false;
        }
    }