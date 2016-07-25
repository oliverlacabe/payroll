<h2>Payslip</h2>
<article class="pos_main">
<form method="post" action="home.php" class="add_user">
	<?php 

			$prep2 = getEmpInfo($_SESSION['user_id']);
			$row = mysql_fetch_array($prep2);
			$mi = str_split($row['Mname']);
			$prep2 = $row['Fname'] . " " . $mi[0] . ". ". $row['Lname'];
			$row = getPos($row['Position']);
			$pos = mysql_fetch_array($row);
			$position = $pos['Pname'];

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
	<a class = "print" href="payslip.php?m=<?php echo $mth; ?>&y=<?php echo $year; ?>
	&id=<?php echo $id; ?>" target = "_blank"> <img src="images/print.png"> Print</a>
	<a class = "print" href="?action=employees" style="float: left;"> <img src="images/back.png"> Back</a>
	<br><br><br><br>
	<label>Select Date</label>
	<input	type="hidden" name="id" value="<?php echo $id; ?>">
	<input	type="hidden" name="action" value="view_payslip2">
	<input type = "month" class="d" name="month" value="<?php echo $dt; ?>" required>
	<br>
		<input class = "button" type="submit" name = "submit" value="Enter">
</form>
<article id="list2">
		 <?php 
		 	$res = getName2($id);
		 	$r = mysql_fetch_array($res);
			$mi = str_split($r['Mname']);
			$prep = $r['Fname'] . " " . $mi[0] . ". ". $r['Lname'];
			$pid = $r['Position'];
		 	$pos = getPos($pid); 
			$pos = mysql_fetch_array($pos);

			$deduct = getDeduct($pid, 1); $deduct = mysql_fetch_array($deduct);
			$s = $deduct['Amount'];
			$deduct = getDeduct($pid, 2); $deduct = mysql_fetch_array($deduct);
			$p = $deduct['Amount'];
			$deduct = getDeduct($pid, 3); $deduct = mysql_fetch_array($deduct);
			$h = $deduct['Amount'];

			$td = number_format($p + $s +$h, 2, '.', '');

			$style = "font-size: 14px; font-weight: bold";
			$total = 0; $deduction = 0; $overTime = 0;

			$dtr = getDTR($id, $year, $mth);
			while($row = mysql_fetch_array($dtr)){
				$amin = $row['am_in'];
				$amout = $row['am_out'];
				$pmin = $row['pm_in'];
				$pmout = $row['pm_out'];

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

					$overTime = number_format($overTime + $totalOT, 2, '.', '');
					$total = number_format($total + $total1 + $total2, 2, '.', '');
				}
			$Rincome = number_format(($pos['Salary']/8) * $total, 2, '.', '');
			$Oincome = number_format((($pos['Salary']/8) * 1.5) * $overTime, 2, '.', '');
		  ?>
	<label class="print" style="font-weight: bold;">Gleen Marketing, Incorporated</label>
	<label class="print">Justice Romualdez St.</label>
	<label class="print">Tacloban City</label>
	<label class="print"></label>
	<label class="print" style="font-weight: bold; font-size: 16px;">Payslip</label>
	<label class="print"></label>

	<table class="pay">
		<tr><td width="100">Employee:</td><td  style= "<?php echo $style; ?>"><?php echo $prep; ?></td></tr>
		<tr><td width="100">Designation:</td><td  style= "<?php echo $style; ?>"><?php echo $pos['Pname']; ?></td></tr>
		<tr><td width="100">Month and Year:</td><td  style= "<?php echo $style; ?>"><?php echo $month." ".$year; ?></td></tr>
	</table>

	<table class="pay2">
		<tr class="pay2">
			<th class="pay2">Payments</th>
			<th class="pay2">Salary</th>
			<th class="pay2" width="100">Hours Worked</th>
			<th class="pay2" width="250">Income</th>
		</tr>
		<tr class="pay2">
			<td class="pay2">Regular Salary</td>
			<td class="pay2" style="text-align: right;"><?php echo number_format($pos['Salary'], 2,'.', ','); ?></td>
			<td class="pay2" style="text-align: right;"><?php echo number_format($total, 2,'.', ',');?></td>
			<td class="pay2" style="text-align: right;"><?php echo number_format($Rincome, 2,'.', ',');?></td>
		</tr>
		<tr class="pay2">
			<td class="pay2">Overtime Salary</td>
			<td class="pay2" style="text-align: right;"><?php echo number_format(($pos['Salary'] * 1.5)/8, 2,'.', ',');?></td>
			<td class="pay2" style="text-align: right;"><?php echo number_format($overTime, 2,'.', ',');?></td>
			<td class="pay2" style="text-align: right;"><?php echo number_format($Oincome, 2,'.', ',');?></td>
		</tr>
		<tr class="pay2">
			<td class="pay2" colspan="3" style= "<?php echo $style; ?>">Total Income</td>
			<td class="pay2" style="text-align: right; <?php echo $style; ?>"><?php echo number_format($Oincome + $Rincome, 2,'.', ',');?></td>
		</tr>
	</table>

	<table class="pay2">
		<tr class="pay2">
			<th class="pay2">Deduction Name</th>
			<th class="pay2" width="250">Deduction</th>
		</tr>
		<tr class="pay2">
			<td class="pay2">SSS (Social Security System)</td>
			<td class="pay2" style="text-align: right;"><?php echo number_format($s, 2,'.', ','); ?></td>
		</tr>
		<tr class="pay2">
			<td class="pay2">Pagibig Funds</td>
			<td class="pay2" style="text-align: right;"><?php echo number_format($p, 2,'.', ','); ?></td>
		</tr>
		<tr class="pay2">
			<td class="pay2">Philhealth</td>
			<td class="pay2" style="text-align: right;"><?php echo number_format($h, 2,'.', ','); ?></td>
		</tr>
		<tr class="pay2">
			<td class="pay2" style= "<?php echo $style; ?>">Total Deductions</td>
			<td class="pay2" style="text-align: right; <?php echo $style; ?>"><?php echo number_format($td, 2,'.', ',');?></td>
		</tr>
	</table>

	<table class="pay2">
		<tr class="pay2">
			<th class="pay2" style= "<?php echo $style; ?>">Net Income</th>
			<th class="pay2" style= "text-align: right; <?php echo $style; ?>" width="250"><?php echo number_format($Oincome + $Rincome - $td, 2,'.', ',');?></th>
		</tr>
	</table>

		<article class="print" style="float: left;">
			<label class="print"></label><label class="print"></label>
			<label class="print" style="float: left; text-align: left;">Prepared by:</label>
			<label class="print"></label>
			<label class="print" style="font-weight: bold; font-size: 13px;"><?php echo $prep2 ?></label>
			<label class="print"><?php echo $position ?></label>
		</article>

		<article class="print">
			<label class="print"></label><label class="print"></label>
			<label class="print" style="float: left; text-align: left;">Approved by:</label>
			<label class="print"></label>
			<label class="print" style="font-weight: bold; font-size: 13px;">__________________________________</label>
			<label class="print">Signature</label>
		</article>
</article>
</article>