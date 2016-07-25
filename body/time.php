<section class="time">
	<label class="close" onclick="location.href = 'index.php?action=main'"></label>
	<label id = "txt"></label>
	<form class="d" method="post" action="index.php">
		<input type="hidden" name="action" value="add_time">
		<label>Enter your ID</label><br><br>
		<input class="text2" type="text" name="emp" autofocus="autofocus" placeholder="Enter Employee ID " required>
		<input class="button" type="submit" value="Enter">
	</form>
</section>