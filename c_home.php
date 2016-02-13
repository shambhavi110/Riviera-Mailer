<?php
	session_start();
	if(isset($_SESSION["c_name"]))
	{
	echo "	<!doctype html>
				<html lang='en'>
				<head>
					<meta charset='utf-8' />
					<title>Riviera | Committee Login</title>
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
					position:fixed;color:white;top:50px;left:848px;border:none;width:150px;height:50px;background-color:rgba(255,255,255,0);font-size:18px;z-index:10;
					}
					.home:hover{background-color:rgba(255,255,255,0.8);color:black;}
					.event1{
					position:fixed;top:50px;color:white;left:998px;border:none;width:200px;height:50px;background-color:rgba(255,255,255,0);font-size:18px;z-index:10;
					}
					.event:hover{background-color:rgba(255,255,255,0.8);color:black;}
					.logout{
					position:fixed;top:50px;color:white;left:1198px;border:none;width:150px;height:50px;background-color:rgba(255,255,255,0);font-size:18px;z-index:10;
					}
					.logout:hover{background-color:rgba(255,255,255,0.8);color:black;}
					.displ{position:absolute;top:200px;left:500px;background-color:rgba(246,226,0,0.7);width:500px;height:350px;overflow:auto;}
					.event{width:175px;height:20px;}
					.button_search{border:1px solid black;background-color:white;width:175px;text-align:left}
					.button_search:hover{background-color:blue}
					</style>
				</head>
				<body>
					<div class='head'><h1 class='headtext'>Committee Account</h1></div>
					<a href = 'c_home.php'><paper-button class='home'>Home</paper-button></a>
					<paper-button onclick='change_pass()' class='event1'>Change Password</paper-button>
					<a href='logout.php'><paper-button class='logout'>Logout</paper-button></a>";
				
	
		require 'sql_con.php';
		$a=1;
		$i=2;
		$committee = $_SESSION["c_name"];
		echo "<div id='main' class='displ'><div id='choice' style='text-align:center;'><h3><input type='radio' value='all' id='choice' onclick='display($a)' name='choice'>All Events<br><input type='radio' value='ind' id='choice'  name='choice' onclick='display($i)'>Individual Events<br></h3></div>";
		echo "<div id='main_ind' hidden style='text-align:center;'><input type ='text' id='count' value='0' hidden><input class='event' placeholder='Search event...' type='text' id=1 onkeyup='search_button(this.id)'><div id ='1s'></div><div id='1d'><br><input type='button' id='1' value='Add Recipient..' style='height:25px;background-color:rgb(23,120,187);color:white;width:180px;' onclick='next(this.id)'></div></div><br><div style='text-align:center;'><input type='button' id='sub' value='NEXT' onclick='sub()' style='height:30px;background-color:rgb(23,120,187);width:150px;color:white;'></div>";
		echo "</div>";
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
function change_pass()		
{
	var numb = "10101";
	var xmlhttp=new XMLHttpRequest();
  	xmlhttp.onreadystatechange=function()
  	{
    	if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
      		document.getElementById("main").innerHTML=xmlhttp.responseText;
			var res=document.getElementById("main").innerHTML;
			if(res.indexOf("dhS8!)")>0)
			{
				window.location = 'login.php';
			}
		}
  	}
  	xmlhttp.open("GET","change_pass.php?key="+numb,true);
    xmlhttp.send();
}
function sub_pass()
{
var f=0;
var np1 = document.getElementById("np").value; 
var np2 = document.getElementById("rnp").value; 
if(!(np1==np2))
{
	f = 1;
	alert("Both Passwords should match");
}
if((np1=="")&&(np2==""))
{
	f=1;
	alert("Password cannot be null");
}
if(f==0)
{
	var xmlhttp=new XMLHttpRequest();
  	xmlhttp.onreadystatechange=function()
  	{
    	if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
      		document.getElementById("main").innerHTML=xmlhttp.responseText;
			var res=document.getElementById("main").innerHTML;
			if(res.indexOf("dhS8!)")>0)
			{
				window.location = 'login.php';
			}
    	}
  	}
  	xmlhttp.open("POST","sub_pass.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("np="+np1);
}
}
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
//Next event name text field
function next(id) 
{
	document.getElementById("count").value=id;
	for(var j =1;j<=id;j++)
	{
		if(document.getElementById(j).value=="")
		{
			alert("Enter a value");
			return false;
		}
	}
	id1 = id+"d";
	var xmlhttp=new XMLHttpRequest();
  	xmlhttp.onreadystatechange=function()
  	{
    	if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
      		document.getElementById(id1).innerHTML=xmlhttp.responseText;
		}
  	}
  xmlhttp.open("POST","next_field.php",true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("id="+id);
}

function sub()
{
var events =[];
var ch = "";
var c = document.getElementsByName("choice");
for(var k =0;k<c.length;k++)
{
	if(c[k].checked==true)
		ch = c[k].value;
}
if(ch=="ind")
{
	var i =0;
	var j = 0;
	var count = document.getElementById("count").value;
	count++;
	for(i =1;i<=count;i++)
	{
		if(document.getElementById(i).value!="")
			events[j++] = document.getElementById(i).value;
		else
		{
			alert("Enter all values");
			return false;
		}
	}
}
else if(ch=="") 
{
	alert("Select any one option");
	return false;
}
var xmlhttp=new XMLHttpRequest();
  	xmlhttp.onreadystatechange=function()
  	{
    	if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
      		document.getElementById("main").innerHTML=xmlhttp.responseText;
		}
  	}
xmlhttp.open("POST","c_msg.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("ch="+ch+"&events="+events);
}
//Search bar for events list
function search_button(id)
{
	var s = document.getElementById(id).value;
	id1 = id+"s";
	var xmlhttp=new XMLHttpRequest();
  	xmlhttp.onreadystatechange=function()
  	{
    	if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
      		document.getElementById(id1).innerHTML=xmlhttp.responseText;
		}
  	}
  xmlhttp.open("POST","search_event.php",true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("s="+s+"&id1="+id1);
}
//After selecting an event in the search bar
function value_set(n)
{
	var event = n.value;
	var sdiv = document.getElementById("search").value;
	document.getElementById(sdiv).innerHTML="";
	sdiv = sdiv.replace("s","");
	document.getElementById(sdiv).value = event;
}
//Switching between all and ind events
function display(id)
{
if(id==1)
	document.getElementById("main_ind").hidden=true;
else if(id==2)
	document.getElementById("main_ind").hidden=false;
}
//Mailing the recipients
function csend(n)
{
var e = document.getElementById("e").value;
var sub = document.getElementById("sub").value;
var msg = document.getElementById("msg").value;
var xmlhttp=new XMLHttpRequest();
  	xmlhttp.onreadystatechange=function()
  	{
    	if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
      		document.getElementById("main").innerHTML=xmlhttp.responseText;
		}
  	}
  xmlhttp.open("POST","c_mail.php",true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("t="+n+"&e="+e+"&sub="+sub+"&msg="+msg);
}
</script>