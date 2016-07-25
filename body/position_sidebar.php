<h2>Position Management</h2>
<article class="pos_main">
<article class="sidebar">
		<form style="padding: 20px 30px 20px 20px; overflow: hidden;" method="post" action="home.php">
			<input	type="hidden" name="action" value="add_position">
			<label class="pos">Create Position</label>
			<input class="pos" type="text" autofocus name="pname" placeholder="Enter Position Name" required>
			<input class="pos1" type="submit" name = "submit" value="Create">
		</form>
		<hr>
		<?php while ($row = mysql_fetch_array($Pname)) {?> 

			<a class="side" href = "?action=position&pid=<?php echo $row['pid']; ?>"> 
				<label class="side"> <?php echo $row['Pname']; ?> </label> 
			</a>
		<?php } ?>
</article>
			<?php 

				if (isset($check)){
					$yes = 0;
					$position = "";
					$salary = "";
					$s = "";
					$p = "";
					$h = "";
				}
				else if (isset($_POST['pid'])){
					$pid = $_POST['pid'];
					$yes = 1;
					$pos = getPos($pid);
					$row = mysql_fetch_array($pos);
					$position = $row['Pname'];
				}
				else if (isset($_GET['pid'])){
					$pid = $_GET['pid'];
					$yes = 1;
					$pos = getPos($pid);
					$row = mysql_fetch_array($pos);
					$position = $row['Pname'];
					$salary = $row['Salary'];

					$deduct = getDeduct($pid, 1); $deduct = mysql_fetch_array($deduct);
					$s = $deduct['Amount'];
					$deduct = getDeduct($pid, 2); $deduct = mysql_fetch_array($deduct);
					$p = $deduct['Amount'];
					$deduct = getDeduct($pid, 3); $deduct = mysql_fetch_array($deduct);
					$h = $deduct['Amount'];
				}
				else{
					$yes = 0;
					$position = "";
					$salary = "";
					$s = "";
					$p = "";
					$h = "";
				}


			 ?> 
		<article class="delete_form">
			<label style="font-size: 16px; font-weight: bolder; margin-top: -3px; width: 70%;"><?php echo $row['Pname'];?></label>
			<?php if ($yes == 1) { ?>
				<a class = "delete" href="?action=delete_position&pid=<?php echo $pid; ?>" 
				onclick="return confirm('Are you sure you want to delete this position?');">
				<img src="images/disable.png">  Delete Position</a>
			<?php } ?>
		</article>
		<form class="pos_form" method="post" action="home.php">
			<input	type="hidden" name="action" value="deductions">
			<input	type="hidden" name="pid" value="<?php echo $pid ?>">
			<label class="title">Position Details</label><hr>
			<label class="pos">Position Name</label>
			<br><br>
			<input class="deduct_text" type="text" name="pname" 
				   placeholder="Position" required value="<?php echo $position;?>">
			<br><br>
			<label class="pos">Salary</label>
			<br><br>
			<input class="deduct_text" type="number" name="salary" 
				   placeholder="Enter Salary" required value="<?php echo $salary; ?>">

			<br><br><br><br>
			<label class="title">Insurance Deductions</label><hr>
			<label class="pos">Social Security System (SSS)</label>
			<br><br>
			<input class="deduct_text" type="number" name="sss" value="<?php  echo $s; ?>" 
				   placeholder="Enter deduction amount" required>
			<br><br>

			<label class="pos">Philhealth</label>
			<br><br>
			<input class="deduct_text" type="number" name="philhealth" value="<?php  echo $h; ?>"
				   placeholder="Enter deduction amount" required>
			<br><br>

			<label class="pos">Pagibig</label>
			<br><br>
			<input class="deduct_text" type="number" name="pagibig" value="<?php  echo $p; ?>"
				   placeholder="Enter deduction amount" required>
			<br><br><br><br>
			<input class="button" type="submit" name = "submit" value="Save Changes">
			<input class="button" type="button" onclick="location.href = '?action=position'" value="Clear">

		</form>
</article>