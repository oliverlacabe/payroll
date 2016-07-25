<h2>Add User</h2>
<article class="pos_main">
<article class="account3" style="float: left; margin-left: 10px;">
	<hr><img src="images/add.png">Select from the list to add user<hr>
		<label class="title">Managers</label><hr>
		<?php 
		if (isset($uid)){
			if ($uid == "") {
				$label = "Select Employee";
				$fname = "";
			}
			else{
				$p = getName($uid);
				$row = mysql_fetch_array($p);
				$mi = str_split($row['Mname']);
				$label = $row['Fname'] . " " . $mi[0] . ". ". $row['Lname']; 
				$fname = $row['Fname'];
			}
		}
		else if(isset($_GET['id'])){
			$uid = $_GET['id'];
			$p = getName($uid);
			$row = mysql_fetch_array($p);
			$mi = str_split($row['Mname']);
			$label = $row['Fname'] . " " . $mi[0] . ". ". $row['Lname']; 
			$fname = $row['Fname'];
		}
		else{
			$label = "Select Employee";
			$fname = "";
			$uid = "";
		}
		$res = getManagers();
		while ($row = mysql_fetch_array($res)) {
			$result = checkID($row['id']);
			$r = mysql_fetch_array($result);
			if ($r[0] == 0) {
		?> 
			<a class = "user" href = "?action=add_user&id=<?php echo $row['id']; ?>">
				<?php $mi = str_split($row['Mname']); echo $row['Fname'] . " " . $mi[0] . ". ". $row['Lname']; ?> 
			</a>
		<?php }} ?>

		<label class="title">Supervisors</label><hr>
		<?php 
		$res = getSupervisors();
		while ($row = mysql_fetch_array($res)) {
			$result = checkID($row['id']);
			$r = mysql_fetch_array($result);
			if ($r[0] == 0) {
		?> 
			<a class="user" href = "?action=add_user&id=<?php echo $row['id']; ?>">
				<?php $mi = str_split($row['Mname']); echo $row['Fname'] . " " . $mi[0] . ". ". $row['Lname']; ?> 
			</a>
		<?php }} ?>
</article>

		<form class="pos_form" method="post" action="home.php" style="float: left; width: 50%;">
			<input	type="hidden" name="action" value="add_user">
			<input	type="hidden" name="user_ID" value="<?php echo $uid; ?>">
			<label class="title"><?php echo $label;?></label><hr>
			<label class="pos">Username</label>
			<br><br>
			<input class="deduct_text" type="text" autofocus name="uname" value = "<?php echo $fname; ?>" placeholder="Username" required>
			<br><br>

			<label class="pos">New Password</label>
			<br><br>
			<input class="deduct_text" type="Password" name="p" placeholder="Password" required>
			<br><br>

			<label class="pos">Re-type Password</label>
			<br><br>
			<input class="deduct_text" type="Password" name="rtp" placeholder="Password" required>
			<br><br><br><br>
			<input class="button" type="submit" name = "submit" value="Add User">
			<input class="button" type="button" onclick="location.href = '?action=add_user'" value="Clear">

		</form>

<article class="account3">
	<hr><img src="images/reg.png">Registered Users<hr>
		<label class="title">Managers</label><hr>

		<?php 
		$res = getManagers2();
		while ($row = mysql_fetch_array($res)) {?> 
				<label class="user"> <?php $mi = str_split($row['Mname']); echo $row['Fname'] . " " . $mi[0] . ". ". $row['Lname']; ?> </label> 
		<?php } ?>

		<label class="title">Supervisors</label><hr>
		<?php 
		$res = getSupervisors2();
		while ($row = mysql_fetch_array($res)) {?> 
				<label class="user"> <?php $mi = str_split($row['Mname']); echo $row['Fname'] . " " . $mi[0] . ". ". $row['Lname']; ?> </label> 

		<?php } ?>
</article>
</article>