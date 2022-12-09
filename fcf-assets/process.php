<?php
// ************************************
// This file is part of a package from:
// www.majesticform.com

// Free Version
// 2 January 2022

// You are free to use an edit for 
// your own use. But cannot resell
// or repackage in any way.
// ************************************


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$lk = KEY;

// *******************
// CHECK CONFIGURATION
// *******************
checkConfigurationExists();

$expected_fields_check = checkFieldsExist($validate);

if($expected_fields_check != "") {
    $message = "Fields passed from the form don't match the configured ones.";
    $message .= "<ul>".$expected_fields_check."</ul>";
    exitFail($message);
}


// *******************
// VALIDATE THE FIELDS
// *******************
validateFields($validate, $mapping);


// ************
// CREATE EMAIL
// ************
$ss = cs();

require dirname(__FILE__).'/'.'classes/Exception.php';
require dirname(__FILE__).'/'.'classes/PHPMailer.php';
require dirname(__FILE__).'/'.'classes/SMTP.php';

$mail = new PHPMailer(true);

try {
    
    if(strtoupper(SMTP_DEBUG) == "YES") {
        echo "Debug:<br>";
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    } 
    
    if (strtoupper(USE_SMTP) == "YES") {

        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->Port = SMTP_PORT;

        if (strtoupper(SMTP_AUTH) == "YES") {

            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            switch(SMTP_SECURE) {
                case "STARTTLS":
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                break;

                case "SMTPS":
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                break;
            }

        } else {
            $mail->SMTPAuth = false;
            $mail->SMTPAutoTLS = false;
        }
    } else {
        $mail->isMail();
    }

    // EMAIL FROM
    $email_from = EMAIL_FROM;
    if(useField($email_from)) {
        $email_from = getField($email_from);
    }
    $email_from_name = EMAIL_FROM_NAME;
    if(useField($email_from_name)) {
        $email_from_name = getField($email_from_name);
    }

    // validate email address
    if(!PHPMailer::validateAddress($email_from)) {
        exitError("Email address FROM is invalid");
    }

    if($email_from_name == "") {
        $mail->setFrom($email_from);
    } else {
        $mail->setFrom($email_from, $email_from_name);
    }

    // EMAIL REPLY TO
    $email_reply_to = EMAIL_REPLY_TO;
    if(useField($email_reply_to)) {
        $email_reply_to = getField($email_reply_to);
    }
    $email_reply_to_name = EMAIL_REPLY_TO_NAME;
    if(useField($email_reply_to_name)) {
        $email_reply_to_name = getField($email_reply_to_name);
    }

    // validate email address
    if(!PHPMailer::validateAddress($email_reply_to)) {
        exitError("Email address REPLY TO is invalid");
    }

    if($email_reply_to_name == "") {
        if($email_reply_to != "") {
            $mail->addReplyTo($email_reply_to);
        }
    } else {
        if($email_reply_to != "") {
            $mail->addReplyTo($email_reply_to, $email_reply_to_name);
        }
    }

    // EMAIL TO
    if(isMultiple(EMAIL_TO)) {
        $email_to_list = getMultiple(EMAIL_TO);
    } else {
        $email_to_list[0] = EMAIL_TO;
    }

    if(isMultiple(EMAIL_TO_NAME)) {
        $email_to_name_list = getMultiple(EMAIL_TO_NAME);
    } else {
        $email_to_name_list[0] = EMAIL_TO_NAME;
    }

    for($i=0; $i < count($email_to_list); $i++) {
        if(itemExistWithValue($email_to_name_list, $i)) {

            // validate email address
            if(!PHPMailer::validateAddress($email_to_list[$i])) {
                exitFail("Email address EMAIL TO is invalid");
            }
            
            $mail->addAddress($email_to_list[$i], $email_to_name_list[$i]);
        } else {

            // validate email address
            if(!PHPMailer::validateAddress($email_to_list[$i])) {
                exitFail("Email address EMAIL TO is invalid");
            }

            $mail->addAddress($email_to_list[$i]);
        }
    }

    // EMAIL TO CC
    if(isMultiple(EMAIL_TO_CC)) {
        $email_to_cc_list = getMultiple(EMAIL_TO_CC);
    } else {
        $email_to_cc_list[0] = EMAIL_TO_CC;
    }

    if(isMultiple(EMAIL_TO_CC_NAME)) {
        $email_to_cc_name_list = getMultiple(EMAIL_TO_CC_NAME);
    } else {
        $email_to_cc_name_list[0] = EMAIL_TO_CC_NAME;
    }

    for($i=0; $i < count($email_to_cc_list); $i++) {
        if(itemExistWithValue($email_to_cc_name_list, $i)) {

            // validate email address
            if(!PHPMailer::validateAddress($email_to_cc_list[$i])) {
                exitFail("Email address EMAIL TO CC is invalid");
            }

            $mail->addCC($email_to_cc_list[$i], $email_to_cc_name_list[$i]);
        } else {
            if(itemExistWithValue($email_to_cc_list, $i)) {

                // validate email address
                if(!PHPMailer::validateAddress($email_to_cc_list[$i])) {
                    exitFail("Email address EMAIL TO CC is invalid");
                }
                
                $mail->addCC($email_to_cc_list[$i]);
            }
        }
    }

    // EMAIL TO BCC
    if(isMultiple(EMAIL_TO_BCC)) {
        $email_to_bcc_list = getMultiple(EMAIL_TO_BCC);
    } else {
        $email_to_bcc_list[0] = EMAIL_TO_BCC;
    }

    if(isMultiple(EMAIL_TO_BCC_NAME)) {
        $email_to_bcc_name_list = getMultiple(EMAIL_TO_BCC_NAME);
    } else {
        $email_to_bcc_name_list[0] = EMAIL_TO_BCC_NAME;
    }

    for($i=0; $i < count($email_to_bcc_list); $i++) {
        if(itemExistWithValue($email_to_bcc_name_list, $i)) {

            // validate email address
            if(!PHPMailer::validateAddress($email_to_bcc_list[$i])) {
                exitFail("Email address EMAIL TO BCC is invalid");
            }

            $mail->addBCC($email_to_bcc_list[$i], $email_to_bcc_name_list[$i]);
        } else {
            if(itemExistWithValue($email_to_bcc_list, $i)) {

                // validate email address
                if(!PHPMailer::validateAddress($email_to_bcc_list[$i])) {
                    exitFail("Email address EMAIL TO BCC is invalid");
                }
                
                $mail->addBCC($email_to_bcc_list[$i]);
            }
        }
    }

    $email_subject = EMAIL_SUBJECT;
    if(useField($email_subject)) {
        $email_subject = getField($email_subject);
    }

    $mail->Subject = trim(EMAIL_SUBJECT_BEFORE." ".$email_subject ." ".EMAIL_SUBJECT_AFTER);

    $mail->isHTML(true); 
    $mail->Body = getHtmlBody(1);
    $mail->AltBody = getPlainBody(1);

    $mail->send();

    if(strtoupper(SMTP_DEBUG) == "YES") {
        echo $mail->ErrorInfo;
    }

    // send the auto-response
    if(SEND_AUTO_RESPONSE == "YES") {
        $mail->clearAddresses();
        $mail->clearAttachments();
        $mail->Subject = EMAIL_OUT_SUBJECT;
        
        $email_out_to = EMAIL_OUT_TO;
        if(useField($email_out_to)) {
            $email_out_to = getField($email_out_to);
        }
        $email_out_to_name = EMAIL_OUT_TO_NAME;
        if(useField($email_out_to_name)) {
            $email_out_to_name = getField($email_out_to_name);
        }
        $mail->addAddress($email_out_to, $email_out_to_name);

        $mail->setFrom(EMAIL_OUT_FROM, EMAIL_OUT_FROM_NAME);

        $body_out = getAutoResponseContent();
        $mail->Body = $body_out["html"];
        $mail->AltBody = $body_out["text"];

        $mail->send();
    }

    if(strtoupper(SMTP_DEBUG) == "YES") {
        $message = $mail->ErrorInfo;
        exitFail($message);
    }

    isSuccess();

} catch (Exception $e) {
    if(strtoupper(SMTP_DEBUG) == "YES") {
        $message = $mail->ErrorInfo;
        exitFail($message);
    } else {
        exitFail("There is a problem sending the email. Please try later.");
    }
}


