<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
	<title>Gleen Marketing - Automated Payroll System</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<link rel="Icon" type="image/png" href="images/icon.png">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script>
	function startTimer(){
		var today = new Date();
		var h = today.getHours();
		var m = today.getMinutes();
		var s = today.getSeconds();

		// if (h == 0 ) { h = 12;};
		// if (h > 12) { h = h - 12};

		m = checkTime(m);
		s = checkTime(s);
		h = checkTime(h);

		document.getElementById('txt').innerHTML = h+": "+m+": "+s

		var t = setTimeout(function(){startTimer()},500);
	}

	function checkTime(i){
		if(i < 10){ i = "0" + i;}
		return i;
	}
	</script>
</head>
<body onload="startTimer()">
