<?php
	session_start();
	if(isset($_SESSION["ec_name"]))
	{
	echo "	<!doctype html>
				<html lang='en'>
				<head>
					<meta charset='utf-8' />
					<title>Riviera | Event Co-ordinator Login</title>
					<script src='components/platform/platform.js'></script>
					
					<link rel='import' href='components/polymer/polymer.html'>
					<link rel='import' href='components/paper-button/paper-button.html'>
					<style type='text/css'>
					body{background-image:url('1280x800.net_4685 (1).jpg');background-repeat:no-repeat;background-attachment: fixed;}
					.head{
					position:fixed;top:0px;left:0px;
					width:100%;height:100px;
					background-color:rgba(0,0,0,0.7);box-shadow: 7px 7px 7px #61622F;z-index:10;
					}
					.headtext{
					position:fixed;left:80px;top:15px;color:rgba(240,240,240,0.8);
					}
					.home{
					position:fixed;color:white;top:50px;left:1048px;border:none;width:150px;height:50px;background-color:rgba(255,255,255,0);font-size:18px;z-index:10;
					}
					.home:hover{background-color:rgba(255,255,255,0.8);color:black;}
					.event{
					position:fixed;top:50px;color:white;left:998px;border:none;width:200px;height:50px;background-color:rgba(255,255,255,0);font-size:18px;z-index:10;
					}
					.event:hover{background-color:rgba(255,255,255,0.8);color:black;}
					.logout{
					position:fixed;top:50px;color:white;left:1198px;border:none;width:150px;height:50px;background-color:rgba(255,255,255,0);font-size:18px;z-index:10;
					}
					.logout:hover{background-color:rgba(255,255,255,0.8);color:black;}
					.events_table{position:absolute;top:250px;left:450px;background-color:rgba(246,226,0,0.7);width:500px;height:300px;overflow:auto;}
					.events_table1{position:absolute;top:200px;left:300px;background-color:rgba(246,226,0,0.7);width:700px;height:450px;overflow:auto;}
					</style>
				</head>
				<body>
					<div class='head'><h1 class='headtext'>Event Co-ordinator Account</h1></div>
					<a href = 'ec_home.php'><paper-button class='home'>Home</paper-button></a>
					<a href='logout.php'><paper-button class='logout'>Logout</paper-button></a>";
				
	
		require 'sql_con.php';
		$coordinator = $_SESSION["ec_name"];
		
		$sql_viewing = "SELECT individual_id,club_id FROM `event_cord_login` WHERE username='$coordinator'";
		$res_viewing = mysqli_query($mysqli,$sql_viewing);
		if($res_viewing==true)
		{
			$arr=mysqli_fetch_array($res_viewing);
			
			//club event
			if($arr["individual_id"]==0)
			{
				//more than one event
				$club_id = $arr["club_id"];
				$sql_club_events="SELECT event_id FROM `clubs_maps_event_ids` WHERE club_id=$club_id";
				$res_club_events=mysqli_query($mysqli,$sql_club_events);
				if($res_club_events==true)
				{
					$num = mysqli_num_rows($res_club_events);
					//only if the records exists
					if($num>0)
					{	
						echo"<div class='events_table' id='events_table'><table border ='2' style='position:absolute;top:50px;left:150px;border-collapse:collapse;width:200px;height:80px;'>
										<tr>
											<th>Event Name</th>
										</tr>";
						$i=0;
						$storeArray = Array();
						while ($arr_1 = mysqli_fetch_array($res_club_events)) 
						{
							//to store all the details in the array
						    $storeArray[] =  $arr_1['event_id'];  
						}
						foreach ($storeArray as $value) 
						{
							//$value here contains all the id's of the events
							$q = "SELECT event_name FROM events WHERE id=$value";
							//this is to be changed for geting the type of event
							$r = mysqli_query($mysqli,$q);
							$rn[$i]="";
							while($t=mysqli_fetch_array($r))
							{
									$rn[$i]=$t[0];
							}
							$j=$i;
							$name = str_replace("_"," ",$rn[$j]);
							if(isset($rn[$j]))
						echo "<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button value=".$name." style='height:30px;width:120px;border:none;color:white;background-color:#177bbb;' onclick='committee_mail($value)' id='button'>$name</button></td></tr>";	
						}
						echo "</table></div>";
					}
					// if the respective club has no events in it
					else
					{
						echo "<h3><center>No Events to display</center></h3>";
					}
				}
			}
			else//individual's event
			{
								//more than one event
								$ind_id = $arr["individual_id"];
								$q = "SELECT event_name FROM events WHERE id=$ind_id";
								$r = mysqli_query($mysqli,$q);
								$num = mysqli_num_rows($r);
								if($num>0)//only if the records exists
								{	
									echo"<div class='events_table' id='events_table'><table border ='2' style='position:absolute;top:50px;left:150px;border-collapse:collapse;width:200px;height:80px;'>
											<tr>
												<th>Event Name</th>
											</tr>";
										$rn="";
										while($t=mysqli_fetch_array($r))
										{
												$rn=$t[0];
										}
										if($rn!="")
											echo "<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type='button' value=".str_replace("_"," ",$rn)." style='height:30px;width:120px;border:none;color:white;background-color:#177bbb;'onclick='committee_mail($ind_id)' id='button'></td></tr>";
										echo"</table></div>";		
								}
								// if the respective individual has no events 
								else
								{
									echo "<h3><center>No Events to display</center></h3>";
								}
			}

		}
		echo "</body></html>";
		mysqli_close($mysqli);
	}
	else
	{
		session_unset();
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		session_destroy();
		header("Location:login.php");
	}
	
