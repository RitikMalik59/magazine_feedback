<?php
include "../config/db_connect.php";

/**
 * This example shows how to send a message to a whole list of recipients efficiently.
 */

//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Hashids\Hashids;

error_reporting(E_STRICT | E_ALL);

date_default_timezone_set('Asia/Kolkata');

require '../vendor/autoload.php';

//Passing `true` enables PHPMailer exceptions
$mail = new PHPMailer(true);

// $body = file_get_contents('contents.html');

//Server settings
// $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output

$mail->isSMTP();
$mail->Host = SMTP_HOST;
$mail->SMTPAuth = SMTP_AUTH;
$mail->SMTPKeepAlive = true; //SMTP connection will not close after each email sent, reduces SMTP overhead
$mail->Port = SMTP_PORT;
$mail->Username = SMTP_USERNAME;
$mail->Password = SMTP_PASSWORD;
$mail->setFrom('list@example.com', 'List manager');
$mail->addReplyTo('list@example.com', 'List manager');
$mail->addCustomHeader(
    'List-Unsubscribe',
    '<mailto:unsubscribes@example.com>, <https://www.example.com/unsubscribe.php>'
);
$mail->isHTML(true);
$mail->Subject = 'PHPMailer Simple database mailing list test';

//Same body for all messages, so set this before the sending loop
//If you generate a different body for each recipient (e.g. you're using a templating system),
//set it inside the loop
// $mail->msgHTML($body);
//msgHTML also sets AltBody, but if you want a custom one, set it afterwards
// $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

//Connect to the database and select the recipients from your mailing list that have not yet been sent to
//You'll need to alter this to match your database
$set_limit = 3;
$query = "SELECT * FROM old_records WHERE is_email_sent = ? LIMIT $set_limit";
$stmt = $connection->prepare($query);
$stmt->execute([0]);
$row_count = $stmt->rowCount();

if ($row_count > 0) {
    $result = $stmt->fetchAll();

    foreach ($result as $row) {
        $id = $row['id'] ?? '';
        $name = $row['name'] ?? '';
        $designation = $row['designation'] ?? '';
        $company = $row['company'] ?? '';
        $phone = $row['phone'] ?? '';
        $email = $row['email'] ?? '';

        // hashing URL ID for security
        $hashids = new Hashids('', 15);
        $id = $hashids->encode($id); // o2fXhV
        $feedback_url = 'http://localhost/magazine_feedback/index.php?_id=' . $id;
        // $numbers = $hashids->decode($id); // [1, 2, 3]

        $body = '<!DOCTYPE html>
        <html>
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
        
                .container {
                    max-width: 600px;
                    margin: 20px auto;
                    background-color: #ffffff;
                    padding: 20px;
                    border: 1px solid #dddddd;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }
        
                .header {
                    text-align: center;
                    background-color: #007BFF;
                    color: #ffffff;
                    padding: 10px 0;
                    border-top-left-radius: 5px;
                    border-top-right-radius: 5px;
                }
        
                .content {
                    margin: 20px 0;
                    line-height: 1.6;
                    color: #333333;
                }
        
                .feedback-link {
                    display: inline-block;
                    margin: 20px 0;
                    padding: 15px 25px;
                    background-color: #28a745;
                    color: #ffffff;
                    text-decoration: none;
                    border-radius: 5px;
                    font-size: 18px;
                    transition: background-color 0.3s;
                }
        
                .feedback-link:hover {
                    background-color: #218838;
                }
        
                .footer {
                    text-align: center;
                    font-size: 14px;
                    color: #777777;
                    margin-top: 30px;
                    padding-top: 20px;
                    border-top: 1px solid #dddddd;
                }
        
                .footer a {
                    color: #007BFF;
                    text-decoration: none;
                }
        
                .footer a:hover {
                    text-decoration: underline;
                }
        
                .logo {
                    text-align: center;
                    margin-bottom: 20px;
                }
        
                .logo img {
                    max-width: 100px;
                }
            </style>
        </head>
        
        <body>
            <div class="container">
                <div class="header">
                    <h1>Your Feedback Matters!</h1>
                </div>
                <div class="content">
                    <p>Dear ' . $name . ',</p>
                    <p>We hope you are enjoying our magazine and finding it informative and engaging. We are always striving to improve and would love to hear your thoughts.</p>
                    <p>Please take a moment to provide your feedback by clicking the link below:</p>
                    <p><a href="' . $feedback_url . '" class="feedback-link">Give Feedback</a></p>
                    <p>Thank you for your time and support!</p>
                    <p>Best regards,<br>The Magazine Team</p>
                </div>
                <div class="footer">
                    &copy; 2024 The Magazine. All rights reserved.<br>
                    If you no longer wish to receive these emails, please <a href="https://example.com/unsubscribe">unsubscribe</a>.
                </div>
            </div>
        </body>
        
        </html>';

        try {

            $mail->addAddress($email, $name);

            //If you generate a different body for each recipient (e.g. you're using a templating system),
            //set it inside the loop
            // $body = "Hello, $name your email is $email and is id : $id";
            $mail->msgHTML($body);
            //msgHTML also sets AltBody, but if you want a custom one, set it afterwards
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
        } catch (Exception $e) {
            echo 'Invalid address skipped: ' . htmlspecialchars($email) . '<br>';
            continue;
        }
        // if (!empty($row['photo'])) {
        //     //Assumes the image data is stored in the DB
        //     $mail->addStringAttachment($row['photo'], 'YourPhoto.jpg');
        // }
        $mail->replaceCustomHeader(
            'List-Unsubscribe',
            '<mailto:unsubscribes@example.com>, <https://www.example.com/unsubscribe.php?email=' .
            rawurlencode($email) . '>'
        );

        try {
            $mail->send();
            echo 'Message sent to :' . htmlspecialchars($row['name']) . ' (' .
            htmlspecialchars($email) . ')<br>';

            //Mark it as sent in the DB
            $is_email_sent = 1;

            // set is_email_sent in database to 1 when email sent successfully
            // so that email is sent only once
            if ($is_email_sent) {
                $query = "UPDATE old_records SET is_email_sent=? WHERE id=?";
                $stmt = $connection->prepare($query);
                $stmt->execute([$is_email_sent, $id]);
                $row_count = $stmt->rowCount();
            }
        } catch (Exception $e) {
            echo 'Mailer Error (' . htmlspecialchars($email) . ') ' . $mail->ErrorInfo . '<br>';
            //Reset the connection to abort sending this message
            //The loop will continue trying to send to the rest of the list
            $mail->getSMTPInstance()->reset();
        }
        //Clear all addresses and attachments for the next iteration
        $mail->clearAddresses();
        $mail->clearAttachments();
        sleep(1);
    }
}
