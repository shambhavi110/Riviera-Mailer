<?php
	session_start();
	if((isset($_SESSION["c_name"]))&&(isset($_REQUEST["key"])))
	{
		echo " 
		<p style='position:absolute;top:80px;left:60px;font-weight:bold;font-size:20px;'>New Password: </p><input  class='newpass1' type ='password' name ='np' id ='np' placeholder='New Password'><br>
		<p style='position:absolute;top:140px;left:35px;font-weight:bold;font-size:20px;'>Retype Password: </p><input class='confirm1' type ='password' name ='rnp' id ='rnp' placeholder = 'Confirm Password'><br>
		<paper-button value ='Submit' name='subpass' id ='subpass' onClick ='sub_pass()' class='check'>Submit</paper-button>";
	}
	else if(((!isset($_SESSION["c_name"]))&&(!isset($_REQUEST["key"])))||((isset($_SESSION["c_name"]))&&(!isset($_REQUEST["key"]))))
	{
		session_unset();
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		session_destroy();
		header("Location:login.php");
	}
	
	else
	{
		session_unset();
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		session_destroy();
		echo "<div>Ah4*!bb dhS8!) Nh5@n</div>";
		exit();
	}
?>
<style type="text/css">
.newpass1{position:absolute;top:90px;left:200px;border:none;height:45px;width:250px;}
.confirm1{position:absolute;top:150px;left:200px;border:none;height:45px;width:250px;}
.check{position:absolute;top:230px;left:200px;height:45px;background-color:rgb(23,123,187);width:250px;color:white;}
</style>