<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$mail->SMTPDebug = 4;  // Change to 4 for full debugging
$mail->Debugoutput = 'html';


require '../vendor/autoload.php'; // Load PHPMailer
require 'config.php'; // SMTP configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    if (!$email) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email']);
        exit;
    }

    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = SMTP_PORT;

        // Email content
        $mail->setFrom(SMTP_USER, 'Contact Form');
        $mail->addAddress('odhiambodon123@gmail.com'); // Change to recipient email
        $mail->isHTML(true);
        $mail->Subject = "Contact Form: $subject";
        $mail->Body = "<strong>Name:</strong> $name <br> <strong>Email:</strong> $email <br> <strong>Message:</strong> $message";

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Email sent successfully']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request']);
}
?>
