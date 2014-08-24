<?php 
	include '../../../config.php';
	$leaf = $_GET['leaf'];
	$result = mysql_query("SELECT price FROM `flower` WHERE type='levél' AND color='$leaf'") or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		echo $row['price'];
	}
?>