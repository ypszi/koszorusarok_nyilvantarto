<?php
	session_start();
	include '../../../config.php';

	$_SESSION['price'] = 0;

	$wtype = $_GET['wtype'];
	$wsize = $_GET['wsize'];
	$fname = "";
	$fcolor = "";
	$qty = "";
	$leaf = "";
	$leafqty = "";

	$_SESSION['wprice'] = 0;

	$wquery = "SELECT price FROM `base_wreath` WHERE TYPE = 
	( SELECT id FROM `base_wreath_type` WHERE TYPE = '$wtype' ) AND size='$wsize';";
	$wresult = mysql_query($wquery) or die (mysql_error());
	
	while ($wrow = mysql_fetch_assoc($wresult)) {
		$_SESSION['wprice']=$wrow['price'];
	}

	if (isset($_GET['flowernum'])) $_SESSION['flowers'] = $_GET['flowernum'];
	$flowernum = $_SESSION['flowers'];

	$_SESSION['fprice'] = 0;

	for ($i=0; $i < $_SESSION['flowers']; $i++) { 
		$fname = $_GET['flower'.($i+1)];
		$fcolor = $_GET['color'.($i+1)];
		$qty = $_GET['qty'.($i+1)];
		
		$fquery = "SELECT price*$qty as price FROM `flower` WHERE type='$fname' AND color='$fcolor';";
		$fresult = mysql_query($fquery) or die (mysql_error());

		while ($frow = mysql_fetch_assoc($fresult)) {
			$_SESSION['fprice'] += $frow['price'];
		}
	}

	if (isset($_GET['leafnum'])) $_SESSION['leafs'] = $_GET['leafnum'];
	$leafnum = $_SESSION['leafs'];

	$_SESSION['lprice'] = 0;

	for ($i=0; $i < $_SESSION['leafs']; $i++) { 
		$leaf = $_GET['leaf'.($i+1)];
		$leafqty = $_GET['leafqty'.($i+1)];
		
		$lquery = "SELECT price*$leafqty as price FROM `flower` WHERE color='$leaf';";
		$lresult = mysql_query($lquery) or die (mysql_error());

		while ($lrow = mysql_fetch_assoc($lresult)) {
			$_SESSION['lprice'] += $lrow['price'];
		}
	}

	$isrezgo = $_GET['rezgo'];

	$rezgoprice = 0;

	if ($isrezgo == "true") {

		$rezgoqty = $_GET['rezgoqty'];
		$rquery = "SELECT price FROM `flower` WHERE TYPE = 'rezgo';";
		$rresult = mysql_query($rquery) or die (mysql_error());
		
		while ($rrow = mysql_fetch_assoc($rresult)) {
			$rezgoprice=$rrow['price'];
		}
		$_SESSION['lprice'] = $_SESSION['lprice'] + $rezgoprice*$rezgoqty;
	}
	
	$_SESSION['price'] = $_SESSION['wprice'] + $_SESSION['fprice'] + $_SESSION['lprice'];
	
	echo number_format($_SESSION['price'], 0, '', ' ') . ' Ft';
?>