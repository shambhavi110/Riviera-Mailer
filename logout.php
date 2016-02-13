<?php
	//Logout - all session variables are destroyed and directs it to login page
	session_start();
	session_unset();
	session_destroy();
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	header("Location:login.php");
	exit();
?>