<?php 
	session_start(); 
	include "../../../config.php";
	
	$wreath_name = $_POST['wreath_name'];
	$base_wreath_type = $_POST['base_wreath_type'];
	$base_wreath_size = $_POST['base_wreath_size'];

	$left_for_us = isset($_POST['left_for_us']) ? 1 : 0; // ránk bízva

	$flowerid = array();
	$ftype = array();

	$fnum = $_SESSION['flowers'];
	$lnum = $_SESSION['leafs'];


	$ind = 1;
	for ($i=0; $i < $fnum; $i++) { 
		$ftype[$ind] = $_POST["flower$ind"];
		$fcolor[$ind] = $_POST["color$ind"];
		$fqty[$ind] = $_POST["qty$ind"];
		$fitem_price[$ind] = $_POST["itemprice$ind"];
		$ind++;
	}
	
	$ind = 1;
	for ($i=0; $i < $lnum; $i++) { 

		if (!isset($_POST["leaf$ind"])) $leaftype[$ind] = ""; else $leaftype[$ind] = $_POST["leaf$ind"];
		$leafqty[$ind] = $_POST["leafqty$ind"];
		$litem_price[$ind] = $_POST["leafitemprice$ind"];
		$ind++;
	}
	if (!isset($_POST['rezgo'])) $rezgo = 0; else $rezgo = $_POST['rezgo'];
	if (!isset($_POST['rezgoqty'])) $rezgoqty = 0; else $rezgoqty = $_POST['rezgoqty'];
	if (isset($_POST['isOfferribbon'])) {
		$offerribbon = $_POST['offerribbon'];
		$offerribboncolor = $_POST['offerribboncolor'];
		$offerfarewell = $_POST['offerfarewell'];
		$offergivers = $_POST['offergivers'];
		$ribbonprice = $_POST['ribbonprice'];
	}
	$note = $_POST['note'];
	$calcprice = (float) str_replace(' ', '', $_POST['wreathprice']);
	if (isset($_POST['endprice'])) $endprice = (float) str_replace(' ', '', $_POST['endprice']); else $endprice = 0;

	$shop_select = $_POST['shop_select'];
	if ($shop_select == 0) { // Rendelésből készítéskor 0 értéket kap
		$shop = 0;
	} else {
		$shop = $shop_select;
	}
?>

