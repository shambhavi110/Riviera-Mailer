<?php
	session_start();
	//if session is already sets
	if(isset($_SESSION["c_name"])||isset($_SESSION["ec_name"]))
	{
			echo "<div class='err'>Successfully logged out!!</div>";
			session_unset();
			session_destroy();
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	}
	
	//Committee login
	
	if(isset($_POST["login"]))
	{
		require('sql_con.php');
		$name="";
		$password="";
		if(isset($_POST["name"])&&isset($_POST["pass"]))
		{
			$name=$_POST["name"];
			$password=$_POST["pass"];
			$name = mysqli_real_escape_string($mysqli,$name);
			$password = mysqli_real_escape_string($mysqli,$password);
			$sql="SELECT * from `committee_login` where id='$name' and password='$password'";
			$res=mysqli_query($mysqli,$sql);
			$row = mysqli_fetch_array($res,MYSQLI_ASSOC);
			if(is_array($row))
			{
				//Session created - c_name
				session_start();
				$_SESSION["c_name"]=$_POST["name"];
				mysqli_close($mysqli);
				header("Location:c_home.php");
				echo "Success!";
			}
			else
			{
				echo "<div class='err'>Either the name or password is invalid!</div>";
			}
		}	
		else
		{
			echo "<div class ='err'><strong>Please enter the both fields</strong></div>";
		}
		mysqli_close($mysqli);
	}
	
	//Event cordinator login
	
	if(isset($_POST["ec_login"]))
	{
		require('sql_con.php');
		$name="";
		$password="";
		if(isset($_POST["ec_name"])&&isset($_POST["ec_pass"]))
		{
			$name=$_POST["ec_name"];
			$password=$_POST["ec_pass"];
			$name = mysqli_real_escape_string($mysqli,$name);
			$password = mysqli_real_escape_string($mysqli,$password);
			$sql="SELECT * from `event_cord_login` where username='$name' and password='$password'";
			$res=mysqli_query($mysqli,$sql);
			$row = mysqli_fetch_array($res,MYSQLI_ASSOC);
			if(is_array($row))
			{
				//Session created - ec_name
				session_start();
				$_SESSION["ec_name"]=$_POST["ec_name"];
				mysqli_close($mysqli);
				header("Location:ec_home.php");
				echo "Success!";
			}
			else
			{
				echo "<div class='err'>Either the name or password is invalid!</div>";
			}
		}	
		else
		{
			echo "<div class ='err'><strong>Please enter the both fields</strong></div>";
		}
		mysqli_close($mysqli);
	}
?>
<html>
<head>
		<title>Riviera | Login</title>
<style type="text/css">
@-webkit-keyframes bounceleft {
  0% {
	-webkit-transform:translateX(-100%);
    opacity: 0;
  }
  
  15% {
  	-webkit-transform:translateX(0);
    padding-bottom: 5px;
  }
  30% {
  	-webkit-transform:translateX(-20%);
  }
  40% {
  	-webkit-transform:translateX(0%);
    padding-bottom: 6px;
  }
  50% {
  	-webkit-transform:translateX(-10%);
  }
  70% {
  	-webkit-transform:translateX(0%);
    padding-bottom: 7px;
  }
  80% {
  	-webkit-transform:translateX(-5%);
  }
}

@-webkit-keyframes bounceright {
  0% {
	-webkit-transform:translateX(100%);
    opacity: 0;
  }
  
  15% {
  	-webkit-transform:translateX(0);
    padding-bottom: 5px;
  }
  30% {
  	-webkit-transform:translateX(20%);
  }
  40% {
  	-webkit-transform:translateX(0%);
    padding-bottom: 6px;
  }
  50% {
  	-webkit-transform:translateX(10%);
  }
  70% {
  	-webkit-transform:translateX(0%);
    padding-bottom: 7px;
  }
  80% {
  	-webkit-transform:translateX(5%);
  }
}
body{background-image:url('1280x800.net_4685 (1).jpg');background-repeat:no-repeat;}

.admin{background-color:rgba(241,238,99,0.8);
position:absolute;top:320px;left:365px;width:300px;height:300px;
box-shadow: 7px 7px 7px #61622F;
-webkit-animation: bounceleft 2000ms ease-out;
}

.coordinator{
position:absolute;top:320px;left:735px;width:300px;height:300px;background-color:rgba(241,238,99,0.8);
box-shadow: 6px 6px 6px #61622F;-webkit-animation: bounceright 2000ms ease-out;
}

.head{color:#5F5854;}
.cohead{color:#5F5854;}

.submit{
position:absolute;top:220px;left:25px;
width:250px;height:45px;
background-color:#177bbb;
border:none;	
color:white;font-size:18px;
}
.ec_submit{
position:absolute;top:220px;left:30px;
width:250px;height:45px;
background-color:#177bbb;
border:none;	
color:white;font-size:18px;
}

.name{
position:absolute;top:100px;left:30px;
width:250px;height:45px;border:none;
}
.password{
position:absolute;top:155px;left:30px;
width:250px;height:45px;border:none;
}

.ec_password{
position:absolute;top:155px;left:30px;
width:250px;height:45px;border:none;
}
.ec_name{
position:absolute;top:100px;left:30px;
width:250px;height:45px;border:none;
}
.err{
color:black;position:absolute;top:270px;left:540px;font-size:21px;
}
</style>
</head>
	<body>
		<div class="admin">
		<h2 class="head"><center>Committee Login</center></h2>
		<form name='admin' method='post' action='login.php'>
			<input type="text" name="name" class="name" placeholder="Enter User ID" autocomplete='off'><br>
			<input type="password" name="pass" class="password" placeholder="Enter Password"><br>
			<input type="submit"  class="submit" name="login" value="Login"><br>
		</form>
		</div>
		<div class="coordinator">
		<h2 class="cohead" ><center>Event Co-ordinator login</center></h2>
		<form name='cordinator' method='post' action='login.php'>
			<input type="text" name="ec_name" class="ec_name" placeholder="Enter User ID" autocomplete='off'><br>
			<input type="password" name="ec_pass" class="ec_password" placeholder="Enter Password" ><br>
			<input type="submit" name="ec_login" class="ec_submit" value="Login"><br>
		</form>
	</body>
</html>