?>
<script>
// Regular expressions
function isNumber(evt)  
{
		var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
             return false;
        return true;
}
function isAlpha(evt)
{
       	var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 32 && charCode != 46 && charCode > 31 && (charCode < 97 || charCode > 122)&& (charCode < 65 || charCode > 90))
             return false;
        return true;
}

//(ec_home.php , ec_mail.php)
//Parameter - event id 
function committee_mail(id) 
{
	document.getElementById('events_table').className="events_table1";
	var xmlhttp=new XMLHttpRequest();
  	xmlhttp.onreadystatechange=function()
  	{
    	if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
      		document.getElementById("events_table").innerHTML=xmlhttp.responseText;
		}
  	}
  xmlhttp.open("POST","ec_mail.php",true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("id="+id);
}

//(ec_mail.php,form.php)
//Parameter - event id and committee type
function form_mail(id, t) 
{
	var xmlhttp=new XMLHttpRequest();
  	xmlhttp.onreadystatechange=function()
  	{
    	if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
      		document.getElementById("form").innerHTML=xmlhttp.responseText;
		}
  	}
  xmlhttp.open("POST","form.php",true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("id="+id+"&type="+t);
}

//(form.php,mail.php)
//Parameter - event id and committee type
function send_mail(id, t) 
{
	
	var name = document.getElementById("name").value;
	var ph = document.getElementById("ph").value;
	var msg = document.getElementById("msg").value;
	var sub = document.getElementById("sub").value;
	if(name==""||ph==""||msg==""||sub=="")
	{
		alert("Enter all details!");
		return false;
	}
	if(ph.length!=10)
	{
		alert("Enter a valid phone no!");
		return false;
	}
	var xmlhttp=new XMLHttpRequest();
  	xmlhttp.onreadystatechange=function()
  	{
    	if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
      		document.getElementById("form").innerHTML=xmlhttp.responseText;
	}
  	}
  xmlhttp.open("POST","mail.php",true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("id="+id+"&type="+t+"&ph="+ph+"&sub="+sub+"&msg="+msg+"&name="+name);
}
</script>