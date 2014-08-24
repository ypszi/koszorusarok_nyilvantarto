<?php 
	session_start();
	include '../../../config.php';
?>
<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all"/>
<?php
	$new_password = md5($_POST['new_pw']);

	echo '<div id="alertwindow"></div>';

	$query = "SELECT password FROM users WHERE id = ".$_SESSION['logged_in'];
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		$old_pw = $row['password'];
	}

	$oldpw_md5 = md5($_POST['old_pw']);
	if ($old_pw != $oldpw_md5) {
		echo "<script type=\"text/javascript\">
		document.getElementById('alertwindow').innerHTML += '<h1>Régi jelszó hibás!</h1>';
		document.getElementById('alertwindow').style.display = 'block';
		setTimeout('window.location.href=\"../../../index.php?page=beallitas\"', 1500);
		</script>";
	} else {
		$query = "UPDATE `users` SET password = '$new_password' WHERE id=".$_SESSION['logged_in']."";
		$result = mysql_query($query) or die(mysql_error());

		echo "<script type=\"text/javascript\">
			document.getElementById('alertwindow').innerHTML += '<h1>Jelszó változtatás sikeres!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"../../../index.php?page=beallitas\"', 1500);
			</script>";
		}
?>