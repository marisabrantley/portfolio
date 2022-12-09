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


// ***********
// LICENSE KEY
// ***********
define('KEY', 'FREE');


// *********************
// FORM FIELD VALIDATION
// *********************
$validate = array(
   "Name" => "NOT_EMPTY,1,100",
   "Email" => "EMAIL,1,100",
   "Message" => "NOT_EMPTY,1,3000"
);


// ******************
// FORM FIELD MAPPING
// ******************
$mapping = array(
   "Name" => "Your name",
   "Email" => "Your email address",
   "Message" => "Your message"
);


// **************************
// EMAIL TEMPLATES - INCOMING
// **************************
define('EMAIL_TEMPLATE_IN_HTML', 'fcf.email-in.htm');
define('EMAIL_TEMPLATE_IN_TEXT', 'fcf.email-in.txt');


// *******************************
// EMAIL TEMPLATES - AUTO-RESPONSE
// *******************************
define('EMAIL_TEMPLATE_OUT_HTML', 'fcf.email-out.htm');
define('EMAIL_TEMPLATE_OUT_TEXT', 'fcf.email-out.txt');

define('SEND_AUTO_RESPONSE', 'NO'); // YES OR NO
define('EMAIL_OUT_SUBJECT', '');
define('EMAIL_OUT_TO', 'FIELD:Email');
define('EMAIL_OUT_TO_NAME', 'FIELD:Name');
define('EMAIL_OUT_FROM', '');
define('EMAIL_OUT_FROM_NAME', '');


// *************
// EMAIL MESSAGE
// *************
define('EMAIL_TO', 'marisakbrantley@gmail.com');
define('EMAIL_TO_NAME', 'Marisa Brantley');

define('EMAIL_TO_CC', '');
define('EMAIL_TO_CC_NAME', '');

define('EMAIL_TO_BCC', '');
define('EMAIL_TO_BCC_NAME', '');

define('EMAIL_FROM', 'marisakbrantley@gmail.com');
define('EMAIL_FROM_NAME', '');

define('EMAIL_REPLY_TO', 'FIELD:Email');
define('EMAIL_REPLY_TO_NAME', 'FIELD:Email');

define('EMAIL_SUBJECT_BEFORE', '');
define('EMAIL_SUBJECT', "New contact form message");
define('EMAIL_SUBJECT_AFTER', '');



// ***************
// EMAIL TRANSPORT
// ***************
define('USE_SMTP', 'NO'); // YES or NO
define('SMTP_HOST', '');
define('SMTP_USER', '');
define('SMTP_PASS', '');
define('SMTP_AUTH', '');
define('SMTP_SECURE', ''); // STARTTLS, SMTPS (port 465) or empty
define('SMTP_PORT', '');
define('SMTP_DEBUG', 'NO'); // YES or NO



// **************************
//    DON'T CHANGE BELOW
// USED FOR VALIDATION CHECKS
// **************************
define('A', 'Rm9ybSBwcm92aWRlZCBieSB3d3cuZnJlZWNvbnRhY3Rmb3JtLmNvbQ==');
define('B', 'Rm9ybSBwcm92aWRlZCBieSA8YSBocmVmPSJodHRwczovL3d3dy5mcmVlY29udGFjdGZvcm0uY29tIj5GcmVlQ29udGFjdEZvcm0uY29tPC9hPg==');
define('C', 'Rm9ybSBwcm92aWRlZCBieSA8YSBocmVmPSJodHRwczovL3d3dy5mcmVlY29udGFjdGZvcm0uY29tIiB0YXJnZXQ9Il9ibGFuayI+RnJlZUNvbnRhY3RGb3JtLmNvbTwvYT4=');
define('D', 'Y29uZ3JhdHVsYXRpb25zIGZvciBiZWluZyBjbGV2ZXIh');
define('E', 'OGZlR3dSYkh3MjhGbg==');
define('F', 'RlJFRQ==');