<article id="list">
	<article class="delete_form" style="width: 100%; margin-left: 0px;">
		<label style="font-size: 16px; font-weight: bolder; margin-top: -5px;
		 width: 300px;">Employees List</label>
		 <form class = "search" method="post" action="home.php">
			 <input type="hidden" name = "action" value="search2">
			 <input class = "search" autofocus name = "search1" type="search" placeholder="search" required>
			 <input class = "search2" type="submit" value="Search">
		 </form>
	</article>
	<table style="margin-top: 50px;">
		<tr>
			<th>Employee ID</th>
			<th>Name</th>
			<th>Position</th>
			<th>Address</th>
			<th>Status</th>
			<th>View</th>
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
			<td><?php echo $row['empID']; ?></td>
			<?php $m = str_split($row['Mname']); ?>
			<td><?php echo $row['Lname'] . ", " . $row['Fname'] . " " . $m[0] . "."; ?></td>

			<?php $pos = getPos($row['Position']); 
				$pos = mysql_fetch_array($pos);
			?>
			
			<td><?php echo $pos['Pname']; ?></td>
			<td><?php echo $row['Address']; ?></td>
			<?php if ($row['status'] == 'Inactive') {?>
				<td style="color: #B30020;">
					<?php echo $row['status']; ?>
				</td>
			<?php } 
			else{?>
				<td>
					<?php echo $row['status']; ?>
				</td>
			<?php } ?>
			<td><a class = "update" href="?action=view_dtr&id=<?php echo $row['empID']; ?>">
			<img src="images/dtr.png"> DTR</a>
			<a class = "update" href="?action=view_payslip&id=<?php echo $row['empID']; ?>">
			<img src="images/pay.png"> Payslip</a></td>
		</tr>
		<?php 
			$c = $c + 1;
		} ?>
	</table>
</article>