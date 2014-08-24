<?php 
	include '../../../config.php';
	$ribbontype = $_GET['ribbontype'];
	$ribboncolor = $_GET['ribboncolor'];
	$ribbonprice = 0;
	$result = mysql_query("SELECT price FROM  `ribbon_type` WHERE type='$ribbontype'") or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		$ribbonprice = $row['price'];
	}
	$result = mysql_query("SELECT price FROM  `ribbon_color` WHERE color='$ribboncolor'") or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		$ribbonprice += $row['price'];
	}
	echo $ribbonprice;
?>