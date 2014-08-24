<?php
	session_start();

	$_SESSION['fullprice'] = 0;

	$fullprice = ($_SESSION['wprice'] + $_SESSION['fprice'] + $_SESSION['lprice'] + 1000)*1.1111;
	$_SESSION['fullprice'] = round($fullprice/100) * 100;
	
	echo number_format($_SESSION['fullprice'], 0, '', ' ') . " Ft";
?>