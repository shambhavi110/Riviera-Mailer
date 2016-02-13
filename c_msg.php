<?php
session_start();
if((isset($_SESSION["c_name"]))&&(isset($_REQUEST["ch"])))
{
	$event = array();
	$type = "";
	$event_str = "";
	$event_str=$_REQUEST["events"];
	require 'sql_con.php';
	if($_REQUEST["ch"]=="all")
	{
		$type="all";
		$event_str = "all";
		echo "<h3 style='text-align:center'>Message all events<br></h3>";
	}
	else
	{
		echo "<div style='margin-left:100px;'><h3>To events:<br></h3>";
		$event = explode(",",$event_str);
		for($i=0;$i<count($event);$i++)
		{
			$j=$i+1;
			 $e = rtrim($event[$i]);
			echo"$j. $e<br>";
		}
		$type="ind";
		echo "</div>";
	}
	echo "<input type='text' hidden value=$event_str id='e'>";
	echo "<br><input type='text' id='sub' placeholder='Subject' autocomplete='off' style='position:relative;top:0px;left:100px;width:240px;height:30px;border:none;'><br>

	<textarea placeholder='Message' id='msg' cols='30' rows='6' style='position:relative;top:10px;left:100px;width:240px;height:150px;border:none;'></textarea><br>

	<button id=$type  onclick='csend(this.id)' style='position:relative;top:20px;left:100px;width:240px;height:30px;border:none;background-color:#177bbb;color:white;'>Send</button><br><br>";
	mysqli_close($mysqli);
}
else if((isset($_SESSION["c_name"]))&&(!isset($_REQUEST["ch"])))
{
	session_unset();
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	session_destroy();
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