<?php 

	$user_result = mysql_query("SELECT id FROM `users` WHERE id = ".$_SESSION['logged_in']."") or die(mysql_error());

	while ($row = mysql_fetch_assoc($user_result)) {
		$uploader = $row['id'];
		$up_time = date("Y-m-d H:i:s");
	}
	if (isset($_POST['wreath_name'])) {

		$query_id = "SELECT id FROM `base_wreath` WHERE size = '$base_wreath_size'";
		$result_id = mysql_query($query_id, $conn) or die(mysql_error());
		while ($row_id = mysql_fetch_assoc($result_id)) {

			if (isset($_POST['isOfferribbon'])) {
				$ribbonid = $_POST['ribbon_id']; // eddig volt-e szalag, ha igen, melyik
				if ($ribbonid == 'NULL') { // ha NULL akkor eddig nem volt hozzá szalag
					$query_ribb = "INSERT INTO `ribbons` (`ribbon`, `ribboncolor`, `farewelltext`, `givers`, `price`) 
												VALUES ('$offerribbon', '$offerribboncolor', '$offerfarewell', '$offergivers', '$ribbonprice')";
					$result_ribb = mysql_query($query_ribb, $conn) or die(mysql_error());
					$ribbonid = mysql_insert_id();
				} else {
					$query_ribb = "UPDATE `ribbons` SET `ribbon` = '$offerribbon', `ribboncolor` = '$offerribboncolor', `farewelltext` = '$offerfarewell', `givers` = '$offergivers', `price` = '$ribbonprice' WHERE id=$ribbonid";
					$result_ribb = mysql_query($query_ribb, $conn) or die(mysql_error());
				}
			} else {
				$ribbonid = 'NULL';
			}

			$query_ins = "UPDATE `offer_wreath` SET `name` = '$wreath_name', `base_wreath_id` = ".$row_id['id'].", `calculate_price` = $calcprice, `sale_price` = $endprice, `ribbon_id` = $ribbonid, `note` = '$note', `uploader` = '$uploader', `up_time` = '$up_time', `shop` = '$shop', `left_for_us` = '$left_for_us' WHERE id = ".$_POST['offer_id']."";
			mysql_query($query_ins, $conn) or die(mysql_error());

			$query = "SELECT id FROM `offer_wreath` WHERE name = '$wreath_name' ";
			$result = mysql_query($query) or die(mysql_error());
			while ($row = mysql_fetch_assoc($result)) {
				$offer_wreath_id = $row['id'];
			}

			$query_del = "DELETE FROM `conect_flower_offer_wreath` WHERE `offer_wreath_id`='".$offer_wreath_id."'";
			$result_del = mysql_query($query_del) or die (mysql_error());

			$ind = 1;
			for ($i=0; $i < $fnum; $i++) { 

				$query_fid = "SELECT id FROM flower WHERE type = '".$ftype[$ind]."' AND color = '".$fcolor[$ind]."'";
				$result_fid = mysql_query($query_fid, $conn) or die(mysql_error());

				while ($row_fid = mysql_fetch_assoc($result_fid)) {
					$query_fins = "INSERT INTO `conect_flower_offer_wreath` (`offer_wreath_id`, `id_flower`, `priece`, `price`) VALUES ('".$offer_wreath_id."', '".$row_fid['id']."', '".$fqty[$ind]."', '".$fitem_price[$ind]."')";
					$result_fins = mysql_query($query_fins, $conn) or die(mysql_error());
				}
				$ind++;
			}
		}

		$ind = 1;
		for ($i=0; $i < $lnum; $i++) { 
			$query_leafid = "SELECT id FROM flower WHERE type = 'levél' AND color = '".$leaftype[$ind]."'";
			$result_leafid = mysql_query($query_leafid, $conn) or die(mysql_error());

			while ($row_leafid = mysql_fetch_assoc($result_leafid)) {
				$query_fins = "INSERT INTO `conect_flower_offer_wreath` (`offer_wreath_id`, `id_flower`, `priece`, `price`) VALUES ('".$offer_wreath_id."', '".$row_leafid['id']."', '".$leafqty[$ind]."', '".$litem_price[$ind]."')";
				$result_fins = mysql_query($query_fins, $conn) or die(mysql_error());
			}
			$ind++;
		}

		//if ($_POST['left_for_us_before'] == 1) { // Ha előzőleg ránk bízva volt, de már nem
			$query_rezgoid = "SELECT id FROM flower WHERE type = 'rezgő'";
			$result_rezgoid = mysql_query($query_rezgoid, $conn) or die(mysql_error());

			while ($row_rezgo = mysql_fetch_assoc($result_rezgoid)) {
				$query_rins = "INSERT INTO `conect_flower_offer_wreath` (`offer_wreath_id`, `id_flower`, `priece`, `price`) VALUES ('".$offer_wreath_id."', '".$row_rezgo['id']."', '".$rezgoqty."', '300')";
				if ($rezgoqty != 0) $result_rins = mysql_query($query_rins, $conn) or die(mysql_error());
			}
		//}

			
		if ($_GET['subpage']=="ajanlat_szerkesztes") {
			echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Aj&aacute;nlat sikeresen m&oacute;dos&iacute;tva!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			setTimeout('window.location.href=\"".$conf_path_abs."index.php?page=ajanlatok&subpage=ajanlatok\"', 1000);
			</script>";
		} else {
			echo "<script type='text/javascript'>
			document.getElementById('alertwindow').innerHTML += '<h1>Aj&aacute;nlat sikeresen m&oacute;dos&iacute;tva!</h1>';
			document.getElementById('alertwindow').style.display = 'block';
			document.getElementById('new_offer').style.display = 'none';
			setTimeout('document.getElementById(\"alertwindow\").style.display = \"none\"', 1000);
			</script>";
		}
	}
?>