<?php

if (isset($_POST["submit"])) {

    $name = $_POST['name'];
    $from = 'tuhocoder@gmail.com';
    $to = $_POST['email'];
    $message = $_POST['message'];

    $subject = 'New Message from ' . $name;
    // Build email contentF
    $content = "Name: $name\n\n";
    $content .= "Message:\n$message\n";
    // Set additional headers
    $headers = 'From: ' . $from . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    // Send email
    if (mail($to, $subject, $content, $headers)) {
        echo '<p>Email sent successfully!</p>';
    } else {
        echo '<p>Failed to send email. Please try again later.</p>';
    }
}

?>