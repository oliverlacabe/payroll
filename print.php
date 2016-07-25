<?php 
	session_start();
	if(isset($_SESSION['user_id'])){
	require('models/connect.php');
	require('models/functions.php');
	$emp = getEmployees();
	$prep = getEmpInfo($_SESSION['user_id']);
	$row = mysql_fetch_array($prep);
	$mi = str_split($row['Mname']);
	$prep = $row['Fname'] . " " . $mi[0] . ". ". $row['Lname'];
	$row = getPos($row['Position']);
	$pos = mysql_fetch_array($row);
	$position = $pos['Pname'];

 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Gleen Marketing - Automated Payroll System</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<link rel="Icon" type="image/png" href="images/icon.png">
 </head>
 <?php 
	$p = $_GET['p'];
	$jy = $_GET['y'];
	$jm = $_GET['m'];
	if($p == "all")
		$emp = getEmployees2();
	else
		$emp = getEmployees3($p);

	if($jm == "01"){
		$month = "January";
	}
	elseif ($jm == "02") {
		$month = "February";
	}
	elseif ($jm == "03") {
		$month = "March";		
	}
	elseif ($jm == "04") {
		$month = "April";		
	}
	elseif ($jm == "05") {
		$month = "May";		
	}
	elseif ($jm == "06") {
		$month = "June";		
	}
	elseif ($jm == "07") {
		$month = "July";		
	}
	elseif ($jm == "08") {
		$month = "August";		
	}
	elseif ($jm == "09") {
		$month = "September";		
	}
	elseif ($jm == "10") {
		$month = "October";	
	}
	elseif ($jm == "11") {
		$month = "November";		
	}
	elseif ($jm == "12") {
		$month = "December";		
	}
  ?>
<body class="print">
	 <label class="print" style="font-weight: bold;">Gleen Marketing, Incorporated</label>
	 <label class="print">Justice Romualdez St.</label>
	 <label class="print">Tacloban City</label>
	 <label class="print"></label>
	 <article style="width: 95%; margin: 0px auto;">
	 <label class="print" style="float: right; text-align: right;"><?php echo date('F d, Y'); ?></label>
	 <h3 style="color: #000;">
	 <?php  
		if (!isset($p)) 
			$pos = " Payroll";
		else{

			if ($p == "all") 
				$pos = " Payroll";
			else{
				$pos = getPos($p);
				$pos = mysql_fetch_array($pos);
				$pos = " Payroll for ".$pos['Pname']."s";
			}
		}
		echo $month." ".$jy.$pos; 
	 ?>
	 </h3>

	 <table>
			<tr class="print">
				<th class="print" >Employee</th>
				<th class="print" >Position</th>
				<th class="print" >Hours Worked</th>
				<th class="print" >Overtime</th>
				<th class="print" >Salary</th>
				<th class="print" >Income</th>
				<th class="print" >OT Pay</th>
				<th class="print" >Deduction</th>
				<th class="print" >Net Income</th>
			</tr>
		<?php 
		$Pname = getPname();
		$c = 1;
		while ($row = mysql_fetch_array($emp)){ ?>
		<tr class = "print">
			<?php $total = 0; $deduction = 0; $overTime = 0; ?>
			<?php $m = str_split($row['Mname']); ?>
			<td class = "print"><?php echo $row['Lname'] . ", " . $row['Fname'] . " " . $m[0] . "."; ?></td>

			<?php $pos = getPos($row['Position']); 
				$pos = mysql_fetch_array($pos);
				$salary = $pos['Salary'];

				$d = getDeduction($row['Position']);
				while ($r=mysql_fetch_array($d)) {
					$deduction = $deduction + $r['Amount'];
				}
			?>
			<td class = "print"><?php echo $pos['Pname']; ?></td>

			<?php 
				if(!isset($jm) and !isset($jy)){
					$jm = date('m');
					$jy = date('Y');
				}
				$dtr = getDTR($row['empID'], $jy, $jm);
				while ($r=mysql_fetch_array($dtr)) {
					$t1 = $r['am_in'];
					$t2 = $r['am_out'];
					$t3 = $r['pm_in'];
					$t4 = $r['pm_out'];
					$total1 = 0; $total2 = 0; $totalOT=0;

					if(!$t1 == "0" and !$t2 == "0"){
						$row = explode(':', $t1);

						$h1 = $row[0];
						$m1 = $row[1];

						$row = explode(':', $t2);

						$h2 = $row[0];
						$m2 = $row[1];

						if ($h1 < 8) {
							$h1 = 8;
							$m1 = 0;
						}

						if ($h2 >= 12 and $m2 >= 0) {
							$h2 = 12;
							$m2 = 0;
						}

						$hour1 = ($h2 - $h1) * 60;
						$min1 = $m2 - $m1;
						$total1 = ($hour1 + $min1)/60;
					}

					if(!$t3 == "0" and !$t4 == "0"){
						$row = explode(':', $t3);

						$h3 = $row[0];
						$m3 = $row[1];

						$row = explode(':', $t4);

						$h4 = $row[0];
						$m4 = $row[1];

						if ($h3 < 13) {
							$h3 = 13;
							$m3 = 0;
						}

						if ($h4 >= 17 and $m4 >= 0) {
							if ($h4>=20 and $m4>=0) {
								$oth = 20;
								$otm = 0;
							}
							else{
								$oth = $h4;
								$otm = $m4;
							}
							$h4 = 17;
							$m4 = 0;

							$ot = ($oth - $h4) * 60;
							$otm = $otm - $m4;
							$totalOT = ($ot + $otm)/60;

						}

						$hour2 = ($h4 - $h3) * 60;
						$min2 = $m4 - $m3;
						$total2 = ($hour2 + $min2)/60;

					}

					$overTime = number_format($overTime + $totalOT, 2, '.', '');
					$total = number_format( $total + $total1 + $total2, 2, '.', '');
				}

				$otPay = number_format((($salary/8) * 1.5) * $overTime, 2, '.', '');
				$income = number_format(($total * ($salary/8)), 2, '.', '');
				$net = number_format($income - $deduction + $otPay, 2, '.', '')
			 ?>
			<td class="print" style="text-align: right;"><?php echo number_format($total, 2, '.', ',') ?></td>
			<td class="print" style="text-align: right;"><?php echo number_format($overTime, 2, '.', ',') ?></td>
			<td class="print" style="text-align: right;"><?php echo number_format($salary, 2, '.', ',') ?></td>
			<td class="print" style="text-align: right;"><?php echo number_format($income, 2, '.', ',') ?></td>
			<td class="print" style="text-align: right;"><?php echo number_format($otPay, 2, '.', ',') ?></td>
			<td class="print" style="text-align: right;"><?php echo number_format($deduction, 2, '.', ',') ?></td>
			<td class="print" style="text-align: right;"><?php echo number_format($net, 2, '.', ',') ?></td>
		</tr>
		<?php 
			$c = $c + 1;
		} ?>
		</table>
		<article class="print">
			<label class="print"></label><label class="print"></label>
			<label class="print" style="float: left; text-align: left;">Prepared by:</label>
			<label class="print"></label>
			<label class="print" style="font-weight: bold; font-size: 13px;"><?php echo $prep ?></label>
			<label class="print"><?php echo $position ?></label>
		</article>
	</article>
 </body>
 </html><?php } ?>