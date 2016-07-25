<?php 
	$connection = mysql_connect("localhost", "root", "") 
	or die("Could not connect: " . mysql_error());
	$db = mysql_select_db("payroll")
	or die("Could not connect: " . mysql_error());
 ?>