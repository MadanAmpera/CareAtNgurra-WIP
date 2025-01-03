<?php

//client info
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $appointment_ndis_service = isset($_POST['ndis-service']) ? htmlspecialchars($_POST['ndis-service']) : '';
    $appointment_date = isset($_POST['appointment-date']) ? htmlspecialchars($_POST['appointment-date']) : '';
    $appointment_email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $appointment_name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $appointment_phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
    $appointment_description = isset($_POST['description']) ? htmlspecialchars($_POST['plan-to-date']) : '';

    $subject = "Appointment";

    $mail_body = <<<EOD
    Select Service: $appointment_ndis_service
    Date of Appointment: $appointment_date
    Email: $appointment_email
    Name: $appointment_name
    Phone: $appointment_phone
    Description: $appointment_description
    EOD;

    $to = 'info@careatngurra.com.au';
    $headers = 'From: careatng@careatngurra.com.au';

    if (mail($to, $subject, $mail_body, $headers)) {

        //send emails to referrer and client.
        $client_email_headers = 'From: info@careatngurra.com.au';
        $client_email_subject = 'Thank You for Reaching Out to Care at Ngurra.';
        
        $client_email_body = <<<EOD
        Dear $appointment_name,

        Thank you for contacting Care at Ngurra. We appreciate you taking the time to reach out and share your needs with us.

        At Care at Ngurra, we are committed to providing personalized support services tailored to help individuals achieve their NDIS goals. Whether it’s assistance with travel, personal needs, daily tasks, or participating in community activities, our team is here to support you every step of the way.

        Our dedicated team will review your query and respond with detailed information shortly. If you have any urgent questions or would like to speak with us directly, feel free to contact us at:

        Mobile: 0475 245 338
        Landline: 1800 648 772
        Email: info@careatngurra.com.au
        In the meantime, you can learn more about our services on our website: www.careatngurra.com.au.

        We look forward to assisting you on your journey towards independence and empowerment.

        Warm regards,
        The Care at Ngurra Team
        EOD;

        mail($appointment_email, $client_email_subject, $client_email_body, $client_email_headers);

        header("Location: book-appointment.html?email_sent=success");
        
    } else {
        header("Location: book-appointment.html?email_sent=fail");
    }

    exit();
}

?>