// ***********************
// EMAIL CONTENT FUNCTIONS
// ***********************
function getHtmlBody($score) {
    return getEmailBody($score, 'htm');
}

function getPlainBody($score) {
    return getEmailBody($score, 'txt');
}

function getEmailBody($score, $type) {
    if($type=="htm") {
        $ss = "b";
        $body = file_get_contents('./email-templates/'.EMAIL_TEMPLATE_IN_HTML);
    }  else {
        $ss = "a"; 
        $body = file_get_contents('./email-templates/'.EMAIL_TEMPLATE_IN_TEXT);
    }
    foreach($_POST as $field => $value) {
        if(is_array($value)) {
            $value = implode(", ",$value);
        }
        $field_to_find = "{".$field."}";
        if($type=="htm") {
            $field_to_replace = nl2br(htmlspecialchars($value),false);
        }  else {
            $field_to_replace = $value;
        }
        $body = str_replace($field_to_find, $field_to_replace, $body);
    }
    $body = str_replace(array('{IP}','{SCORE}'), array(getUserIp(),$score), $body);
    return str_replace('{CREDIT}', getSsValue($ss), $body);
}

function getAutoResponseContent() {
    $html = file_get_contents('./email-templates/'.EMAIL_TEMPLATE_OUT_HTML);
    $text = file_get_contents('./email-templates/'.EMAIL_TEMPLATE_OUT_TEXT);
    foreach($_POST as $field => $value) {
        if(is_array($value)) {
            $value = implode(", ",$value);
        }
        $field_to_find = "{".$field."}";
        $html = str_replace($field_to_find, nl2br(htmlspecialchars($value),false), $html);
        $text = str_replace($field_to_find, $value, $text);
    }
    $html = str_replace('{EMAIL_OUT_FROM_NAME}', EMAIL_OUT_FROM_NAME, $html);
    $text = str_replace('{EMAIL_OUT_FROM_NAME}', EMAIL_OUT_FROM_NAME, $text);
    return array(
        "html" => $html,
        "text" => $text
    );
}


