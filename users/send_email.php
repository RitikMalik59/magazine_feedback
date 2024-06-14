<?php

include "../config/db_connect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require 'path/to/PHPMailer/src/Exception.php';
// require 'path/to/PHPMailer/src/PHPMailer.php';
// require 'path/to/PHPMailer/src/SMTP.php';

//Load Composer's autoloader
require '../vendor/autoload.php';

if (isset($_REQUEST['id'])) {

    $id = $_REQUEST['id'];

    $query = "SELECT name, designation, company, phone, email FROM feedback WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->execute([$id]);
    $row_count = $stmt->rowCount();


    if ($row_count > 0) {

        $row = $stmt->fetchAll();
        $data = $row[0];

        $name = $data['name'] ?? '';
        $designation = $data['designation'] ?? '';
        $company = $data['company'] ?? '';
        $phone = $data['phone'] ?? '';
        $email = $data['email'] ?? '';

        // $body = include "./test.php";
        $body = file_get_contents('user_email.php');

        // var_dump($data);
    }
    // echo $name . '<br>';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'sandbox.smtp.mailtrap.io';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'e2fecd3ce9e387';                     //SMTP username
        $mail->Password   = '33b49ee5f22ede';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('fromAdmin@example.com', 'Mailer');         // Set sender of the mail
        $mail->addAddress($email, $name);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Thank you for your feedback';
        $mail->Body    = $body;
        // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
