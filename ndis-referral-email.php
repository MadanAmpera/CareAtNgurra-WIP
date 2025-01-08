<?php

//Email 1: To team at Care at Ngurra

//client info
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $recaptcha_secret = '6LeKQbAqAAAAALbviKo24Ivtm5ura3pYgn6hlwnN';
    $recaptcha_response = $_POST['g-recaptcha-response'];
    //checking the captcha
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
    $response_keys = json_decode($response, true);

    if (intval($response_keys["success"]) !== 1) {
        header("Location: ndis-referral.html?response=captcha-fail");
    }
    else{

        $client_name = isset($_POST['client-name']) ? htmlspecialchars($_POST['client-name']) : '';
        $client_dob = isset($_POST['client-dob']) ? htmlspecialchars($_POST['client-dob']) : '';
        $client_gender = isset($_POST['client-gender']) ? htmlspecialchars($_POST['client-gender']) : '';
        $client_ndis_number = isset($_POST['client-ndis-number']) ? htmlspecialchars($_POST['client-ndis-number']) : '';
        $plan_from_date = isset($_POST['plan-from-date']) ? htmlspecialchars($_POST['plan-from-date']) : '';
        $plan_to_date = isset($_POST['plan-to-date']) ? htmlspecialchars($_POST['plan-to-date']) : '';
        $client_address = isset($_POST['client-address']) ? htmlspecialchars($_POST['client-address']) : '';
        $client_phone_number = isset($_POST['client-phone-number']) ? htmlspecialchars($_POST['client-phone-number']) : '';
        $client_email = isset($_POST['client-email']) ? htmlspecialchars($_POST['client-email']) : '';
        $client_cultural_background = isset($_POST['client-cultural-background']) ? htmlspecialchars($_POST['client-cultural-background']) : '';
        $client_disability = isset($_POST['client-disability']) ? htmlspecialchars($_POST['client-disability']) : '';
        $risks_involved = isset($_POST['risks-involved']) ? htmlspecialchars($_POST['risks-involved']) : '';
        $risks_identified = isset($_POST['risks-identified']) ? htmlspecialchars($_POST['risks-identified']) : '';


        //Referral Details

        $client_has_ndis_plan = isset($_POST['client-has-ndis-plan']) ? htmlspecialchars($_POST['client-has-ndis-plan']) : '';
        $copy_provided = isset($_POST['copy-provided']) ? htmlspecialchars($_POST['copy-provided']) : '';
        $ndis_support_needed = isset($_POST['ndis-support-needed']) ? htmlspecialchars($_POST['ndis-support-needed']) : '';
        $support_areas = isset($_POST['support-areas']) ? htmlspecialchars($_POST['support-areas']) : '';
        $in_home_support = isset($_POST['in-home-support']) ? htmlspecialchars($_POST['in-home-support']) : '';
        $mentor_gender = isset($_POST['mentor-gender']) ? htmlspecialchars($_POST['mentor-gender']) : '';
        $mentoring = isset($_POST['mentoring']) ? htmlspecialchars($_POST['mentoring']) : '';
        $staff_gender_preference = isset($_POST['staff-gender-preference']) ? htmlspecialchars($_POST['staff-gender-preference']) : '';
        $staff_cultural_preference = isset($_POST['staff-cultural-preference']) ? htmlspecialchars($_POST['staff-cultural-preference']) : '';

        //Household members

        $household_names = isset($_POST['household-member-name']) ? $_POST['household-member-name'] : [];
        $household_genders = isset($_POST['household-member-gender']) ? $_POST['household-member-gender'] : [];
        $household_DOBs = isset($_POST['household-member-DOB']) ? $_POST['household-member-DOB'] : [];

        //Referer Details

        $referrer_name = isset($_POST['referrer-name']) ? htmlspecialchars($_POST['referrer-name']) : '';
        $referrer_position = isset($_POST['referrer-position']) ? htmlspecialchars($_POST['referrer-position']) : '';
        $referrer_organization = isset($_POST['referrer-organization']) ? htmlspecialchars($_POST['referrer-organization']) : '';
        $referrer_address = isset($_POST['referrer-address']) ? htmlspecialchars($_POST['referrer-address']) : '';
        $referrer_phone = isset($_POST['referrer-phone']) ? htmlspecialchars($_POST['referrer-phone']) : '';
        $referrer_email = isset($_POST['referrer-email']) ? htmlspecialchars($_POST['referrer-email']) : '';
        $referral_date = isset($_POST['referral-date']) ? htmlspecialchars($_POST['referral-date']) : '';


        $subject = "NDIS Referral Form";

        $client_information_body = <<<EOD
        Name: $client_name
        Date of Birth: $client_dob
        Gender: $client_gender
        NDIS Number: $client_ndis_number
        Plan Dates
        From: $plan_from_date - To: $plan_to_date
        Address: $client_address
        Phone: $client_phone_number
        Email: $client_email
        Cultural Background: $client_cultural_background
        Nature of Disability/Diagnosis: $client_disability
        Are there any risks that Care at Ngurra need to be aware of?: $risks_involved
        Risks Identified: $risks_identified
        EOD;

        $referral_details_body = <<<EOD
        Does the client currently have a NDIS Plan?: $client_has_ndis_plan
        Has a copy of the NDIS Plan been provided along with this referral?: $copy_provided
        Does the client need support getting an NDIS Plan?: $ndis_support_needed
        Does the client require particular support in any of the following areas?: $support_areas
        In Home Support: $in_home_support
        Mentoring: $mentoring - Mentor Gender Preference: $mentor_gender
        Staff Preference: $staff_gender_preference
        Staff cultural background preference: $staff_gender_preference
        EOD;

        //compiling household members list

        for ($i = 0; $i < count($household_names); $i++) {
            $household_members .= "Member " . ($i + 1) . "\n";
            $household_members .= "Full Name " . $household_names[$i] . "\n";
            $household_members .= "DOB: " . $household_dob[$i] . "\n";
            $household_members .= "Gender: " . $household_genders[$i] . "\n\n";
        }

        $referrer_details_body = <<<EOD
        Name: $referrer_name
        Position: $referrer_position
        Organization: $referrer_organization
        Address: $referrer_address
        Phone: $referrer_phone
        Email: $referrer_email
        Date: $referral_date
        EOD;

        //Compiling the email

        $mail_body .= "NDIS REFERRAL FORM\n\n";
        $mail_body .= "CLIENT INFORMATION\n" . $client_information_body . "\n\n";
        $mail_body .= "REFERRAL DETAILS\n" . $referral_details_body . "\n\n";

        if(!empty($household_members)){
            $mail_body .= "MEMBERS OF THE HOUSEHOLD\n" . $household_members . "\n\n";
        }

        $mail_body .= "REFERRER DETAILS\n" . $referrer_details_body . "\n";

        $to = 'info@careatngurra.com.au';
        $headers = 'From: careatng@careatngurra.com.au';

        if (mail($to, $subject, $mail_body, $headers)) {

            //send emails to referrer and client.
            $client_referrer_email_headers = 'From: info@careatngurra.com.au';
            $client_referrer_email_subject = 'Thank You for Reaching Out to Care at Ngurra.';
            
            $client_email_body = <<<EOD
            Dear $client_name,

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

            mail($client_email, $client_referrer_email_subject, $client_email_body, $client_referrer_email_headers);

            $referrer_email_body = <<<EOD
            Dear $referrer_name,

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

            mail($referrer_email, $client_referrer_email_subject, $referrer_email_body, $client_referrer_email_headers);
            
            header("Location: ndis-referral.html?response=success");
            
        } else {
            header("Location: ndis-referral.html?response=fail");
        }
    }

    exit();
}

?>


