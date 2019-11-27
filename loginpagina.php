<?php
$viewFile = "viewFile/loginpagina.php";


if(isset($_POST["submitLogin"])){
    $requiredFields = ["email" => "E-mail", "password" => "Wachtwoord"];
    $errors = [];
    foreach ($requiredFields as $field => $message){
        if(!isset($_POST[$field]) || $_POST["password"] == ""){
            array_push($errors, $message);
        }
        if(count($errors) !== 0){

        }
    }
    if(!isset($_POST["email"]) || $_POST["password"] == ""){
        array_push($requiredFields, "E-mail");
    }else if(!isset($_POST["password"]) || $_POST["password"]){
        array_push($requiredFields, "Wachtwoord");
    }else{
        if (!filter_var($f, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }
}

require_once "template.php";
?>