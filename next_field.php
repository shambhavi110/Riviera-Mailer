<?php
	$id= $_REQUEST["id"];
	$id++;
	$id1 = $id."d";
	$id2 = $id."s";
	echo "<input type='text' id=$id onkeyup='search_button(this.id)' class='event' placeholder='Search event...' ><div class='search_box' id =$id2></div><div id=$id1><br><input type='button' id=$id value='Add Recipient..' style='height:25px;background-color:rgb(23,120,187);color:white;width:180px;' onclick='next(this.id)'></div>";
?>