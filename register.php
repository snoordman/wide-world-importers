<?php
require_once "functions/sql.php";
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

    if(checkUserExists($firstName . " " . $lastName, $email) == false){
        $addUser = addUser($firstName, $lastName, $password, $email, $phoneNumber, $faxNumber, $userId, $permissions);
        if($addUser == true){
            $alertMessage = "Account succesvol aangemaakt";
            header("location: index.php");
            exit;
        }else{
            $alertMessage = "Er is iets mis gegaan, propbeer alstublieft opnieuw";
        }
    };
}

require_once "template.php";
