<?php session_start(); include '../../../config.php'; ?>
<link href="../../../css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
<div id='alertwindow'></div>

<?php 
	$old_id = $_POST['old_id'];
	$old_deadname = $_POST['old_deadname'];
	$old_ritual_time = $_POST['old_ritual_time'];
	$old_shipment = $_POST['old_shipment'];
	$old_clocation = $_POST['old_clocation'];
	$old_caddress = $_POST['old_caddress'];
	$old_cfuneral = $_POST['old_cfuneral'];
	$old_customer_name = $_POST['old_customer_name'];
	$old_phone_number = $_POST['old_phone_number'];
	$old_email = $_POST['old_email'];
	$old_create_time = $_POST['old_create_time'];
	$old_worker_id = $_POST['old_worker_id'];
	$old_note = $_POST['old_note'];
	$old_price = $_POST['old_price'];
	$old_downprice = $_POST['old_downprice'];
	$old_ship_price = $_POST['old_ship_price'];
	$old_paid = $_POST['old_paid'];
	$old_shop = $_POST['old_shop'];
	$old_maker_shop = $_POST['old_maker_shop'];
	$old_archive = $_POST['old_archive'];
	$query = "UPDATE `orders` SET archive = 1 WHERE id=$old_id;";
	$result = mysql_query($query) or die(mysql_error());

	$deadname = $_POST['deadname'];
	$ritual_time = $_POST['ritual_time'];
	$shipment = $_POST['shipment'];
	if ($shipment == "Egyedi helyszín") {
			$clocation = $_POST['c_location'];
			$caddress = $_POST['c_address'];
			$cfuneral = $_POST['c_funeral'];
	} else {
		$clocation = "";
		$caddress = "";
		$cfuneral = "";
	}
	$customer_name = $_POST['customer_name'];
	$phone_number = $_POST['phone_number'];
	$email = $_POST['email'];
	$note = $_POST['note'];
	$price = str_replace(' ', '', $_POST['price']);
	$downprice = str_replace(' ', '', $_POST['downprice']);
	$ship_price = str_replace(' ', '', $_POST['ship_price']);
	if (isset($_POST['paid'])) {
		if ($old_paid == "") { // a form value üresség miatt nem NULL, hanem üres string
			$paid = date("Y-m-d");
		} else {
			$paid = $old_paid;
		}
	} else {
		$paid = 'NULL';
	}
	$maker_shop = $_POST['maker_shop'];

	$logged_user = $_SESSION['logged_in'];
	$user_result = mysql_query("SELECT id FROM `users` WHERE id = $logged_user") or die(mysql_error());
	while ($row = mysql_fetch_assoc($user_result)) {
		$uploader = $row['id'];
	}

	$date = date_create();
	$mod_time = date_format($date, 'Y-m-d H:i:s');

	// Shop marad - A rendelés felvételi helye nem változik
	if ($paid == 'NULL') {
		$query = "INSERT INTO `orders` 
		(deadname, ritual_time, shipment, clocation, caddress, cfuneral, customer_name, phone_number, email, create_time, mod_time, worker_id, note, price, downprice, ship_price, paid, shop, maker_shop, archive) 
			VALUES 
		('$deadname', '$ritual_time', '$shipment', '$clocation', '$caddress', '$cfuneral', '$customer_name', '$phone_number', '$email', '$old_create_time','$mod_time', '$uploader', '$note', '$price', '$downprice', '$ship_price', $paid, '$old_shop', '$maker_shop', 0); ";
	} else { // NULL értéknél nem kell idézőjel, dátumnál KELL
		$query = "INSERT INTO `orders` 
		(deadname, ritual_time, shipment, clocation, caddress, cfuneral, customer_name, phone_number, email, create_time, mod_time, worker_id, note, price, downprice, ship_price, paid, shop, maker_shop, archive) 
			VALUES 
		('$deadname', '$ritual_time', '$shipment', '$clocation', '$caddress', '$cfuneral', '$customer_name', '$phone_number', '$email', '$old_create_time','$mod_time', '$uploader', '$note', '$price', '$downprice', '$ship_price', '$paid', '$old_shop', '$maker_shop', 0); ";
	}
	
	$result = mysql_query($query) or die(mysql_error());
	$query_orderid = "SELECT id FROM `orders` ORDER BY id DESC LIMIT 0,1";
	$result_orderid = mysql_query($query_orderid) or die(mysql_error());
	$resultnum = mysql_num_rows($result_orderid); 
	if ($resultnum < 1) { 
		$order_id = 1;
	} else {
		while ($row = mysql_fetch_assoc($result_orderid)) {
			$order_id = $row['id'];
		}
	}

	$ind = 1;
	for ($i=0; $i < $_POST['wreathnum']; $i++) { 
		$wreath[$ind] = $_POST['wreath'.$ind];
		$azonosito[$ind] = $_POST['azonosito'.$ind];
		if (isset($_POST['isRibbon'.$ind])) {
			$ribbon[$ind] = $_POST['ribbon'.$ind];
			$ribboncolor[$ind] = $_POST['ribboncolor'.$ind];
			$farewelltext[$ind] = $_POST['farewelltext'.$ind];
			$givers[$ind] = $_POST['givers'.$ind];
		} else {
			$ribbon[$ind] = "";
			$ribboncolor[$ind] = "";
			$farewelltext[$ind] = "";
			$givers[$ind] = "";
		}
		$ind++;
	}

	$ind = 1;
	for ($i=0; $i < $_POST['offernum']; $i++) { 
		$offer[$ind] = $_POST['offer'.$ind];
		$offerazonosito[$ind] = $_POST['offerazonosito'.$ind];
		$ind++;
	}

	$ind = 1;
	for ($i=0; $i < $_POST['wreathnum']; $i++) { 
		if (isset($_POST['isRibbon'.$ind])) {
			$ribbon_price = 0;

			$ribquery = "SELECT `price` FROM  `ribbon_type` WHERE type = '".$ribbon[$ind]."';";
			$ribresult = mysql_query($ribquery) or die (mysql_error());
			while ($row = mysql_fetch_assoc($ribresult)) {
				$ribbon_price = $row['price'];
			}
			$ribquery = "SELECT `price` FROM  `ribbon_color` WHERE color = '".$ribboncolor[$ind]."';";
			$ribresult = mysql_query($ribquery) or die (mysql_error());
			while ($row = mysql_fetch_assoc($ribresult)) {
				$ribbon_price += $row['price'];
			}

			$query_ribb = "INSERT INTO `ribbons` (`ribbon`, `ribboncolor`, `farewelltext`, `givers`, `price`) 
										VALUES ('".$ribbon[$ind]."', '".$ribboncolor[$ind]."', '".$farewelltext[$ind]."', '".$givers[$ind]."', '$ribbon_price')";
			$result_ribb = mysql_query($query_ribb, $conn) or die(mysql_error());
			$ribbonid = mysql_insert_id();
		} else {
			$ribbonid = 'NULL';
		}
		$query = "INSERT INTO `order_items` 
		(order_id, is_offer, wreath_name, azonosito, ribbon_id) 
			VALUES 
		('$order_id', '0', '".$wreath[$ind]."', '".$azonosito[$ind]."', ".$ribbonid.")";
		$result = mysql_query($query) or die(mysql_error());
		$ind++;
	}

	$ind = 1;
	for ($i=0; $i < $_POST['offernum']; $i++) { 

		$query_ribbid = "SELECT ribbon_id FROM `offer_wreath` WHERE name = '".$offer[$ind]."';";
		$result_ribbid = mysql_query($query_ribbid) or die(mysql_error());
		while ($row = mysql_fetch_assoc($result_ribbid)) {
			if ($row['ribbon_id'] === NULL) {
				$offer_ribbonid[$ind] = 'NULL';
			} else {
				$offer_ribbonid[$ind] = $row['ribbon_id'];
			}
		}

		$query = "INSERT INTO `order_items` 
		(order_id, is_offer, wreath_name, azonosito, ribbon_id) 
			VALUES 
		('$order_id', '1', '".$offer[$ind]."', '".$offerazonosito[$ind]."', ".$offer_ribbonid[$ind].")";
		$result = mysql_query($query) or die(mysql_error());
		$ind++;
	}
?>

<?php 
	echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Rendel&eacute;s sikeresen m&oacute;dos&iacute;tva!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"$conf_path_abs?page=rendeles&subpage=megrendelesek\"', 1500);
			</script>";
?>