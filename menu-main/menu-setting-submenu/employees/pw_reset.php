<?php 
	include 'config.php';
	echo "<link href=\"css/alertwindow.css\" rel=\"stylesheet\" type=\"text/css\" media=\"all\"/>";

	$user_id = $_POST['hidd_userid'];
	$pw_reset = md5('1234');

	$query = "UPDATE `users` SET `password` = '$pw_reset' WHERE id='$user_id';";
	$result = mysql_query($query) or die(mysql_error());


	include "index.php";
	echo "
	<div id='alertwindow'></div>';
	<script type=\"text/javascript\">
	setTimeout('window.location.href=\"index.php\"', 1500);
	document.getElementById('alertwindow').innerHTML = '<h1>Jelszó alapértelmezettre állítva!</h1>';
	document.getElementById('alertwindow').style.display = 'block';
	</script>";
 ?>