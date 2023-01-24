<?php
if (isset($_POST['Email'])) {

    $email_to = "marisakbrantley@gmail.com";
    $email_subject = "Let's Connect";

    function problem($error)
    {
        echo "There were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br><br>";
        echo $error . "<br><br>";
        echo "Please go back and fix these errors so we can connect.<br><br>";
        die();
    }

    // validation expected data exists
    if (
        !isset($_POST['First Name']) ||
        !isset($_POST['Last Name']) ||
        !isset($_POST['Email']) ||
        !isset($_POST['Message'])
    ) {
        problem('Oops. There seems to be a problem with the form you submitted.');
    }

    $first_name = $_POST['First Name']; // required
    $last_name = $_POST['Last Name']; // required
    $email = $_POST['Email']; // required
    $message = $_POST['Message']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= "The Email address you entered doesn't seem to be valid.<br>";
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $first_name)) {
        $error_message .= 'The First Name you entered does not appear to be valid.<br>';
    }
    if (!preg_match($string_exp, $last_name)) {
        $error_message .= 'The Last Name you entered does not appear to be valid.<br>';
    }

    if (strlen($message) < 2) {
        $error_message .= 'The Message you entered do not appear to be valid.<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }

    $email_message = "Form details below.\n\n";

    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "First Name: " . clean_string($first_name) . "\n";
    $email_message .= "Last Name: " . clean_string($last_name) . "\n";
    $email_message .= "Email: " . clean_string($email) . "\n";
    $email_message .= "Message: " . clean_string($message) . "\n";

    // create email headers
    $headers = 'From: ' . $email . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);
?>

    <!-- INCLUDE YOUR SUCCESS MESSAGE BELOW -->

    Thank you so much for your message! I'll be in touch with you soon.

<?php
}
?>