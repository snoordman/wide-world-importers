<?php

require_once "config.php";
    $viewFile = "viewFile/contactpagina.php";




    $result="";
    $resultfail="";
    if(isset($_POST["submit"])) {
        require "PHPMailer/PHPMailer/PHPMailerAutoload.php";
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Username = "testg0930@gmail.com";
        $mail->Password = "TestTest123";

        $mail->setFrom($_POST["email"], $_POST["naam"], $_POST["typevraag"]);
        $mail->addAddress("erendemirhan66@gmail.com");
        $mail->isHTML(true);
        $mail ->Subject= "Vraag";
        $mail->Body = '<h1 align=center>naam :' . $_POST['naam'] . '<br>Email: ' . $_POST["email"] . '<br>Type vraag: ' . $_POST["typevraag"] . '<br
        >Message: ' . $_POST["message"] . '</h1>';
        if ($mail->send()) {
            $result = "Bedankt! " . $_POST["naam"] . " We zullen uw vraag zo spoedig mogelijk beantwoorden";

        } else {
            $resultfail = "Er is iets fout gegaan, probeer het opnieuw.";

        try {
            $mail->setFrom($_POST["email"], $_POST["naam"]);
        } catch (phpmailerException $e) {
            var_dump($e);
            $result = "Er is iets fout gegaan, probeer het opnieuw.";
            require_once "template.php";
            die;
        }
        $mail->addAddress("erendemirhan66@gmail.com");
        $mail->isHTML(true);
        $mail ->Subject= "Vraag";
        $mail->Body = '<h1 align=center>naam :' . $_POST['naam'] . '<br>Email: ' . $_POST["email"] . '<br>Message: ' . $_POST["message"] . '</h1>';
        try {
            $mail->send();
            $result = "Bedankt! " . $_POST["naam"] . " We zullen uw vraag zo spoedig mogelijk beantwoorden";
        } catch (phpmailerException $e) {
            var_dump($e);
            $result = "Er is iets fout gegaan, probeer het opnieuw.";
            require_once "template.php";
            die;

        }


    }
    }
        require_once "template.php";
