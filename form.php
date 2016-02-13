<?php
	session_start();
	if(isset($_SESSION["ec_name"])&&isset($_REQUEST["id"]))
	{
		
		$event_id = $_REQUEST["id"];
		$type = $_REQUEST["type"];
		echo "<h3 style='position:absolute;top:100px;left:200px;font-weight:normal;'>$type</h3>";
		echo "<br><h3 style='font-weight:normal;position:absolute;top:140px;left:140px;'>Name:</h3><input type='text' id='name' name='name' style='position:absolute;top:150px;left:200px;border:none;width:200px;height:40px;' autocomplete='off' onkeypress='return isAlpha(event)'><br>";
		echo "<h3 style='font-weight:normal;position:absolute;top:190px;left:140px;'>Ph no:</h3><input type='text' id='ph' style='position:absolute;top:200px;left:200px;border:none;width:200px;height:40px;' autocomplete='off' onkeypress='return isNumber(event)' maxlength='10'><br>";
		echo "<h3 style='font-weight:normal;position:absolute;top:240px;left:125px;'>Subject:</h3><input type='text' id='sub' style='position:absolute;top:250px;left:200px;border:none;width:200px;height:40px;' autocomplete='off' ><br>";
		echo "<h3 style='font-weight:normal;position:absolute;top:340px;left:120px;'>Message:</h3><textarea maxlength='300' style='position:absolute;top:300px;left:200px;border:none;width:200px;height:100px;' id='msg' cols='30' rows='10'></textarea><br>";
		echo "<input type='button' id ='$type' value='Send' onclick='send_mail($event_id,this.id)' style='position:absolute;top:430px;left:200px;color:white;background-color:#177bbb;border:none;width:120px;height:40px;'>";
		
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