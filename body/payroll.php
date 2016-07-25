<h2>Payroll</h2>
<article class="pos_main">
<article>
<form method="post" action="home.php" class="add_user">
	<?php 
			$dt = date('Y-m');
			if (!isset($jm)) {
				$jm = date('m');
				$jy = date('Y');
			}

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
	<label>Select Date</label>
	<input	type="hidden" name="action" value="payroll2">
	<input type = "month" class="d" name="month" value="<?php echo $dt; ?>" required>
	<br><br>
	<label>Select Position</label>
	<select style= "text-align: right;" class = "pos" name="position">
		<option class="side" value="all"> 
			All
		</option>
		<?php while ($row = mysql_fetch_array($Pname)) {?>
			<option class="side" value = "<?php echo $row['pid']; ?>"> 
				<?php echo $row['Pname']; ?>
			</option>
		<?php } ?>
		</select>
		<input class = "button" type="submit" name = "submit" value="Enter">
</form>
</article>
<article id="list">
	<article class="delete_form" style=" width: 100%; margin-left: 0px;">
	<h3 style="margin-top: 10px;">
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
	</article>
	<table class="payroll">
		<tr>
			<th>Employee</th>
			<th>Position</th>
			<th>Hours Worked</th>
			<th>Overtime</th>
			<th>Salary</th>
			<th>Income</th>
			<th>OT Pay</th>
			<th>Deduction</th>
			<th>Net Income</th>
		</tr>
		<?php 
		$c = 1;
		while ($row = mysql_fetch_array($emp)){ 
			$r = $c % 2;
			if ($r == 0){
				$color = "#F1F1F1";
			}
			else{
				$color = "#ffffff";
			}
		?> 
		<tr style="background-color: <?php echo $color ?>;">
			<?php $total = 0; $deduction = 0; $overTime = 0; ?>
			<?php $m = str_split($row['Mname']); ?>
			<td><?php echo $row['Lname'] . ", " . $row['Fname'] . " " . $m[0] . "."; ?></td>

			<?php $pos = getPos($row['Position']); 
				$pos = mysql_fetch_array($pos);
				$salary = $pos['Salary'];

				$d = getDeduction($row['Position']);
				while ($r=mysql_fetch_array($d)) {
					$deduction = $deduction + $r['Amount'];
				}
			?>
			<td><?php echo $pos['Pname']; ?></td>

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
			<td style="text-align: right;"><?php echo number_format($total, 2, '.', ',') ?></td>
			<td style="text-align: right;"><?php echo number_format($overTime, 2, '.', ',') ?></td>
			<td style="text-align: right;"><?php echo number_format($salary, 2, '.', ',') ?></td>
			<td style="text-align: right;"><?php echo number_format($income, 2, '.', ',') ?></td>
			<td style="text-align: right;"><?php echo number_format($otPay, 2, '.', ',') ?></td>
			<td style="text-align: right;"><?php echo number_format($deduction, 2, '.', ',') ?></td>
			<td style="text-align: right;"><?php echo number_format($net, 2, '.', ',') ?></td>
		</tr>
		<?php 
			$c = $c + 1;
		} ?>
	</table>
	<?php 
		if(!isset($p))
			$p = "all";
	 ?>
	<a class = "print" href="print.php?m=<?php echo $jm; ?>&y=<?php echo $jy; ?>
	&p=<?php echo $p; ?>" target = "_blank"> <img src="images/print.png"> Print</a>
</article>
</article>