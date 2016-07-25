<?php 
	session_start();
	if($_SESSION["user_id"]){
		require('models/connect.php');
		require('models/functions.php');
		include('include/header.php');

		if (isset($_POST['action']))
			$action = $_POST['action'];
		else if (isset($_GET['action']))
			$action = $_GET['action'];
		else
			$action = 'home';

		if ($action == 'display_login_form'){
			session_start();
			unset($_SESSION["user_id"]);
			unset($_SESSION["user_name"]);
			header('Location:index.php');
		}

		else{
			include('body/nav.php');
			if ($action == 'home'){
				include('body/home.php');
			}
			else if ($action == 'account'){
				include('body/account.php');
			}
			else if ($action == 'account2'){
				include('body/account.php');
				?><script type="text/javascript">
					 alert("Username Updated"); 
				</script><?php
			}
			else if ($action == 'username'){
				$user = $_POST['uname'];
				updateUname($user);
				header('location: ?action=account2');
			}
			else if ($action == 'change_account'){
				$op = $_POST['op'];
				$np = $_POST['np'];
				$rtp = $_POST['rtp'];
				$confirmPass = getPass($op);
				$row = mysql_fetch_array($confirmPass);
				if ( $row[0] == 0) {
					include('body/account.php');
					?><script type="text/javascript">
					 	alert("Invalid Password"); 
					</script><?php
				}
				else if ($np != $rtp) {
					include('body/account.php');
					?><script type="text/javascript">
					 	alert("Password Mismatch"); 
					</script><?php
				}
				else{
					include('body/account.php');
					updatePass($np);
					?><script type="text/javascript">
					 	alert("Password Changed"); 
					</script><?php
				}
			}
			else if ($action == 'employees'){
				$Pname = getPname();
				include('body/add_user.php');
				$emp = getEmployees();
				include('body/display_employees.php');
			}

			else if ($action == 'add_user'){
				if (isset($_POST['user_ID'])) {
					$uid = $_POST['user_ID'];
					$uname = $_POST['uname'];
					$pass = $_POST['p'];
					$conf = $_POST['rtp'];
					if ($uid == "") {
						include('body/users.php');
						?><script type="text/javascript">
						 	alert("Please select an employee"); 
						</script><?php
					}
					else if ($pass != $conf) {
						include('body/users.php');
						?><script type="text/javascript">
						 	alert("Password Mismatch"); 
						</script><?php
					}
					else{
						saveUser($uid, $uname, $pass);
						include('body/users.php');
						?><script type="text/javascript">
						 	alert("New user added"); 
						</script><?php
					}
				}
				else
					include('body/users.php');
			}

			else if ($action == 'view_dtr'){
				$id = $_GET['id'];
				$year = date('Y');
				$mth = date('m');
				include('body/dtr.php');
			}
			else if ($action == 'view_dtr2'){
				$id = $_POST['id'];
				$word = explode("-", $_POST['month']);
				$year = $word[0];
				$mth = $word[1];
				include('body/dtr.php');
			}

			else if ($action == 'view_payslip'){
				$id = $_GET['id'];
				$year = date('Y');
				$mth = date('m');
				include('body/payslip.php');
			}
			else if ($action == 'view_payslip2'){
				$id = $_POST['id'];
				$word = explode("-", $_POST['month']);
				$year = $word[0];
				$mth = $word[1];
				include('body/payslip.php');
			}
			else if ($action == 'payroll'){
				$Pname = getPname();
				$emp = getEmployees2();
				include('body/payroll.php');
			}
			else if ($action == 'payroll2'){
				$j = $_POST['month'];
				$p = $_POST['position'];
				$word = explode("-", $j);

				$jy = $word[0];
				$jm = $word[1];

				$Pname = getPname();
				if($p == "all")
					$emp = getEmployees2();
				else
					$emp = getEmployees3($p);
				include('body/payroll.php');
			}
			else if ($action == 'add_employee') {	
				$fn = ucfirst(trim($_POST['firstname']));
				$ln = ucfirst(trim($_POST['lastname']));
				$mn = ucfirst(trim($_POST['middlename']));
				$add = ucfirst(trim($_POST['address']));
				$p = $_POST['position'];

				if (str_word_count($fn) > 1){
					$c = 0;
					$str = ""; $str2 = "";
					$word = explode(" ", $fn);
					while ($c < str_word_count($fn)) {
						$str = ucfirst($word[$c]);
						$str2 = $str2 . " " . $str;
						$c += 1;
					}
					$fn = trim($str2);
				}

				if (str_word_count($ln) > 1){
					$c = 0;
					$str = ""; $str2 = "";
					$word = explode(" ", $ln);
					while ($c < str_word_count($ln)) {
						$str = ucfirst($word[$c]);
						$str2 = $str2 . " " . $str;
						$c += 1;
					}
					$ln = trim($str2);
				}

				if (str_word_count($mn) > 1){
					$c = 0;
					$str = ""; $str2 = "";
					$word = explode(" ", $mn);
					while ($c < str_word_count($mn)) {
						$str = ucfirst($word[$c]);
						$str2 = $str2 . " " . $str;
						$c += 1;
					}
					$mn = trim($str2);
				}

				if (str_word_count($add) > 1){
					$c = 0;
					$str = ""; $str2 = "";
					$word = explode(" ", $add);
					while ($c < str_word_count($add)) {
						$str = ucfirst($word[$c]);
						$str2 = $str2 . " " . $str;
						$c += 1;
					}
					$add = trim($str2);
				}

				$f = str_split($fn);
				$l = str_split($ln);
				$m = str_split($mn);

				$empid = createID($l, $m, $f);

				saveEmp($fn, $ln, $mn, $add, $p, $empid);

				$Pname = getPname();
				include('body/add_user.php');
				$emp = getEmployees();
				include('body/display_employees.php');

				?><script type="text/javascript">
					alert("New employee added"); 
				</script><?php
			}
			else if($action == 'update_form'){
				$Pname = getPname();
				include('body/update_employee.php');
				$emp = getEmployees();
				include('body/emp_list.php');
			}
			else if ($action == 'update_employees') {
				$id = $_GET['id'];
				$empInfo = getEmpInfo($id);
				$Pname = getPname();
				include('body/update_employee.php');
				$emp = getEmployees();
				include('body/emp_list.php');
			}
			else if ($action == 'search1') {
				$search = $_POST['search1'];
				$Pname = getPname();
				include('body/update_employee.php');
				$search = stripslashes($search);
				$search = trim($search);
				$emp = getEmp($search);
				if( mysql_num_rows($emp) == 0){
					$emp = getEmployees();
					include('body/emp_list.php');
					?><script type="text/javascript">
						 alert("Empty result!"); 
					</script><?php
				}
				else{
					include('body/emp_list.php');
				}
			}
			else if ($action == 'search2') {
				$search = $_POST['search1'];
				$Pname = getPname();
				include('body/add_user.php');
				$search = stripslashes($search);
				$search = trim($search);
				$emp = getEmp($search);
				if( mysql_num_rows($emp) == 0){
					$emp = getEmployees();
					include('body/display_employees.php');
					?><script type="text/javascript">
						 alert("Empty result!"); 
					</script><?php
				}
				else{
					include('body/display_employees.php');
				}
			}
			else if ($action == 'disable_employees') {
				$id = $_GET['id'];
				disableEmp($id);
				header('location: ?action=update_form');
			}
			else if ($action == 'enable_employees') {
				$id = $_GET['id'];
				enableEmp($id);
				header('location: ?action=update_form');
			}
			else if ($action == 'position') {
				$Pname = getPname();
				include('body/position_sidebar.php');
			}
			else if ($action == 'delete_position') {
				$pid = $_GET['pid'];
				$res = checkPosition($pid);
				if (mysql_result($res, 0) == 0){
					deletePosition($pid);
					header('location: ?action=position');
				}
				else{
					$Pname = getPname();
					include('body/position_sidebar.php');
					?><script type="text/javascript"> alert("Unable to delete!. Position not empty"); </script><?php
				}
				
			}
			else if ($action == 'deductions') {
				$pname = $_POST['pname'];
				$salary = $_POST['salary'];
				$s = $_POST['sss'];
				$p = $_POST['pagibig'];
				$h = $_POST['philhealth'];
				$pid = $_POST['pid'];
				$Pname = getPname();
				if ($salary<260) {
					include('body/position_sidebar.php');
					?><script type="text/javascript"> alert("Invalid Salary Input. It must be greater than 260"); </script><?php
				}
				else if ($s<0) {
					include('body/position_sidebar.php');
					?><script type="text/javascript"> alert("Invalid SSS deduction"); </script><?php
				}
				else if ($p<0) {
					include('body/position_sidebar.php');
					?><script type="text/javascript"> alert("Invalid Pagibig deduction"); </script><?php
				}
				else if ($h<0) {
					include('body/position_sidebar.php');
					?><script type="text/javascript"> alert("Invalid Philhealth deduction"); </script><?php
				}
				else{
					updateDeductions($salary, $pid, $s, $p, $h, $pname);
					$check = $pid;
					include('body/position_sidebar.php');
					?><script type="text/javascript"> alert("Changes Saved"); </script><?php
				}
			}
			
			else if ($action == 'add_position') {
				$pname = ucfirst($_POST['pname']);
				$res = checkPname($pname);
				if (mysql_result($res, 0) == 0){
					addPosition($pname);
					include('body/position_sidebar.php');
					?><script type="text/javascript"> alert("Position succesfully added!"); </script><?php
				}
    			else{
					$Pname = getPname();
					include('body/position_sidebar.php');
					?><script type="text/javascript"> alert("Position already exist!"); </script><?php
    			}
				
			}

			else if ($action == 'update_for_real_na') {	
				$fn = ucfirst(trim($_POST['firstname']));
				$ln = ucfirst(trim($_POST['lastname']));
				$mn = ucfirst(trim($_POST['middlename']));
				$add = ucfirst(trim($_POST['address']));
				$p = $_POST['position'];
				$id = $_POST['id'];

				if (str_word_count($fn) > 1){
					$c = 0;
					$str = ""; $str2 = "";
					$word = explode(" ", $fn);
					while ($c < str_word_count($fn)) {
						$str = ucfirst($word[$c]);
						$str2 = $str2 . " " . $str;
						$c += 1;
					}
					$fn = trim($str2);
				}

				if (str_word_count($ln) > 1){
					$c = 0;
					$str = ""; $str2 = "";
					$word = explode(" ", $ln);
					while ($c < str_word_count($ln)) {
						$str = ucfirst($word[$c]);
						$str2 = $str2 . " " . $str;
						$c += 1;
					}
					$ln = trim($str2);
				}

				if (str_word_count($mn) > 1){
					$c = 0;
					$str = ""; $str2 = "";
					$word = explode(" ", $mn);
					while ($c < str_word_count($mn)) {
						$str = ucfirst($word[$c]);
						$str2 = $str2 . " " . $str;
						$c += 1;
					}
					$mn = trim($str2);
				}

				if (str_word_count($add) > 1){
					$c = 0;
					$str = ""; $str2 = "";
					$word = explode(" ", $add);
					while ($c < str_word_count($add)) {
						$str = ucfirst($word[$c]);
						$str2 = $str2 . " " . $str;
						$c += 1;
					}
					$add = trim($str2);
				}

				updateEmp($fn, $ln, $mn, $add, $p, $id);

				$Pname = getPname();
				include('body/update_employee.php');
				$emp = getEmployees();
				include('body/emp_list.php');

				?><script type="text/javascript">
					alert("Employee successfuly updated"); 
				</script><?php
			}
			include('include/footer.php');
		} 
	}
	else
		header('location:index.php')
?>