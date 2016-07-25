
	<article class = "login">
	<label class="close" onclick="location.href = '?action=main'"></label><hr>
		<form method = "POST" name="login_form">
			<input	type = "hidden" name = "action" value = "login">
			<label class = "login">Username</label>
			<input class = "text2" type="text" name = "username" autofocus placeholder="Enter Username" required > 
			<label class = "login">Password</label>
			<input class = "text2" type="password" name = "password" placeholder="Enter Password" required>
			<input class = "button" type="submit" onclick="return checkUser();" name = "submit" value="Login">
			<input class = "button" type="reset" name = "reset" value="Clear">
		</form>
	</article>