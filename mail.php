<?php
session_start();
if(isset($_SESSION["ec_name"])&&isset($_REQUEST["id"]))
{
	require 'sql_con.php';
	$id = $_REQUEST["id"];
	$name = $_POST["name"];
	$message = $_REQUEST["msg"];
	$ph = $_REQUEST["ph"];
	$subject = $_REQUEST["sub"];
	$reg = $_SESSION["ec_name"];
	$message="From : ".$name." ( ".$reg." ) "."\nPhone no: ".$ph."\n".$message;
	$event_name="";
	$to="";
	$comm = $_REQUEST["type"];
	if($_REQUEST["type"]=="Hall Committee")
		$to="hall@vitriviera.com";
	if($_REQUEST["type"]=="Purchases Committee")
		$to="purchase@vitriviera.com";
	if($_REQUEST["type"]=="Events Committee")
		$to="events@vitriviera.com";
	if($_REQUEST["type"]=="Register Committee")
		$to="registration@vitriviera.com";
	$q = "SELECT event_name FROM events WHERE id=$id";
	$r = mysqli_query($mysqli,$q);
	while($t=mysqli_fetch_array($r))
	{
		$event_name=$t[0];
	}
	
	$event_name=str_replace("_"," ",$event_name);
	
	$event_mail="";
	$q2 = "SELECT mail FROM `event_mail` where  individual_id=$id";
	$r2 =  mysqli_query($mysqli,$q2);
	$t2=mysqli_fetch_array($r2);
	if(is_array($t2))//individual event
	{
		$event_mail = $t2[0];
	}
	else//club event
	{
		$c_id=0;
		$q3 = "SELECT`club_id` FROM `clubs_maps_event_ids` WHERE `event_id`=$id";
		$r3 =  mysqli_query($mysqli,$q3);
		$t3=mysqli_fetch_array($r3);
		$c_id = $t3[0];
		$q4 = "SELECT mail FROM `event_mail` where  club_id=$c_id";
		$r4=  mysqli_query($mysqli,$q4);
		$t4=mysqli_fetch_array($r4);
		$event_mail = $t4[0];
	}
	date_default_timezone_set('Asia/Calcutta');
require 'PHPMailerAutoload.php';
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
$mail->setFrom('noreply@vitriviera.com',$event_name);

//Set an alternative reply-to address
$mail->addReplyTo($event_mail, $event_name);

//Set who the message is to be sent to
$mail->addAddress($to, $comm);

//$mail->AddBCC("noreply@vitriviera.com", "Sent Mail");

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
$host = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
$user = 'noreply@vitriviera.com';
$password = 'GDGpass123';
$mbox = imap_open($host, $user, $password);
$count = 0;
if (!$mbox) {
      echo "IMAP Error";
    }
    else 
    {
    $dmy=date("d-M-Y H:i:s"); 

    $msg = ("From: $event_mail\r\n" 
        . "To: $to\r\n" 
        . "Date: $dmy\r\n" 
        . "Subject: $subject\r\n"  
        . "Message: $message\r\n" ); 

    if(imap_append($mbox,$host,$msg))
    echo "<h3><center>Message sent!</h3></center>";
    else
    echo "<h3><center>Message not sent!</h3></center>";

    imap_close($mbox); 
    }

}
}
else{
    echo "Connection Failed";
}
	mysqli_close($mysqli);
}
else if(isset($_SESSION["ec_name"])&&!isset($_REQUEST["id"]))
{
	header("Location:ec_home.php");
}
else
{
	session_unset();
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	session_destroy();
	header("Location:login.php");
	exit();
}
?>