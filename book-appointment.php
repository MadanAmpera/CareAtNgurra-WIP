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
        header("Location: book-appointment.html?email_sent=success");
        exit();
    } else {
        header("Location: book-appointment.html?email_sent=fail");
        exit();
    }
}

?>


