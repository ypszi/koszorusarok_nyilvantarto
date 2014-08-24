<?php
	session_start();
	include '../../../config.php';

	$wreathNum = $_SESSION['wreathNum'];
	$offerNum = $_SESSION['offerNum'];

	$order_note = $_SESSION['order_note'];
	$shopname = $_SESSION['shopname'];
	$customer_name = $_SESSION['customer_name'];
	$phone_num = $_SESSION['phone_num'];
	$email = $_SESSION['email'];
	$deadname = $_SESSION['dead_name'];
	$ritualdate = $_SESSION['ritual_date'];
	$ritualtime = $_SESSION['ritual_time'];
	$shipment = $_SESSION['shipment'];
	$clocation = $_SESSION['clocation'];
	$caddress = $_SESSION['caddress'];
	$cfuneral = $_SESSION['cfuneral'];

	$generated_id = $_SESSION['generated_id'];

	/*
	$_SESSION['wreath'][$ind];
	$_SESSION['azonosito'][$ind];
	$_SESSION['ribbon'][$ind];
	$_SESSION['ribboncolor'][$ind];
	$_SESSION['farewelltext'][$ind];
	$_SESSION['givers'][$ind];

	$_SESSION['offer'][$ind];
	$_SESSION['offerazonosito'][$ind];
	$_SESSION['offerribbon'][$ind];
	$_SESSION['offerribboncolor'][$ind];
	$_SESSION['offerfarewell'][$ind];
	$_SESSION['offergivers'][$ind];
	*/

	$ship_price = substr($_SESSION['ship_price'], 0, -2);	
	$ship_price = str_replace(' ', '', $ship_price);
	$price = substr($_SESSION['price'], 0, -2);	// Levágja a 'Ft' -ot a végéről
	$price = str_replace(' ', '', $price);			// Lecseréli a space charactereket
	$downprice = $_SESSION['downprice'];
//	$remainder = substr($_SESSION['remainder'], 0, -2);
//	$remainder = str_replace(' ', '', $remainder);

	$user_result = mysql_query("SELECT id FROM `users` WHERE id = ".$_SESSION['logged_in']."") or die(mysql_error());

	while ($row = mysql_fetch_assoc($user_result)) {
		$uploader = $row['id'];
	}

	$query_cid = "SELECT id FROM `orders` ORDER BY id DESC LIMIT 0,1";
	$result_cid = mysql_query($query_cid) or die(mysql_error());
	$resultnum = mysql_num_rows($result_cid); 
	if ($resultnum < 1){ 
		$order_id = 1;
	} else {
		while ($row = mysql_fetch_assoc($result_cid)) {
			$order_id = $row['id']+1;
		}
	}

	$date = date_create();
	$create_time = date_format($date, 'Y-m-d H:i:s');

	$query = "SELECT id FROM `shops` WHERE name = '$shopname'";
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		$shop_id = $row['id'];
	}

	if ($_SESSION['paid'] == ""){
		$query_customer = "INSERT INTO `orders` (id, deadname, ritual_time, shipment, clocation, caddress, cfuneral, customer_name, phone_number, email, create_time, worker_id, note, price, downprice, ship_price, paid, shop, maker_shop) 
		VALUES ('$order_id', '$deadname', '$ritualdate $ritualtime', '$shipment', '$clocation', '$caddress', '$cfuneral', '$customer_name', '$phone_num', '$email', '$create_time', '$uploader', '$order_note', '$price', '$downprice', '$ship_price', NULL, '$shop_id', '$shop_id')";
	} else {
		$paid = date("Y-m-d");
		$query_customer = "INSERT INTO `orders` (id, deadname, ritual_time, shipment, clocation, caddress, cfuneral, customer_name, phone_number, email, create_time, worker_id, note, price, downprice, ship_price, paid, shop, maker_shop) 
		VALUES ('$order_id', '$deadname', '$ritualdate $ritualtime', '$shipment', '$clocation', '$caddress', '$cfuneral', '$customer_name', '$phone_num', '$email', '$create_time', '$uploader', '$order_note', '$price', '$downprice', '$ship_price', '$paid', '$shop_id', '$shop_id')";
	}

	
	$result_customer = mysql_query($query_customer) or die(mysql_error());

	$ind = 1;
	for ($i=0; $i < $wreathNum; $i++) { 
		if (isset($_SESSION["isRibbon"][$ind])) {
			$query_ribb = "INSERT INTO `ribbons` (`ribbon`, `ribboncolor`, `farewelltext`, `givers`) VALUES ('".$_SESSION['ribbon'][$ind]."', '".$_SESSION['ribboncolor'][$ind]."', '".$_SESSION['farewelltext'][$ind]."', '".$_SESSION['givers'][$ind]."');";
			$result_ribb = mysql_query($query_ribb, $conn) or die(mysql_error());
			$ribbon_id = mysql_insert_id();
		} else {
			$ribbon_id = 'NULL';
		}

		$query = " INSERT INTO `order_items` (order_id, is_offer, wreath_name, azonosito, ribbon_id) 
			VALUES ('$order_id', '0', '".$_SESSION['wreath'][$ind]."', '".$_SESSION['azonosito'][$ind]."', $ribbon_id)";
		$result = mysql_query($query) or die(mysql_error());
		$ind++;
	}
	
	$ind = 1;
	for ($i=0; $i < $offerNum; $i++) { 
		$query_ribbid = "SELECT ribbon_id FROM  `offer_wreath` WHERE name='".$_SESSION['offer'][$ind]."';";
		$result_ribbid = mysql_query($query_ribbid, $conn) or die(mysql_error());
		while ($row = mysql_fetch_assoc($result_ribbid)) {
			$ribbon_id = is_null($row['ribbon_id']) ? 'NULL' : $row['ribbon_id'];
		}
		$query = " INSERT INTO `order_items` (order_id, is_offer, wreath_name, azonosito, ribbon_id) 
			VALUES ('$order_id', '1', '".$_SESSION['offer'][$ind]."', '".$_SESSION['offerazonosito'][$ind]."', $ribbon_id)";
		$result = mysql_query($query) or die(mysql_error());
		$ind++;
	}

	mysql_query("UPDATE order_id SET type=2 WHERE id=$generated_id");
	unset($_SESSION["generated_id"]);

	// csak ONLINE működik
	echo "<script type=\"text/javascript\">
	alertwindow.innerHTML = \"<h1>Sikeres megrendelés!</h1>\";
	alertwindow.style.display = \"block\";
	window.open('http://nyilvantarto.koszorusarok.hu/menu-main/menu-order-submenu/get-order-pdf.php?id=$generated_id', '_blank');
	setTimeout('window.location.href=\"../../../index.php?page=rendeles&subpage=megrendelesek\"', 1500);
	</script>";
?>