// ********************
// SUPPORTING FUNCTIONS
// ********************
function checkConfigurationExists() {
    if(!defined('EMAIL_TO') || 
        !defined('A') || 
        !defined('B') || 
        !defined('C') || 
        !defined('D') || 
        !defined('F')) {
        exitFail("Form configuration is not available.");
    }
}

function checkFieldsExist($form_fields) {
    $returnstring = "";
    foreach($form_fields as $field => $type) {
        if(!isset($_POST[$field])) {
            $returnstring .= "<li>Field with name '".$field."' is missing.</li>";
        }
    }
    return $returnstring;
}

function validateFields($form_fields, $mapping) {

    require dirname(__FILE__).'/classes/FormValidate.php';

    $validate = new FormValidate;
    
    foreach($form_fields as $field => $type) {
        $display_name = getDisplayName($field, $mapping);
        
        $vals = '';
        if(isset($_POST[$field])) {
            $vals = $_POST[$field];
        }
        $validate->validate($field, $display_name, $vals, $type);
        
    }
    
    if($validate->anyErrors()) {
        $message =  "<ul>".$validate->getErrorString()."</ul>";
        exitError($message);
    }
}


function getDisplayName($name, $mapping) {
    if(!isset($mapping[$name])) {
        exitFail("Problem with field mapping in configuration.");
    }
    return stripslashes($mapping[$name]);
}

function useField($value) {
    if(substr($value,0,6) == "FIELD:") {
        return true;
    }
    return false;
}

function getField($value) {
    $field = explode(":", $value);
    return $_POST[$field[1]];
}

function isMultiple($value) {
    $fields = explode(",", $value);
    if(count($fields) > 1) {
        return true;
    }
    return false;
}

function getMultiple($values) {
    $fields = explode(",", $values);
    return array_map('trim', $fields);
}

function itemExistWithValue($element, $index) {
    if(isset($element[$index]) && trim($element[$index]) != "") {
        return true;
    }
    return false;
}

function exitFail($message) {
    echo "Fail:".$message;
    exit();
}

function exitError($message) {
    echo "Error:".$message;
    exit();
}

function getUserIp() {
    $ip = getenv('HTTP_CLIENT_IP')?:
    getenv('HTTP_X_FORWARDED_FOR')?:
    getenv('HTTP_X_FORWARDED')?:
    getenv('HTTP_FORWARDED_FOR')?:
    getenv('HTTP_FORWARDED')?:
    getenv('REMOTE_ADDR');
    if(trim($ip) == "") {
        return "Unavailable";
    }
    return $ip;
}

function isSuccess() {
    if(strtoupper(SMTP_DEBUG) == "YES") {
        exit();
    }
    echo base64_decode("U3VjY2Vzcy4=").getSsValue("c");
    exit();
}

function getSsValue($i) {
    global $ss;
    if(substr($ss[$i],0,2) != 'Y2') {
        return base64_decode($ss[$i]);
    }
    return "";
}


if (strlen($lk) < 4) {
    scf(1);
}
function scf($n) {
    exitFail("Security check failure ($n)");
}
function cs() {
    global $lk;
    if (abc($lk)) {
        return array("a" => A, "b" => B, "c" => C);
    }
    if (cba($lk)) {
        return array("a" => D, "b" => D, "c" => D);
    }
    scf(2);
}
function abc($f) {
    if (strtoupper($f) == base64_decode(F)) {
        return true;
    }
    return false;
}
function cba($h) {
    if (substr($h, 4, 13) == base64_decode(E)) {
        return true;
    }
    return false;
}