<article id="list">
	<article class="delete_form" style="width: 100%; margin-left: 0px;">
		<label style="font-size: 16px; font-weight: bolder; margin-top: -5px;
		 width: 300px;">Employees List</label>
		 <form class = "search" method="post" action="home.php">
			 <input type="hidden" name = "action" value="search1">
			 <input class = "search" name = "search1" autofocus type="search" placeholder="search" required>
			 <input class = "search2" type="submit" value="Search">
		 </form>
	</article>
	<table style="margin-top: 50px;">
		 </form>
		<tr>
			<th>Employee ID</th>
			<th>Name</th>
			<th>Position</th>
			<th>Address</th>
			<th>Action</th>
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
			<?php if($row['status'] == 'Active') ?>
			<td><?php echo $pos['Pname']; ?></td>
			<td><?php echo $row['Address'] ?></td>
			<td>
				<a class = "update" href="?action=update_employees&id=<?php echo $row['id']; ?>">
				<img src="images/update.png"> Edit</a>
				<?php if($row['status'] == 'Active'){ ?>
					<a class = "update" href="?action=disable_employees&id=<?php echo $row['id']; ?>">
					<img src="images/disable.png"> Deactivate</a>
				<?php }
				else{ ?>
					<a class = "update" href="?action=enable_employees&id=<?php echo $row['id']; ?>">
					<img src="images/enable.png"> Activate</a>
				<?php } ?>
			</td>
		</tr>
		<?php 
			$c = $c + 1;
		} ?>
	</table>
</article>