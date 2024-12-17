<?php

//client info
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $eoi_first_name = isset($_POST['first-name']) ? htmlspecialchars($_POST['first-name']) : '';
    $eoi_last_name = isset($_POST['last-name']) ? htmlspecialchars($_POST['last-name']) : '';
    $eoi_contact_number = isset($_POST['contact-number']) ? htmlspecialchars($_POST['contact-number']) : '';
    $eoi_email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $eoi_message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';
    
    $subject = "Careers - Expression of Interest";

    $mail_body = <<<EOD
    First Name: $eoi_first_name
    Last Name: $eoi_last_name
    Contact Number: $eoi_contact_number
    Email: $eoi_email
    Message: $eoi_message
    EOD;

    $to = 'info@careatngurra.com.au';
    $headers = 'From: careatng@careatngurra.com.au';

    if (mail($to, $subject, $mail_body, $headers)) {
        header("Location: careers.html?email_sent=success");
        exit();
    } else {
        header("Location: careers.html?email_sent=false");
        exit();
    }
}

?>


