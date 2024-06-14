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

$adminEmail = 'admin@test.com';

if (isset($_REQUEST['id'])) {

    $id = $_REQUEST['id'];

    $query = "SELECT * FROM feedback WHERE id = ?";
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
        $answer_1 = $data['answer_1'] ?? '';
        $answer_2 = $data['answer_2'] ?? '';
        $answer_3 = $data['answer_3'] ?? '';
        $answer_4 = $data['answer_4'] ?? '';
        $answer_5 = $data['answer_5'] ?? '';
        $answer_6 = $data['answer_6'] ?? '';
        $is_email_sent = $data['is_email_sent'];

        // $body = include "./test.php";
        $user_email_body = file_get_contents('user_email.php');
        $user_email = $email;
        $admin_email = 'admin@gmail.com';
        // $admin_email_body = file_get_contents('admin_email.php');
        $admin_email_body =
        '<!doctype html>
        <html lang="en">
        
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title> Feedback Email</title>
            <style media="all" type="text/css">
                /* -------------------------------------
            GLOBAL RESETS
        ------------------------------------- */
        
                body {
                    font-family: Helvetica, sans-serif;
                    -webkit-font-smoothing: antialiased;
                    font-size: 16px;
                    line-height: 1.3;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%;
                }
        
                table {
                    border-collapse: separate;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                    width: 100%;
                }
        
                table td {
                    font-family: Helvetica, sans-serif;
                    font-size: 16px;
                    vertical-align: top;
                }
        
                /* -------------------------------------
            BODY & CONTAINER
        ------------------------------------- */
        
                body {
                    background-color: #f4f5f6;
                    margin: 0;
                    padding: 0;
                }
        
                .body {
                    background-color: #f4f5f6;
                    width: 100%;
                }
        
                .container {
                    margin: 0 auto !important;
                    max-width: 700px;
                    padding: 0;
                    padding-top: 20px;
                    padding-bottom: 50px;
                    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                    width: 700px;
                }
        
                .content {
                    box-sizing: border-box;
                    display: block;
                    margin: 0 auto;
                    max-width: 700px;
                    padding: 0;
                }
        
                /* -------------------------------------
            HEADER, FOOTER, MAIN
        ------------------------------------- */
        
                .main {
                    background: #ffffff;
                    border: 1px solid #eaebed;
                    border-radius: 16px;
                    width: 100%;
                }
        
                .wrapper {
                    box-sizing: border-box;
                    padding: 24px;
                }
        
                .footer {
                    clear: both;
                    padding-top: 24px;
                    text-align: center;
                    width: 100%;
                }
        
                .footer td,
                .footer p,
                .footer span,
                .footer a {
                    color: #9a9ea6;
                    font-size: 16px;
                    text-align: center;
                }
        
                /* -------------------------------------
            TYPOGRAPHY
        ------------------------------------- */
        
                p {
                    font-family: Helvetica, sans-serif;
                    font-size: 16px;
                    font-weight: normal;
                    margin: 0;
                    margin-bottom: 16px;
                }
        
                a {
                    color: #0867ec;
                    text-decoration: underline;
                }
        
                /* -------------------------------------
            BUTTONS
        ------------------------------------- */
        
                .btn {
                    box-sizing: border-box;
                    min-width: 100% !important;
                    width: 100%;
                }
        
                .btn>tbody>tr>td {
                    padding-bottom: 16px;
                }
        
                .btn table {
                    width: auto;
                }
        
                .btn table td {
                    background-color: #ffffff;
                    border-radius: 4px;
                    text-align: center;
                }
        
                .btn a {
                    background-color: #ffffff;
                    border: solid 2px #0867ec;
                    border-radius: 4px;
                    box-sizing: border-box;
                    color: #0867ec;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 16px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 24px;
                    text-decoration: none;
                    text-transform: capitalize;
                }
        
                .btn-primary table td {
                    background-color: #0867ec;
                }
        
                .btn-primary a {
                    background-color: #0867ec;
                    border-color: #0867ec;
                    color: #ffffff;
                }
        
                @media all {
                    .btn-primary table td:hover {
                        background-color: #ec0867 !important;
                    }
        
                    .btn-primary a:hover {
                        background-color: #ec0867 !important;
                        border-color: #ec0867 !important;
                    }
                }
        
                /* -------------------------------------
            OTHER STYLES THAT MIGHT BE USEFUL
        ------------------------------------- */
        
                .last {
                    margin-bottom: 0;
                }
        
                .first {
                    margin-top: 0;
                }
        
                .align-center {
                    text-align: center;
                }
        
                .align-right {
                    text-align: right;
                }
        
                .align-left {
                    text-align: left;
                }
        
                .text-link {
                    color: #0867ec !important;
                    text-decoration: underline !important;
                }
        
                .clear {
                    clear: both;
                }
        
                .mt0 {
                    margin-top: 0;
                }
        
                .mb0 {
                    margin-bottom: 0;
                }
        
                .text-center {
                    text-align: center !important;
                }
        
                .pt-1 {
                    padding-top: 0.25rem !important;
                }
        
                .pb-1 {
                    padding-bottom: 0.25rem !important;
                }
        
                .bg-secondary-subtle {
                    background-color: #e2e3e5 !important;
                }
        
                .mt-5 {
                    margin-top: 3rem !important;
                }
        
                .preheader {
                    color: transparent;
                    display: none;
                    height: 0;
                    max-height: 0;
                    max-width: 0;
                    opacity: 0;
                    overflow: hidden;
                    mso-hide: all;
                    visibility: hidden;
                    width: 0;
                }
        
                .powered-by a {
                    text-decoration: none;
                }
        
                /* -------------------------------------
            RESPONSIVE AND MOBILE FRIENDLY STYLES
        ------------------------------------- */
        
                @media only screen and (max-width: 640px) {
        
                    .main p,
                    .main td,
                    .main span {
                        font-size: 16px !important;
                    }
        
                    .wrapper {
                        padding: 8px !important;
                    }
        
                    .content {
                        padding: 0 !important;
                    }
        
                    .container {
                        padding: 0 !important;
                        padding-top: 8px !important;
                        width: 100% !important;
                    }
        
                    .main {
                        border-left-width: 0 !important;
                        border-radius: 0 !important;
                        border-right-width: 0 !important;
                    }
        
                    .btn table {
                        max-width: 100% !important;
                        width: 100% !important;
                    }
        
                    .btn a {
                        font-size: 16px !important;
                        max-width: 100% !important;
                        width: 100% !important;
                    }
                }
        
                /* -------------------------------------
            PRESERVE THESE STYLES IN THE HEAD
        ------------------------------------- */
        
                @media all {
                    .ExternalClass {
                        width: 100%;
                    }
        
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                        line-height: 100%;
                    }
        
                    .apple-link a {
                        color: inherit !important;
                        font-family: inherit !important;
                        font-size: inherit !important;
                        font-weight: inherit !important;
                        line-height: inherit !important;
                        text-decoration: none !important;
                    }
        
                    #MessageViewBody a {
                        color: inherit;
                        text-decoration: none;
                        font-size: inherit;
                        font-family: inherit;
                        font-weight: inherit;
                        line-height: inherit;
                    }
                }
            </style>
        </head>
        
        <body>
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
                <tr>
                    <td>&nbsp;</td>
                    <td class="container">
                        <div class="content">
        
                            <!-- START CENTERED WHITE CONTAINER -->
                            <span class="preheader">This is preheader text. Some clients will show this text as a preview.</span>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="main">
        
                                <!-- START MAIN CONTENT AREA -->
                                <tr>
                                    <td class="wrapper">
                                        <h1>' . $name . ' just submitted a feedback </h1>
        
                                        <H3 class="text-center  bg-secondary-subtle pb-1 pt-1">Personal Information</H3>
        
                                        <p><b>Name : </b> ' . $name . '</p>
                                        <p><b>Designation : </b> ' . $designation . '</p>
                                        <p><b>Company </b>: ' . $company . '</p>
                                        <p><b>Phone : </b>' . $phone . '</p>
                                        <p><b>Email : </b>' . $email . '</p>
        
                                        <H3 class="text-center  bg-secondary-subtle pb-1 pt-1">Feedback Questions</H3>
        
                                        <p><b>Q1. Which Topic did you find most interesting to read from May issue ? *</b></p>
                                        <p><b>Ans :</b> ' . $answer_1 . '/p>
                                        <p><b>Q2. Which section in the magazine, is the most interesting read for you ?*</b></p>
                                        <p><b>Ans :</b> ' . $answer_2 . '</p>
                                        <p><b>Q3. Have you Purchased / Plan to Purchase any products listed in the magazine ? *</b></p>
                                        <p><b>Ans :</b> ' . $answer_3 . '</p>
                                        <p><b>Q4. Which Company Ads did you find interesting ? *</b></p>
                                        <p><b>Ans :</b> ' . $answer_4 . ' </p>
                                        <p><b>Q5. Any additional suggestions / feedback regarding the overall content ? *</b></p>
                                        <p><b>Ans :</b> ' . $answer_5 . '</p>
                                        <p><b>Q6. Do mention the topics you would like to read in future issues ? *</b></p>
                                        <p><b>Ans :</b> ' . $answer_6 . ' </p>
        
                                        <!--<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                            <tbody>
                                                <tr>
                                                    <td align="left">
                                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td> <a href="https://visgroup.com/" target="_blank">Vis Group</a> </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> -->
                                    </td>
                                </tr>
        
                                <!-- END MAIN CONTENT AREA -->
                            </table>
        
                            <!-- START FOOTER -->
                            <div class="footer">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="content-block">
                                            <span class="apple-link">VIRTUAL INFO SYSTEMS PVT LTD
                                                2nd Floor, 204,205,206, Techno IT Park, New Link Road, Boriwali West, Thane, Maharashtra, 400092</span>
                                            <!-- <br> Don\'t like these emails? <a href="http://htmlemail.io/blog">Unsubscribe</a>. -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block powered-by">
                                            Email Us <a href="mailto:keerthana@visgroup.com">keerthana@visgroup.com</a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
        
                            <!-- END FOOTER -->
        
                            <!-- END CENTERED WHITE CONTAINER -->
                        </div>
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </body>
        
        </html>';

        var_dump($data);
        echo '<br>';



        if ($is_email_sent === 0) {
            echo 'send email';

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
                // clear addresses
                $mail->clearAddresses();
                $mail->setFrom('fromAdmin@example.com', 'Mailer');         // Set sender of the mail
                $mail->addAddress($user_email, $name);     //Add a recipient
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
                $mail->Body    = $user_email_body;
                // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            // Admin Email
            try {
                //Recipients
                // clear addresses
                $mail->clearAddresses();
                $mail->setFrom('fromAdmin@example.com', 'Mailer');         // Set sender of the mail
                $mail->addAddress($admin_email, $name);     //Add a recipient
                // $mail->addAddress('ellen@example.com');               //Name is optional
                // $mail->addReplyTo('info@example.com', 'Information');
                $mail->addCC('cc2@example.com');
                // $mail->addBCC('bcc@example.com');

                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $name . ' submitted magazine feedback';
                $mail->Body    = $admin_email_body;
                // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            // die();
        } else {
            echo 'exit code';
        }
    }
    // echo $name . '<br>';


}
