<?php
	session_start();
	if((isset($_SESSION["c_name"]))&&(isset($_REQUEST["s"])))
	{
		require 'sql_con.php';
		$s = $_REQUEST['s'];
		$s= preg_replace('/\s+/', '_', $s);
		$i=0;
		$sdiv=$_REQUEST["id1"];
		$q = "SELECT event_name FROM `events`";
		$r = mysqli_query($mysqli,$q);
		while($t=mysqli_fetch_array($r))
		{
			$rn[$i]=$t[0];
			$i++;
		} 
		if ($s!== "")
		{
				$s=strtolower($s); 
				$len=strlen($s);
				$j=0;
				foreach($rn as $name)
				{
					if (stristr($s, substr($name,0,$len)))
					{
							$n=str_replace("_"," ",$name);
							echo " <input class = 'button_search' type='button' id='$name' value='$n' onclick='value_set($name)'><input type='text' value=$sdiv hidden id='search'><br> ";
					}
					$j++;
				}
		}
		else
		{
			for($j=0;$j<$i;$j++)
			{
				echo "";
			}
		}
		mysqli_close($mysqli);
	}
	else if((isset($_SESSION["c_name"]))&&(!isset($_REQUEST["s"])))
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