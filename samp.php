<?php
date_default_timezone_set('Asia/Calcutta');
require 'PHPMailerAutoload.php';
$to= "shambhavi110@gmail.com";
$subject= "test";
$message= "test";
//Create a new PHPMailer instance
$mail = new PHPMailer();
if($mail->smtpConnect()){

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'mail.gmail.com';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "noreply@vitriviera.com";

//Password to use for SMTP authentication
$mail->Password = "GDGpass123";

//Set who the message is to be sent from
$mail->setFrom('noreply@vitriviera.com', 'GDG');

//Set an alternative reply-to address
$mail->addReplyTo('noreply@vitriviera.com', 'GDG');

//Set who the message is to be sent to
$mail->addAddress($to, 'Shambhavi');

$mail->AddBCC("noreply@vitriviera.com", "Sent Mail");

//Set the subject line
$mail->Subject = $subject;

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

//Replace the plain text body with one created manually
$mail->Body = $message;

//send the message, check for errors
$result=$mail->send();
if (!$result) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
}
else{
    echo "Connection Failed";
}
?>
