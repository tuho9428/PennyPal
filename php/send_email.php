<?php

require 'C:\xampp\htdocs\phpmailer\src\PHPMailer.php'; // phpmailer path
require 'C:\xampp\htdocs\phpmailer\src\Exception.php'; // phpmailer path
require 'C:\xampp\htdocs\phpmailer\src\SMTP.php'; // phpmailer path


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];


    // Instantiate PHPMailer
    $mail = new PHPMailer(true); // Passing `true` enables exceptions

    try {
        //Server settings
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'tuhocoder@gmail.com'; // SMTP username
        $mail->Password = 'nusu jyhm posp czbq'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; // TCP port to connect to

        //Recipients
        $mail->setFrom($email, $name); // Sender's email address and name
        $mail->addAddress('tuhocoder@gmail.com'); // Add recipient email address

        //Content
        $mail->isHTML(false); // Set email format to plain text
        $mail->Subject = 'New Form Submission';
        $mail->Body = "Name: $name\nEmail: $email \nMessage: $message";

        $mail->send(); // Send the email
        // Redirect back to the form if accessed directly
        echo 'Thank you for your submission!';
        header("Location: ../contact.html");
        exit();

    } catch (Exception $e) {
        echo 'Oops! Something went wrong and we couldn\'t send your message.';
        //echo 'Mailer Error: ' . $mail->ErrorInfo; // Uncomment for debugging
    }
} else {
    // Redirect back to the form if accessed directly
    header("Location: contact.html");
    exit();
}
?>
