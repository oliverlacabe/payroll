
	<h2>Add Employees</h2>
	<form method="post" action="home.php" class="add_user">
		<input	type="hidden" name="action" value="add_employee">
		<label>Firstname</label>
		<input class = "text"	type="text" name="firstname" placeholder="Firstname" required>
		<label>Lastname</label>
		<input class = "text"	type="text" name="lastname" placeholder="Lastname" required>
		<label>Middlename</label>
		<input class = "text"	type="text" name="middlename" placeholder="Middlename" required>
		<label>Position</label>
		<select name = "position" required>
		<?php while ($row = mysql_fetch_array($Pname)) {?> 
			<option value = "<?php echo $row['pid']; ?>"> 
				<?php echo $row['Pname']; ?>
			</option>
		<?php } ?>
		</select>
		<label>Address</label>
		<textarea name="address" placeholder="Address" required></textarea>
		<input class = "button" type="submit" name = "submit" value="Add">
		<input class = "button" type="reset" name = "reset" value="Clear">
	</form>

