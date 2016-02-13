<?php
		session_start();
		if((isset($_SESSION["c_name"]))&&(isset($_REQUEST["np"])))
		{
			require 'sql_con.php';
			$name = $_SESSION["c_name"];
			$p = $_REQUEST['np'];

			$q = "UPDATE `committee_login` SET password ='$p' WHERE id = '$name'";
			$c = mysqli_query($mysqli,$q);
			if($c)
			{
				echo "Successfully Changed!<br>";
			}
			else
			{
				echo "Password change Failed!<br>";
			}
			mysqli_close($mysqli);
		}
		else if(!isset($_SESSION["c_name"])||!isset($_REQUEST["np"]))
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