<?php
include "../config/db_connect.php";

/**
 * This example shows how to send a message to a whole list of recipients efficiently.
 */

//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_STRICT | E_ALL);

date_default_timezone_set('Asia/Kolkata');

require '../vendor/autoload.php';

//Passing `true` enables PHPMailer exceptions
$mail = new PHPMailer(true);

// $body = file_get_contents('contents.html');

//Server settings
$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output

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
// $mysql = mysqli_connect('localhost', 'username', 'password');
// mysqli_select_db($mysql, 'mydb');
// $result = mysqli_query($mysql, 'SELECT full_name, email, photo FROM mailinglist WHERE sent = FALSE');
$set_limit = 3;
$query = "SELECT * FROM old_records WHERE is_email_sent = ? LIMIT $set_limit";
$stmt = $connection->prepare($query);
$stmt->execute([0]);
$row_count = $stmt->rowCount();

if ($row_count > 0) {
    $result = $stmt->fetchAll();

    // var_dump($result);
    // echo '<br>' . $row_count . '<br>';
    // die();
    foreach ($result as $row) {
        $id = $row['id'] ?? '';
        $name = $row['name'] ?? '';
        $designation = $row['designation'] ?? '';
        $company = $row['company'] ?? '';
        $phone = $row['phone'] ?? '';
        $email = $row['email'] ?? '';
        try {
            $mail->addAddress($row['email'], $row['name']);

            //Same body for all messages, so set this before the sending loop
            //If you generate a different body for each recipient (e.g. you're using a templating system),
            //set it inside the loop
            $body = "Hello, $name your email is $email and is id : $id";
            $mail->msgHTML($body);
            //msgHTML also sets AltBody, but if you want a custom one, set it afterwards
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
        } catch (Exception $e) {
            echo 'Invalid address skipped: ' . htmlspecialchars($row['email']) . '<br>';
            continue;
        }
        // if (!empty($row['photo'])) {
        //     //Assumes the image data is stored in the DB
        //     $mail->addStringAttachment($row['photo'], 'YourPhoto.jpg');
        // }
        $mail->replaceCustomHeader(
            'List-Unsubscribe',
            '<mailto:unsubscribes@example.com>, <https://www.example.com/unsubscribe.php?email=' .
                rawurlencode($row['email']) . '>'
        );

        try {
            $mail->send();
            echo 'Message sent to :' . htmlspecialchars($row['name']) . ' (' .
                htmlspecialchars($row['email']) . ')<br>';
            //Mark it as sent in the DB
            // mysqli_query(
            //     $mysql,
            //     "UPDATE mailinglist SET sent = TRUE WHERE email = '" .
            //         mysqli_real_escape_string($mysql, $row['email']) . "'"
            // );

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
            echo 'Mailer Error (' . htmlspecialchars($row['email']) . ') ' . $mail->ErrorInfo . '<br>';
            //Reset the connection to abort sending this message
            //The loop will continue trying to send to the rest of the list
            $mail->getSMTPInstance()->reset();
        }
        //Clear all addresses and attachments for the next iteration
        $mail->clearAddresses();
        $mail->clearAttachments();
    }
}
