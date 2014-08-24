<?php
	include '../../../config.php';
	$endprice = 0;
	$ind = 1;
	for ($i=0; $i < $_GET['wreathNum']; $i++) { 

		$query = "SELECT `sale_price` FROM `special_wreath` WHERE name='".$_GET['wreath'.$ind]."'";
		$result = mysql_query($query) or die(mysql_error());

		while ($row = mysql_fetch_assoc($result)) {
			$endprice += $row['sale_price'];
		}
		
		if (isset($_GET['ribbon'.$ind])) {
			$query_ribbon = "SELECT price FROM  `ribbon_type` WHERE type='".$_GET['ribbon'.$ind]."'";
			$result_ribbon = mysql_query($query_ribbon) or die(mysql_error());

			while ($row = mysql_fetch_assoc($result_ribbon)) {
				$endprice += $row['price'];
			}
		}

		if (isset($_GET['ribboncolor'.$ind])) {
			$query_rcolor = "SELECT `price` FROM `ribbon_color` WHERE color='".$_GET['ribboncolor'.$ind]."'";
			$result_rcolor = mysql_query($query_rcolor) or die(mysql_error());

			while ($row = mysql_fetch_assoc($result_rcolor)) {
				$endprice += $row['price'];
			}
		}
		
		$ind++;
	}

	$ind = 1;
	for ($i=0; $i < $_GET['offerNum']; $i++) { 
		
		$query = "SELECT `sale_price` FROM `offer_wreath` WHERE name='".$_GET['offer'.$ind]."'";
		$result = mysql_query($query) or die(mysql_error());

		while ($row = mysql_fetch_assoc($result)) {
			$endprice += $row['sale_price'];
		}
		
		if (isset($_GET['offerribbon'.$ind])) {
			$query_ribbon = "SELECT price FROM  `ribbon_type` WHERE type='".$_GET['offerribbon'.$ind]."'";
			$result_ribbon = mysql_query($query_ribbon) or die(mysql_error());

			while ($row = mysql_fetch_assoc($result_ribbon)) {
				$endprice += $row['price'];
			}
		}

		if (isset($_GET['offerribboncolor'.$ind])) {
			$query_rcolor = "SELECT `price` FROM `ribbon_color` WHERE color='".$_GET['offerribboncolor'.$ind]."'";
			$result_rcolor = mysql_query($query_rcolor) or die(mysql_error());

			while ($row = mysql_fetch_assoc($result_rcolor)) {
				$endprice += $row['price'];
			}
		}
		
		$ind++;
	}

	echo number_format($endprice, 0, ',', ' ');
?>