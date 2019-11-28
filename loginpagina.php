<?php
    require_once "config.php";
    $viewFile = "viewFile/loginpagina.php";


    if(isset($_POST["submitLogin"])){
        $requiredFields = ["logonName" => "E-mail", "password" => "Wachtwoord"];
        $errorFields = [];
        $errors = [];
        foreach ($requiredFields as $field => $message){
            if(!isset($_POST[$field]) || $_POST[$field] == ""){
                array_push($errorFields, $message);
            }
        }
        if(count($errorFields) !== 0){
            $errorMessage = "U heeft de volgende velden niet ingevuld: ";
            for($i = 0; $i < count($errorFields); $i++){
                $errorMessage = $errorMessage . $errorFields[$i];
                if($i !== count($errorFields) - 1){
                    $errorMessage = $errorMessage . ", ";
                }
            }
            $errors = [$errorMessage];
        }else{
            login($_POST["email"], $_POST["password"]);
        }

    }

    require_once "template.php";
?>