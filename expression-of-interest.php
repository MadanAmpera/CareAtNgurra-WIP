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

    $to = 'sbaidwan@careatngurra.com.au';
    $headers = 'From: careatng@careatngurra.com.au';

    if (mail($to, $subject, $mail_body, $headers)) {

        //send email to applicant.
        $applicant_email_headers = 'From: info@careatngurra.com.au';
        $applicant_email_subject = 'Thank You for Reaching Out to Care at Ngurra.';

        $applicant_email_body = <<<EOD
        Dear $eoi_first_name,

        Thank you for your interest in careers at Care at Ngurra. We appreciate you taking the time to express your interest.

        Our team will review your application and respond shortly. 
        
        Warm regards,
        The Care at Ngurra Team
        EOD;

        mail($eoi_email, $applicant_email_subject, $applicant_email_body, $applicant_email_headers);

        header("Location: careers.html?response=success");
        
    } else {
        header("Location: careers.html?response=false");
        
    }

    exit();
}

?>


