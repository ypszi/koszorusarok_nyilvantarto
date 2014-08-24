<?php
	session_start();
	include '../../../config.php';

	$offer_price = 0;

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

	for ($i=0; $i < $flowernum; $i++) { 
		$fname = $_GET['flower'.($i+1)];
		$fcolor = $_GET['color'.($i+1)];
		$qty = $_GET['qty'.($i+1)];
		$itemprice = $_GET['itemprice'.($i+1)];

		if ($itemprice == "") {
			$fquery = "SELECT price*$qty as price FROM `flower` WHERE type='$fname' AND color='$fcolor';";
			$fresult = mysql_query($fquery) or die (mysql_error());

			while ($frow = mysql_fetch_assoc($fresult)) {
				$_SESSION['fprice'] += $frow['price'];
			}
		} else {
			$_SESSION['fprice'] += $itemprice*$qty;
		}
	}

	if (isset($_GET['leafnum'])) $_SESSION['leafs'] = $_GET['leafnum'];
	$leafnum = $_SESSION['leafs'];

	$_SESSION['lprice'] = 0;

	for ($i=0; $i < $leafnum; $i++) { 
		$leaf = $_GET['leaf'.($i+1)];
		$leafqty = $_GET['leafqty'.($i+1)];
		$leafitemprice = $_GET['leafitemprice'.($i+1)];
		
		if ($leafitemprice == "") {
			$lquery = "SELECT price*$leafqty as price FROM `flower` WHERE color='$leaf';";
			$lresult = mysql_query($lquery) or die (mysql_error());

			while ($lrow = mysql_fetch_assoc($lresult)) {
				$_SESSION['lprice'] += $lrow['price'];
			}
		} else {
			$_SESSION['lprice'] += $leafitemprice*$leafqty;
		}
	}

	$isrezgo = $_GET['rezgo'];

	$rezgoprice = 0;

	if ($isrezgo == "true") {

		$rezgoqty = $_GET['rezgoqty'];
		$rquery = "SELECT price FROM `flower` WHERE TYPE = 'rezgo';";
		$rresult = mysql_query($rquery) or die (mysql_error());
		
		while ($rrow = mysql_fetch_assoc($rresult)) {
			$rezgoprice = $rrow['price'];
		}
		$_SESSION['lprice'] = $_SESSION['lprice'] + $rezgoprice*$rezgoqty;
	}

	$isOfferribbon = ($_GET['isOfferribbon'] == "true") ? true : false;
	$ribbon_price = 0;
	if ($isOfferribbon) {
		$ribbon_type = $_GET['offerribbon'];
		$ribbon_color = $_GET['offerribboncolor'];
		if ($_GET['ribbonprice'] > 0) {
			$ribbon_price = $_GET['ribbonprice'];
		} else {
			$ribquery = "SELECT `price` FROM  `ribbon_type` WHERE type = '$ribbon_type';";
			$ribresult = mysql_query($ribquery) or die (mysql_error());
			while ($row = mysql_fetch_assoc($ribresult)) {
				$ribbon_price += $row['price'];
			}
			$ribquery = "SELECT `price` FROM  `ribbon_color` WHERE color = '$ribbon_color';";
			$ribresult = mysql_query($ribquery) or die (mysql_error());
			while ($row = mysql_fetch_assoc($ribresult)) {
				$ribbon_price += $row['price'];
			}
		}
		$_SESSION['rprice'] = $ribbon_price;
	} else {
		$_SESSION['rprice'] = 0;
	}
	
	$offer_price = $_SESSION['wprice'] + $_SESSION['fprice'] + $_SESSION['lprice'] + $_SESSION['rprice'];
	
	echo number_format($offer_price, 0, '', ' ') . ' Ft';
?>