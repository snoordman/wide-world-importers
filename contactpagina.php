<?php

require_once "config.php";
    $viewFile = "viewFile/contactpagina.php";




    $result="";
    $resultfail="";
    if(isset($_POST["submit"])) {
        require "PHPMailer/PHPMailer/PHPMailerAutoload.php";
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;

        $mail->Port = 587;
        $mail->SMTPSecure = "tls";
        $mail->Username = "erendemirhan66@gmail.com";
        $mail->Password = "TestTest123";

        try {
            $mail->setFrom($_POST["email"], $_POST["naam"], $_POST["typevraag"]);
        } catch (phpmailerException $e) {
            var_dump($e);
            exit;
        }
        $mail->addAddress("erendemirhan66@gmail.com");
        $mail->isHTML(true);
        $mail->Subject = "Vraag";
        $mail->Body = '<h1 align=center>naam :' . $_POST['naam'] . '<br>Email: ' . $_POST["email"] . '<br>Type vraag: ' . $_POST["typevraag"] . '<br
        >Message: ' . $_POST["message"] . '</h1>';
        try {
            if ($mail->send()) {
                $result = "Bedankt! " . $_POST["naam"] . " We zullen uw vraag zo spoedig mogelijk beantwoorden";

            } else {
                $resultfail = "Er is iets fout gegaan, probeer het opnieuw.";

            }
        } catch (phpmailerException $e) {
            echo "Error 2";
            echo "<br />";
            echo "<br />";
            echo "<br />";
            var_dump($e);
            exit;
        }
    }
        require_once "template.php";
