<?php
		session_start();
		if (!isset($_SESSION["user_id"])){
			require('models/connect.php');
			require('models/functions.php');
			include('include/header.php');
			include('body/nav2.php');

			if (isset($_POST['action']))
				$action = $_POST['action'];
			else if (isset($_GET['action']))
				$action = $_GET['action'];
			else
				$action = 'main';

			if ($action == 'login') {
				if(count($_POST)>0){
					$result = mysql_query("SELECT * FROM users WHERE 
					username='" . $_POST["username"] . "' and password = '". $_POST["password"]."'");
					$row  = mysql_fetch_array($result);
					if(is_array($row)) {
						$result = checkStat($row['empID']);
						$res = mysql_fetch_array($result);
						if ($res['status'] == 'Inactive') {
							include('body/login.php');
							?><script type="text/javascript"> alert("User is Inactive!"); </script><?php
						}
						elseif ($res['Pname'] != 'Supervisor' AND $res['Pname'] != 'Manager') {
							include('body/login.php');
							?><script type="text/javascript"> alert("User not recognized!"); </script><?php
						}
						else{
							$_SESSION["user_id"] = $row['empID'];
						}
					} 
					else {
						include('body/login.php');
						?><script type="text/javascript"> alert("Invalid Username or Password!"); </script><?php	
					}
				}
				if(isset($_SESSION["user_id"])) {
					header("Location:home.php");
				}
			}
			if ($action == 'time') {
				include('body/time.php');
			}
			else if ($action == 'main') {
			}
			else if ($action == 'loginform') {
				include('body/login.php');
			}
			else if ($action == 'add_time') {
				$e = $_POST['emp'];
				$d = date('d');
				$m = date('m');
				$y = date('Y');
				$id = getEmpID($e,$d,$m,$y);
				date_default_timezone_set('Asia/Manila');
				$t = date('H:i');
				if (mysql_result($id, 0)==0) {
					include('body/time.php');
					?><script type="text/javascript"> alert("Invalid ID Number!"); </script><?php
				}
				else{
					$res = checkTime($e,$d,$m,$y);
					$row = mysql_fetch_array($res);
					include('body/time.php');
					if(mysql_result($res, 0)>0){
						$res = checkTime2($e,$d,$m,$y);
						$row = mysql_fetch_array($res);
						$dtrID = $row['id'];
						$t1 = $row['am_out'];
						$t2 = $row['pm_in'];
						$t3 = $row['pm_out'];
						if ($t1 == "0" and $t2 == "0" and $t3 == "0"){
							saveDTR2($t,$dtrID);
							?><script type="text/javascript"> alert("Morning timeout saved!"); </script><?php
						}
						else if ($t2 == "0" and $t3 == "0"){
							saveDTR3($t,$dtrID);
							?><script type="text/javascript"> alert("Afternoon timein saved!"); </script><?php
						}
						else if ($t3 == "0"){
							saveDTR4($t,$dtrID);
							?><script type="text/javascript"> alert("Afternoon timeout saved!"); </script><?php
						}
						else{
							?><script type="text/javascript"> alert("Maximum no of timein and timeout reached! "); </script><?php
						}
					}
					else{
						if ($t < "12:00") {
							saveDTR1($e,$d,$m,$y,$t);
							?><script type="text/javascript"> alert("Morning timein saved!"); </script><?php
						}
						else if ($t >= "12:00" and $t < "17:00") {
							saveDTR5($e,$d,$m,$y,$t);
							?><script type="text/javascript"> alert("Afternoon timein saved!"); </script><?php
						}
						else{
							?><script type="text/javascript"> alert("Unable to save, time is beyond limit!"); </script><?php
						}
					}
				}
			}
		include('include/footer.php');		
	}
	else
		header('location: home.php');
?>