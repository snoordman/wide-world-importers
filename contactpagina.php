<?php
    require_once "config.php";
    $viewFile = "viewFile/contactpagina.php";
     $result="";
    if(isset($_POST["submit"])){
        require 'phpmailer/PHPMailerAutoload.php';
        $mail = new phpmailer;
        $mail->Host='smtp.gmail.com';
        $mail->Port='587';
        $mail->SMTPAuth=true;
        $mail->SMTPSecure='tls';
        $mail->Username='testg0930@gmail.com';
        $mail->Password='TestTest123';
        $mail->setFrom($_POST['email']);
        $mail->addAddress('eren-demirhan@live.nl');
        $mail->addReplyTo($_POST['email']);
        $mail->isHTML(true);
        $mail->Subject='Form Submission: ' . $_POST['subject'];
        $mail->Body='<h1 align=center>naam :' . $_POST['naam'] . '<br>Email: '.$_POST['email'].'<br
        >Message: ' . $_POST['message'] . '</h1>';
        if(!$mail->send()){
         $result="Something went wrong. please try again.";

        } else {
            $result="Thanks" . $_POST['naam']."for contacting us. We get back to you soon";

        }






}
require_once "template.php";