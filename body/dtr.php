<h2>Daily Time Record</h2>
<article class="pos_main">
<form method="post" action="home.php" class="add_user">
	<?php 
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
	<a class = "print" href="dtr.php?m=<?php echo $mth; ?>&y=<?php echo $year; ?>
	&id=<?php echo $id; ?>" target = "_blank"> <img src="images/print.png"> Print</a>
	<a class = "print" href="?action=employees" style="float: left;"> <img src="images/back.png"> Back</a>
	<br><br><br><br>
	<label>Select Date</label>
	<input	type="hidden" name="id" value="<?php echo $id; ?>">
	<input	type="hidden" name="action" value="view_dtr2">
	<input type = "month" class="d" name="month" value="<?php echo $dt; ?>" required>
	<br>
		<input class = "button" type="submit" name = "submit" value="Enter">
</form>
<article id="list">
	<?php $style =  "text-align: center; background-color: #8E8E8E; border: 1px solid #F1F1F1; color: #F1F1F1";?>
	<article class="delete_form" style="width: 100%; margin-left: 0px;">
		<label style="font-size: 16px; font-weight: bolder; margin-top: -5px;
		 width: 100%;">
		 <?php 
		 	$res = getName2($id);
		 	$r = mysql_fetch_array($res);
			$mi = str_split($r['Mname']);
			$prep = $r['Fname'] . " " . $mi[0] . ". ". $r['Lname'];
		 	echo $prep." - ".$month." ".$year." DTR";
		  ?>
		 </label>
	</article>
	<table class="payroll" style="width: 100%;">
		<tr>
			<th  class="print" rowspan="2" style="width: 5px; <?php echo $style; ?>">Day</th>
			<th  class="print" style="<?php echo $style; ?>"colspan="2">Morning</th>
			<th  class="print" style="<?php echo $style; ?>" colspan="2">Afternoon</th>
			<th  class="print" rowspan="2" style="width: 100px; <?php echo $style; ?>">Hours Worked</th>
			<th  class="print" rowspan="2" style="width: 100px; <?php echo $style; ?>">Overtime</th>
		</tr>
			<tr>
				<td style="font-weight: bold; <?php echo $style; ?>">Time in</td>
				<td style="font-weight: bold; <?php echo $style; ?>">Time out</td>
				<td style="font-weight: bold; <?php echo $style; ?>">Time in</td>
				<td style="font-weight: bold; <?php echo $style; ?>">Time out</td>
			</tr>
			<?php
				$c = 1; 
				while ( $c <= 31) {
				$r = $c % 2;
				if ($r == 0){
					$color = "#F1F1F1";
				}
				else{
					$color = "#ffffff";
				}
				$total = 0; $deduction = 0; $overTime = 0;
				if (strlen($c) == 1) {
					$c = "0".$c;
				}
				$dtr = getDTR2($id, $year, $mth, $c);
				$row = mysql_fetch_array($dtr);
				$amin = $row['am_in'];
				$amout = $row['am_out'];
				$pmin = $row['pm_in'];
				$pmout = $row['pm_out'];

				if ($amin == 0) 
					$amin = "";
				if ($amout == 0) 
					$amout = "";
				if ($pmin == 0) 
					$pmin = "";
				if ($pmout == 0) 
					$pmout = "";

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
			<tr style="background-color: <?php echo $color ?>;">
					<td style = "text-align: right;" ><?php echo $c; ?></td>
					<td style = "text-align: right;" ><?php echo $amin ?></td>
					<td style = "text-align: right;" ><?php echo $amout ?></td>
					<td style = "text-align: right;" ><?php echo $pmin ?></td>
					<td style = "text-align: right;" ><?php echo $pmout ?></td>
					<td style = "text-align: right;">
					<?php 
						if($total == 0)
							echo "";
						else
							vprintf("%.2f", $total);
					?>
					</td>
					<td style = "text-align: right;">
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
</article>