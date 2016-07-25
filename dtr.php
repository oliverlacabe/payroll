<!DOCTYPE html>
 <html>
 <head>
 	<title>Gleen Marketing - Automated Payroll System</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<link rel="Icon" type="image/png" href="images/icon.png">
 </head>
 <body class="print">
	 <label class="print" style="font-weight: bold;">Gleen Marketing, Incorporated</label>
	 <label class="print">Justice Romualdez St.</label>
	 <label class="print">Tacloban City</label>
	 <label class="print"></label>
	<?php 
	session_start();
	if(isset($_SESSION['user_id'])){
	require('models/connect.php');
	require('models/functions.php');


	$id = $_GET['id'];
	$year = $_GET['y'];
	$mth = $_GET['m'];

			$dt = date('Y-m');
			if (!isset($mth)) {
				$mth = date('m');
				$year = date('Y');
			}

			if($mth == "01"){
				$month = "January";
			}
			elseif ($mth == "02") {
				$month = "February";
			}
			elseif ($mth == "03") {
				$month = "March";		
			}
			elseif ($mth == "04") {
				$month = "April";		
			}
			elseif ($mth == "05") {
				$month = "May";		
			}
			elseif ($mth == "06") {
				$month = "June";		
			}
			elseif ($mth == "07") {
				$month = "July";		
			}
			elseif ($mth == "08") {
				$month = "August";		
			}
			elseif ($mth == "09") {
				$month = "September";		
			}
			elseif ($mth == "10") {
				$month = "October";	
			}
			elseif ($mth == "11") {
				$month = "November";		
			}
			elseif ($mth == "12") {
				$month = "December";		
			}
	?>
<article style="width: 80%; margin: 0px auto;">
	<?php $style =  "text-align: center;"?>
	 <label class="print" style="float: right; text-align: right;"><?php echo date('F d, Y'); ?></label>
		<h3 style="color: #000">
		 <?php 
		 	$res = getName2($id);
		 	$r = mysql_fetch_array($res);
			$mi = str_split($r['Mname']);
			$prep = $r['Fname'] . " " . $mi[0] . ". ". $r['Lname'];
		 	echo $prep." - ".$month." ".$year." DTR";
		  ?>
		 </h3>
	<table style="border: 2px solid;">
		<tr class="print">
			<th  class="print" rowspan="2" style="width: 5px; <?php echo $style; ?>">Day</th>
			<th  class="print" style="<?php echo $style; ?>"colspan="2">Morning</th>
			<th  class="print" style="<?php echo $style; ?>" colspan="2">Afternoon</th>
			<th  class="print" rowspan="2" style="width: 100px; <?php echo $style; ?>">Hours Worked</th>
			<th  class="print" rowspan="2" style="width: 100px; <?php echo $style; ?>">Overtime</th>
		</tr>
			<tr class="print">
				<td class="print" style="font-weight: bold; <?php echo $style; ?>">Time in</td>
				<td class="print" style="font-weight: bold; <?php echo $style; ?>">Time out</td>
				<td class="print" style="font-weight: bold; <?php echo $style; ?>">Time in</td>
				<td class="print" style="font-weight: bold; <?php echo $style; ?>">Time out</td>
			</tr>
			<?php
				$c = 1; 
				while ( $c <= 31) {
				$total = 0; $deduction = 0; $overTime = 0;
				$dtr = getDTR2($id, $year, $mth, $c);
				$row = mysql_fetch_array($dtr);
				$amin = $row['am_in'];
				$amout = $row['am_out'];
				$pmin = $row['pm_in'];
				$pmout = $row['pm_out'];

					$total1 = 0; $total2 = 0; $totalOT=0;

					if(!$amin == "0" and !$amout == "0"){
						$row = explode(':', $amin);

						$h1 = $row[0];
						$m1 = $row[1];

						$row = explode(':', $amout);

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

					if(!$pmin == "0" and !$pmout == "0"){
						$row = explode(':', $pmin);

						$h3 = $row[0];
						$m3 = $row[1];

						$row = explode(':', $pmout);

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

					$overTime = $overTime + $totalOT;
					$total = $total + $total1 + $total2;
			?>
			<tr class="print">
					<td class="print" style = "text-align: right; padding: 2px;" ><?php echo $c; ?></td>
					<td class="print" style = "text-align: right; padding: 2px;" ><?php echo $amin ?></td>
					<td class="print" style = "text-align: right; padding: 2px;" ><?php echo $amout ?></td>
					<td class="print" style = "text-align: right; padding: 2px;" ><?php echo $pmin ?></td>
					<td class="print" style = "text-align: right; padding: 2px;" ><?php echo $pmout ?></td>
					<td class="print" style = "text-align: right; padding: 2px;">
					<?php 
						if($total == 0)
							echo "";
						else
							vprintf("%.2f", $total);
					?>
					</td>
					<td class="print" style = "text-align: right; padding: 2px;">
					<?php 
						if($overTime == 0)
							echo "";
						else
							vprintf("%.2f", $overTime) 
					?>
					</td>
			</tr>
			<?php 
				$c += 1;
			} ?>
	</table>
</article>
 </body>
<?php } ?>