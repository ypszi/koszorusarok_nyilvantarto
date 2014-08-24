<?php
	if (!isset($_SESSION['logged_in'])) {
		session_start();
	}
	
	echo "<link href=\"css/alertwindow.css\" rel=\"stylesheet\" type=\"text/css\" media=\"all\"/>";

	include "config.php";

	$user_id = $_POST['user_id'];
	$password = $_POST['password'];

	$query = "SELECT * FROM `users` WHERE id='$user_id';";

	$result = mysql_query($query) or die(mysql_error());
	$rows = mysql_num_rows($result);


	echo'<div id="alertwindow"></div>';

	if ($rows==1) {
		$row = mysql_fetch_array($result);

		if (strcmp($row['password'],md5($password))==0) {
			$_SESSION['logged_in']=$user_id;
			include "index.php";
			echo "<script type=\"text/javascript\">
			setTimeout('window.location.href=\"index.php\"', 1500);
			document.getElementById('alertwindow').innerHTML = '<h1>Sikeres Bejelentkezés</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			</script>";
		}
		else {
			session_destroy();
			include "index.php";
			echo "<script type=\"text/javascript\">
			setTimeout('window.location.href=\"index.php\"', 1500);
			document.getElementById('alertwindow').innerHTML = '<h1>Rossz jelszót adott meg</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			</script>";
		}
	}

?>