<?php 
	include 'config.php';

	$user_id = $_GET['user_id'];
	$pw_reset = md5('1234');

	$query = "UPDATE `users` SET `password` = '$pw_reset' WHERE id='$user_id';";
	$result = mysql_query($query) or die(mysql_error());


	echo "
	<script type=\"text/javascript\">
	setTimeout('document.getElementById(\"alertwindow\").style.display = \"none\"', 1500);
	document.getElementById('alertwindow').innerHTML = '<h1>Jelszó alapértelmezettre állítva!</h1>';
	document.getElementById('alertwindow').style.display = 'block';
	</script>";
 ?>