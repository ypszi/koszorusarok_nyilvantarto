<?php 
	include '../../../config.php';
	$ftype = $_GET['ftype'];
	$fcolor = $_GET['fcolor'];
	$result = mysql_query("SELECT price FROM `flower` WHERE type='$ftype' AND color='$fcolor'") or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		echo $row['price'];
	}
?>