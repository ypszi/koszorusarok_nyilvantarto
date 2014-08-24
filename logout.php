<?php
	session_start();

	echo "<link href=\"css/alertwindow.css\" rel=\"stylesheet\" type=\"text/css\" media=\"all\"/>";

	echo'<div id="alertwindow"></div>';

	if(isset($_SESSION['logged_in'])) {
		session_destroy();
		echo "<script type=\"text/javascript\">
			setTimeout('window.location.href=\"index.php\"', 1500);
			document.getElementById('alertwindow').innerHTML = '<h1>Sikeres Kijelentkez&eacute;s</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			</script>";
		
	}
	else {
		echo "<script type=\"text/javascript\">
			setTimeout('window.location.href=\"index.php\"', 1500);
			document.getElementById('alertwindow').innerHTML = '<h1>Nem vagy bejelentkezve</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			</script>";
		include "index.php";
	}
?>