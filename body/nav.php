	<section class = "header">
	<nav class = "menu">
		<img src="images/logo.png">
		<ul>
			<li><a><img src="images/acc.png">&nbsp; <?php 
				$res = getUname($_SESSION['user_id']);
				$u = mysql_fetch_array($res);
				echo "+ ".$u['username'];
			 ?></a>
				<ul>
					<li><a href="?action=account">My Account Settings</a></li>
					<li><a href="?action=display_login_form">Logout</a></li>
				</ul>
			</li>
			<li><a href="?action=home"><img src="images/home.png">&nbsp; Home</a></li>
			<li><a><img src="images/emp.png"> &nbsp; Manage</a>
				<ul>
					<li><a href="?action=employees">Add Employees</a></li>
					<li><a href="?action=update_form">Update Employees</a></li>
					<li><a href="?action=position">Position Management</a></li>
					<li><a href="?action=add_user">Add User</a></li>
				</ul>
			</li>
			<li><a href="?action=payroll"><img src="images/p.png">&nbsp; Payroll</a></li>
		</ul>
	</nav>
	</section>
	<section class = "body">