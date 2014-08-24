<?php 
	session_start(); 
	include "../../../config.php";
	
	$shop_select = $_POST['shop_select'];
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
?>

<?php 
	if ($shop_select == 0) { // Rendelésből készítéskor 0 értéket kap
		$shop = 0;
	} else {
		$shop = $shop_select;
	}

	$user_result = mysql_query("SELECT id FROM `users` WHERE id = ".$_SESSION['logged_in']."") or die(mysql_error());

	while ($row = mysql_fetch_assoc($user_result)) {
		$uploader = $row['id'];
		$up_time = date("Y-m-d H:i:s");
		$up_date = date("Y-m-d");
	}
	
	if (isset($_POST['wreath_name'])) {

		$query_isExist = "SELECT name FROM offer_wreath WHERE name='$wreath_name';";
		$result_isExist = mysql_query($query_isExist);

		if(mysql_num_rows($result_isExist) > 0){
			$wreath_isExist = true;
			echo "<script type=\"text/javascript\">
		document.getElementById('alertwindow').innerHTML += '<h1>Ez az Aj&aacute;nlat m&aacute;r l&eacute;tezik!</h1>';
		document.getElementById('alertwindow').style.display = 'block';
		setTimeout('document.getElementById(\"alertwindow\").style.display = \"none\"', 1500);
		</script>";
		} else {
			$wreath_isExist = false;
		}

		if (!$wreath_isExist) {

			$query_id = "SELECT id FROM  `base_wreath` WHERE size = \"$base_wreath_size\"";
			$result_id = mysql_query($query_id, $conn) or die(mysql_error());
			while ($row_id = mysql_fetch_assoc($result_id)) {
				
				if (isset($_POST['isOfferribbon'])) {
					$query_ribb = "INSERT INTO `ribbons` (`ribbon`, `ribboncolor`, `farewelltext`, `givers`, `price`) 
												VALUES ('$offerribbon', '$offerribboncolor', '$offerfarewell', '$offergivers', '$ribbonprice')";
					$result_ribb = mysql_query($query_ribb, $conn) or die(mysql_error());
					$ribbonid = mysql_insert_id();
				} else {
					$ribbonid = 'NULL';
				}

				if (isset($_POST['r_ajanlat'])) {
					if ($ribbonid == 'NULL') {
						$query_ins = "INSERT INTO `offer_wreath` (`name`, `base_wreath_id`, `calculate_price`, `sale_price`, `ribbon_id`, `note`, `uploader`, `up_time`, `shop`, `is_order`, `left_for_us`) VALUES ('$wreath_name','".$row_id['id']."','$calcprice','$endprice', $ribbonid, '$note', '$uploader', '$up_time', '$shop', 1, '$left_for_us')";
					} else {
						$query_ins = "INSERT INTO `offer_wreath` (`name`, `base_wreath_id`, `calculate_price`, `sale_price`, `ribbon_id`, `note`, `uploader`, `up_time`, `shop`, `is_order`, `left_for_us`) VALUES ('$wreath_name','".$row_id['id']."','$calcprice','$endprice', '$ribbonid', '$note', '$uploader', '$up_time', '$shop', 1, '$left_for_us')";
					}
				} else {
					if ($ribbonid == 'NULL') {
						$query_ins = "INSERT INTO `offer_wreath` (`name`, `base_wreath_id`, `calculate_price`, `sale_price`, `ribbon_id`, `note`, `uploader`, `up_time`, `shop`, `is_order`, `left_for_us`) VALUES ('$wreath_name','".$row_id['id']."','$calcprice','$endprice', $ribbonid, '$note', '$uploader', '$up_time', '$shop', 0, '$left_for_us')";
					} else {
						$query_ins = "INSERT INTO `offer_wreath` (`name`, `base_wreath_id`, `calculate_price`, `sale_price`, `ribbon_id`, `note`, `uploader`, `up_time`, `shop`, `is_order`, `left_for_us`) VALUES ('$wreath_name','".$row_id['id']."','$calcprice','$endprice', '$ribbonid', '$note', '$uploader', '$up_time', '$shop', 0, '$left_for_us')";
					}
				}
				mysql_query($query_ins, $conn) or die(mysql_error());

				if ($left_for_us == 0) { // Ha nincs ránk bízva, csak akkor kellenek virágok + levelek
					$ind = 1;
					for ($i=0; $i < $fnum; $i++) { 
						$query_fid = "SELECT id FROM flower WHERE type = \"".$ftype[$ind]."\" AND color = \"".$fcolor[$ind]."\";";
						$result_fid = mysql_query($query_fid, $conn) or die(mysql_error());

						$query_swid = "SELECT id FROM  `offer_wreath` ORDER BY id DESC LIMIT 0, 1;";
						$result_swid = mysql_query($query_swid, $conn) or die(mysql_error());
						while ($row_swid = mysql_fetch_assoc($result_swid)) {
							$swid = $row_swid['id'];
							while ($row_fid = mysql_fetch_assoc($result_fid)) {
								$query_fins = "INSERT INTO `conect_flower_offer_wreath` (`offer_wreath_id`, `id_flower`, `priece`, `price`) 
									VALUES ('".$swid."', '".$row_fid['id']."', '".$fqty[$ind]."', '".$fitem_price[$ind]."')";
								$result_fins = mysql_query($query_fins, $conn) or die(mysql_error());
							}
						}
						$ind++;
					}

					$ind = 1;
					for ($i=0; $i < $lnum; $i++) { 
						$query_leafid = "SELECT id FROM flower WHERE type = \"levél\" AND color = \"".$leaftype[$ind]."\";";
						$result_leafid = mysql_query($query_leafid, $conn) or die(mysql_error());

						$query_swid = "SELECT id FROM  `offer_wreath` ORDER BY id DESC LIMIT 0, 1;";
						$result_swid = mysql_query($query_swid, $conn) or die(mysql_error());
						while ($row_swid = mysql_fetch_assoc($result_swid)) {
							$swid = $row_swid['id'];
							while ($row_leafid = mysql_fetch_assoc($result_leafid)) {
								$query_fins = "INSERT INTO `conect_flower_offer_wreath` (`offer_wreath_id`, `id_flower`, `priece`, `price`) 
									VALUES ('".$swid."', '".$row_leafid['id']."', '".$leafqty[$ind]."', '".$litem_price[$ind]."')";
								$result_fins = mysql_query($query_fins, $conn) or die(mysql_error());
							}
						}
						$ind++;
					}

					$query_rezgoid = "SELECT id FROM flower WHERE type = \"rezgő\";";
					$result_rezgoid = mysql_query($query_rezgoid, $conn) or die(mysql_error());

					$query_swid = "SELECT id FROM  `offer_wreath` ORDER BY id DESC LIMIT 0, 1;";
					$result_swid = mysql_query($query_swid, $conn) or die(mysql_error());

					while ($row_swid = mysql_fetch_assoc($result_swid)) {
						$swid = $row_swid['id'];
						while ($row_rezgo = mysql_fetch_assoc($result_rezgoid)) {
							$query_rins = "INSERT INTO `conect_flower_offer_wreath` (`offer_wreath_id`, `id_flower`, `priece`, `price`) 
								VALUES ('".$swid."', '".$row_rezgo['id']."', '".$rezgoqty."', '300')";
							if ($rezgoqty != 0) $result_rins = mysql_query($query_rins, $conn) or die(mysql_error());
						}
					}
				}
			}

			if (isset($_GET['ajanlat_id'])) $ajanlatid = $_GET['ajanlat_id'];

			if (isset($_POST['r_ajanlat'])) { // Ha rendelés közben veszik fel az új ajánlatot
				echo "<script type='text/javascript'>
				document.getElementById('offernum').value = $ajanlatid;
				$('<option value=\'$wreath_name\' selected>$wreath_name - $up_date</option>').insertAfter('#first_option$ajanlatid');
				document.getElementById('new_offer').style.display = 'none';
				document.getElementById('alertwindow').innerHTML += '<h1>Aj&aacute;nlat hozz&aacute;adva az adatb&aacute;zishoz!</h1>';
				document.getElementById('alertwindow').style.display = 'block';
				setTimeout('document.getElementById(\"alertwindow\").style.display = \"none\"', 1500);
				</script>";
			} else {
				echo "<script type=\"text/javascript\">
				document.getElementById('alertwindow').innerHTML += '<h1>Aj&aacute;nlat hozz&aacute;adva az adatb&aacute;zishoz!</h1>';
				document.getElementById('alertwindow').style.display = 'block';
				setTimeout('window.location.href=\"".$conf_path_abs."index.php?page=ajanlatok&subpage=ajanlatok\"', 1500);
				</script>";
			}
		}
	}
?>