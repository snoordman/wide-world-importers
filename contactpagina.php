<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "config.php";
    $viewFile = "viewFile/contactpagina.php";




    $result="";
    $resultfail="";
    if(isset($_POST["submit"])) {
        require 'PHPMailer/PHPMailer/Exception.php';
        require 'PHPMailer/PHPMailer/PHPMailer.php';
        require 'PHPMailer/PHPMailer/SMTP.php';


        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->SMTPDebug = 2;

        $mail->Host = gethostbyname('smtp.gmail.com');
        $mail->SMTPAuth   = true;

        $mail->Username = "erendemirhan66@gmail.com";
        $mail->Password = "TestTest123";

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->Port = 587;


        try {
            $mail->setFrom($_POST["email"], $_POST["naam"], $_POST["typevraag"]);
        } catch (Exception $e) {
            $sendMail = false;
        }


        try {
            $mail->addAddress("erendemirhan66@gmail.com");
        } catch (Exception $e) {
            $sendMail = false;
        }


        $mail->isHTML(true);
        $mail->Subject = "Vraag";
        $mail->Body = '<h1 align=center>naam :' . $_POST['naam'] . '<br>Email: ' . $_POST["email"] . '<br>Type vraag: ' . $_POST["typevraag"] . '<br
        >Message: ' . $_POST["message"] . '</h1>';


        try {
            $sendMail = $mail->send();
        } catch (Exception $e) {
            $sendMail = false;
        }
        if ($sendMail) {
            $result = "Bedankt! " . $_POST["naam"] . " We zullen uw vraag zo spoedig mogelijk beantwoorden";

        } else {
            $resultfail = "Er is iets fout gegaan, probeer het opnieuw.";

        }

    }
        require_once "template.php";
