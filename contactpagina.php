<?php
    require_once "config.php";
    $viewFile = "viewFile/contactpagina.php";

    if(isset($_POST["submit"])){
        $naam=$_POST["naam"];
        $email=$_POST["email"];
        $message=$_POST["message"];
        $to='eren-demirhan@live.nl';
        $subject='Form Submission';
        $message="Name:" . $naam. "\n" . "email:" . $email . "\n" . "heeft het volgende bericht gestuurd:" . "\n" . "\n" . $message;
        $headers="From " . $email;

        if(mail($to, $subject, $message, $headers)){
            echo "<h1>Mail is verzonden!" . $naam . ", U krijgt zo snel mogelijk te horen van ons</h1>";
        }else{
            echo "Er is iets mis gegaan";
        }

    }


    require_once "template.php";
?>