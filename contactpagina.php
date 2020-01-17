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


        $mail = new PHPMailer();

        $mail->isSMTP();

        $mail->SMTPAuth = true;// Enable SMTP authentication
        $mail->SMTPSecure = 'tls';// Enable TLS encryption, `ssl` also accepted

        $mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
        $mail->Port = 587;// TCP port to connect to
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->Username = "erendemirhan66@gmail.com";
        $mail->Password = "TestTest123";

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
            alert_msg_push("alert-success", "Bedankt! " . $_POST["naam"] . " We zullen uw vraag zo spoedig mogelijk beantwoorden");
            header("location: contactpagina.php");
            exit;
        } else {
            alert_msg_push("alert-danger", "Er is iets fout gegaan, probeer het opnieuw.");
            header("location: contactpagina.php");
            exit;
        }
    }
    require_once "template.php";
