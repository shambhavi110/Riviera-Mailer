<?php
	session_start();
	if(isset($_SESSION["ec_name"])&&isset($_REQUEST["id"]))
	{
		$event_id = $_REQUEST["id"];
		echo "<br><input type='button' value='Hall Committee' onclick= 'form_mail($event_id,this.value)' style='position:absolute;top:50px;left:10px;width:160px;height:40px;border:none;color:white;background-color:#177bbb;'><br>
			<input type='button' value='Purchases Committee' onclick='form_mail($event_id,this.value)' style='position:absolute;top:50px;left:180px;width:160px;height:40px;border:none;color:white;background-color:#177bbb;'><br>
			<input type='button' value='Events Committee' onclick='form_mail($event_id,this.value)' style='position:absolute;top:50px;left:350px;width:160px;height:40px;border:none;color:white;background-color:#177bbb;'><br>
			<input type='button' value='Register Committee' onclick='form_mail($event_id,this.value)' style='position:absolute;top:50px;left:520px;width:160px;height:40px;border:none;color:white;background-color:#177bbb;'><br>
		<div id ='form'></div>";
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