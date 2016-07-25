	<h2>Update Employees</h2>
	<?php 
		if(!isset($empInfo)){
			$fname = "";
			$lname = "";
			$mname = "";
			$add = "";
			$pos = "";
		}
		else{
			$row = mysql_fetch_array($empInfo);
			$id = $row['id'];
			$fname = $row['Fname'];
			$lname = $row['Lname'];
			$mname = $row['Mname'];
			$add = $row['Address'];
			$pos = $row['Position'];
		} 
	 ?>

	<form method="post" action="home.php" class="add_user">
		<input	type="hidden" name="action" value="update_for_real_na">
		<input	type="hidden" name="id" value="<?php echo $id; ?>">
		<label>Firstname</label>
		<input class = "text" type="text" name="firstname" placeholder="Firstname"
				 value="<?php echo $fname; ?>" required>
		<label>Lastname</label>
		<input class = "text"	type="text" name="lastname" placeholder="Lastname"
				value="<?php echo $lname; ?>" required>
		<label>Middlename</label>
		<input class = "text"	type="text" name="middlename" placeholder="Middlename"
				value="<?php echo $mname; ?>" required>
		<label>Position</label>
		<select name = "position" >
		<?php while ($row = mysql_fetch_array($Pname))  {
			if ($row['pid'] == $pos ){?> 
				<option value = "<?php echo $row['pid']; ?>" selected> 
					<?php echo $row['Pname']; ?>
				</option>
			<?php } else{?>
				<option value = "<?php echo $row['pid']; ?>"> 
					<?php echo $row['Pname']; ?>
				</option>
			<?php } ?>
		<?php } ?>
		</select>
		<label>Address</label>
		<textarea name="address" placeholder="Address" required><?php echo $add; ?></textarea>
		<input class = "button" type="submit" name = "submit" value="Update">
		<input class="button" type="button" onclick="location.href = '?action=update_form'" value="Clear">
	</form>