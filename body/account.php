<h2>My Account</h2>
		<?php 

			$prep = getEmpInfo($_SESSION['user_id']);
			$row = mysql_fetch_array($prep);
			$mi = str_split($row['Mname']);
			$prep = $row['Fname'] . " " . $mi[0] . ". ". $row['Lname'];
			$add = $row['Address'];

			$res = getUname($row['id']);
			$u = mysql_fetch_array($res);
			$uname = $u['username'];

			$row = getPos($row['Position']);
			$pos = mysql_fetch_array($row);
			$position = $pos['Pname'];

		?> 
<article class="pos_main">
<article class="account3" style="float: left; margin-right: 0px; margin-left: 10px;">
	<hr>My Account<hr>
	<label>Name: </label><label class="account"><?php echo $prep; ?></label><hr>
	<label>Username: </label><label class="account"><?php echo $uname; ?></label><hr>
	<label>Position: </label><label class="account"><?php echo $position; ?></label><hr>
	<label>Address: </label><label class="account"><?php echo $add; ?></label><hr>
</article>
		<form class="pos_form" method="post" action="home.php" style="width: 70%;">
			<input	type="hidden" name="action" value="username">
			<label class="title">Change Username</label><hr>
			<label class="pos">Username</label>
			<br><br>
			<input class="deduct_text" type="text" name="uname" 
				   placeholder="Username" required value="<?php echo $uname; ?>">
			<br><br><br>
			<input class="button" type="submit" name = "submit" value="Save Username">
		</form>
		<form class="pos_form" method="post" action="home.php" style="width: 70%;">
			<input	type="hidden" name="action" value="change_account">
			<label class="title">Change Password</label><hr>

			<label class="pos">Old Password</label>
			<br><br>
			<input id = "op" class="deduct_text" type="Password" name="op" placeholder="Password" autofocus required>
			<br><br>

			<label class="pos">New Password</label>
			<br><br>
			<input class="deduct_text" type="Password" name="np" placeholder="Password" required>
			<br><br>

			<label class="pos">Re-type Password</label>
			<br><br>
			<input class="deduct_text" type="Password" name="rtp" placeholder="Password" required>
			<br><br><br><br>
			<input class="button" type="submit" name = "submit" value="Save Password">

		</form>
</article>