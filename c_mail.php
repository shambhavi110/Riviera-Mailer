<?php
session_start();
if(isset($_SESSION["c_name"])&&isset($_REQUEST["t"]))
{
	require 'sql_con.php';
	$type = $_REQUEST["t"];
	$e = $_REQUEST["e"];
	$msg = $_REQUEST["msg"];
	$sub = $_REQUEST["sub"];
	$to="";
	$comm = "";
	if($_SESSION["c_name"]=="h1")
	{
		$from="hall@vitriviera.com";
		$comm = "Hall Committee";
	}
	if($_SESSION["c_name"]=="p1")
	{
		$from="purchase@vitriviera.com";
		$comm = "Purchases Committee";
	}
	if($_SESSION["c_name"]=="e1")
	{
		$from="events@vitriviera.com";
		$comm = "Events Committee";
	}
	if($_SESSION["c_name"]=="r1")
	{
		$from="registration@vitriviera.com";
		$comm = "Registration Committee";
	}
	$event_name="";
	if($e!="all")
	{
		$event = explode(",",$e);
		for($i=0;$i<count($event);$i++)
		{
			$event_name = $event[$i];
			$to="";
			$id=0;
			$q1 = "SELECT id FROM `events` where event_name='$event[$i]'";
			$r1 =  mysqli_query($mysqli,$q1);
			while($t=mysqli_fetch_array($r1))
			{
				$id=$t[0];
			}
			$q2 = "SELECT mail FROM `event_mail` where  individual_id=$id";
			$r2 =  mysqli_query($mysqli,$q2);
			$t2=mysqli_fetch_array($r2);
			if(is_array($t2))//individual event
			{
				$to = $t2[0];
				
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
				$to = $t4[0];
			}
			//mailing
			$flag=0;
			date_default_timezone_set('Asia/Calcutta');
			require 'PHPMailerAutoload.php';
			
			//Create a new PHPMailer instance
			$mail = new PHPMailer();
			if($mail->smtpConnect())
			{
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
			$mail->Username = $from;

			//Password to use for SMTP authentication
			$mail->Password = "GDGriviera";

			//Set who the message is to be sent from
			$mail->setFrom($from, $comm);

			//Set an alternative reply-to address
			$mail->addReplyTo($from, $comm);

			//Set who the message is to be sent to
			$mail->addAddress($to, $event_name);

			//Set the subject line
			$mail->Subject = $sub;

			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

			//Replace the plain text body with one created manually
			$mail->Body = $msg;

			//send the message, check for errors
			$result=$mail->send();
			if (!$result) 
				{
				echo "Message not sent to $to<br>";
				$flag = 1;
				}
			else
			{
				$host = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
				$mbox = imap_open($host, $from, 'GDGriviera');
				$count = 0;
				if (!$mbox)
				{
					echo "IMAP Connection failed<br>";
				}
				else 
				{
					$dmy=date("d-M-Y H:i:s"); 
					$msg = ("From: $from\r\n" 
					. "To:$to\r\n" 
					. "Date: $dmy\r\n" 
					. "Subject: $sub\r\n"  
					. "$msg\r\n" ); 

				if(!imap_append($mbox,$host,$msg))
					echo "Message not stored in sent box!";
				imap_close($mbox); 
				}
			}
			}
			else
			{
			echo "Connection Failed";
			}
		if($flag==1)
			echo "Message not sent!";
		else
			echo "<h3><center>Message sent!</h3></center>";
		}
	}
	else
	{
			$flag = 0;
			$q = "SELECT mail FROM `event_mail`";
			$r = mysqli_query($mysqli,$q);
			while($t=mysqli_fetch_array($r))
			{
			$to = $t[0];
			date_default_timezone_set('Asia/Calcutta');
			require 'PHPMailerAutoload.php';
			
			//Create a new PHPMailer instance
			$mail = new PHPMailer();
			if($mail->smtpConnect())
			{
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
			$mail->Username = $from;

			//Password to use for SMTP authentication
			$mail->Password = "GDGriviera";

			//Set who the message is to be sent from
			$mail->setFrom($from, $comm);

			//Set an alternative reply-to address
			$mail->addReplyTo($from, $comm);

			//Set who the message is to be sent to
			$mail->addAddress($to, $to);

			//Set the subject line
			$mail->Subject = $sub;

			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

			//Replace the plain text body with one created manually
			$mail->Body = $msg;

			//send the message, check for errors
			$result=$mail->send();
			if (!$result) 
				{
				echo "Message not sent to $to<br>";
				$flag = 1;
				}
			else
			{
			$host = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
			$mbox = imap_open($host, $from, 'GDGriviera');
			$count = 0;
			if (!$mbox) {
				echo "IMAP Connection failed<br>";
			}
			else 
			{
			$dmy=date("d-M-Y H:i:s"); 
			$msg = ("From:$from\r\n" 
			. "To:$to\r\n" 
			. "Date: $dmy\r\n" 
			. "Subject: $sub\r\n"  
			. "$msg\r\n" ); 

			if(!imap_append($mbox,$host,$msg))
				echo "Message not stored in sent box!";

			imap_close($mbox); 
			}
			}
			}
			else{
			echo "Connection Failed";
			}
		}
		if($flag==1)
			echo "Message not sent!";
		else
			echo "<h3><center>Message sent!</h3></center>";
	}
	mysqli_close($mysqli);
}
else if(isset($_SESSION["c_name"])&&!isset($_REQUEST["t"]))
{
	header("Location:c_home.php");
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